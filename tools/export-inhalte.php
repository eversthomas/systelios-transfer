<?php
/**
 * Export der bestehenden Inhalte von systelios-transfer.de als Grundlage für Fallback-Muster.
 *
 * Aufruf (lokale Kopie der Live-Seite, WP-CLI):
 *   wp eval-file wp-content/themes/systelios-transfer/tools/export-inhalte.php
 *   wp eval-file …/export-inhalte.php /absoluter/zielordner        (optional anderer Zielordner)
 *
 * Liest nur, schreibt nichts in die Datenbank. Elementor muss NICHT aktiv sein:
 * Die Struktur wird direkt aus `_elementor_data` gelesen. Ist Elementor aktiv, wird zusätzlich
 * das von Elementor gerenderte HTML als <slug>.elementor.html zum Vergleich abgelegt.
 *
 * Ergebnis im Zielordner:
 *   index.json        Seitenliste mit Metadaten, Shortcodes, Widgets, Bildern
 *   <slug>.html       bereinigtes Inhalts-HTML je veröffentlichter Seite
 *   menus.json        Menüs und Menüpositionen
 *   site.json         Grundeinstellungen (Startseite, Titel, Logo)
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_CLI' ) ) {
	echo "Bitte mit WP-CLI ausführen: wp eval-file …/export-inhalte.php\n";
	return;
}

/* -------------------------------------------------------------------------
 * Zielordner
 * ---------------------------------------------------------------------- */
$stt_ziel = ( isset( $args[0] ) && '' !== $args[0] )
	? rtrim( $args[0], '/\\' )
	: trailingslashit( get_theme_root() ) . 'systelios-transfer/inhalte';

if ( ! is_dir( $stt_ziel ) && ! wp_mkdir_p( $stt_ziel ) ) {
	WP_CLI::error( 'Zielordner kann nicht angelegt werden: ' . $stt_ziel );
}
WP_CLI::log( 'Zielordner: ' . $stt_ziel );

/* -------------------------------------------------------------------------
 * Hilfsfunktionen
 * ---------------------------------------------------------------------- */

/** Erlaubtes HTML für den Export. */
function stt_export_kses() {
	$a = array( 'href' => true, 'title' => true, 'target' => true, 'rel' => true );
	return array(
		'h1' => array( 'id' => true ), 'h2' => array( 'id' => true ), 'h3' => array( 'id' => true ),
		'h4' => array( 'id' => true ), 'h5' => array(), 'h6' => array(),
		'p' => array(), 'br' => array(), 'hr' => array(),
		'strong' => array(), 'b' => array(), 'em' => array(), 'i' => array(), 'u' => array(),
		'sup' => array(), 'sub' => array(), 'small' => array(),
		'ul' => array(), 'ol' => array( 'start' => true ), 'li' => array(),
		'blockquote' => array(), 'cite' => array(),
		'a' => $a,
		'img' => array( 'src' => true, 'alt' => true, 'data-id' => true, 'width' => true, 'height' => true ),
		'figure' => array(), 'figcaption' => array(),
		'table' => array(), 'thead' => array(), 'tbody' => array(), 'tr' => array(), 'th' => array(), 'td' => array(),
		'details' => array(), 'summary' => array(),
		'section' => array( 'data-abschnitt' => true ),
		'div' => array( 'data-spalte' => true ),
	);
}

/** HTML bereinigen: kses, leere Absätze, &nbsp;-Ketten. */
function stt_export_sauber( $html ) {
	$html = wp_kses( (string) $html, stt_export_kses() );
	$html = str_replace( array( "\xc2\xa0", '&nbsp;' ), ' ', $html );
	$html = preg_replace( '#<p>\s*</p>#u', '', $html );
	$html = preg_replace( "/\n{3,}/", "\n\n", $html );
	return trim( $html );
}

/** Anhang-ID zu einer URL finden (auch bei -800x600-Größen). */
function stt_export_bild_id( $url ) {
	if ( ! $url ) {
		return 0;
	}
	$id = attachment_url_to_postid( $url );
	if ( ! $id ) {
		$ohne = preg_replace( '/-\d+x\d+(?=\.[a-z0-9]+$)/i', '', $url );
		$id   = attachment_url_to_postid( $ohne );
	}
	return (int) $id;
}

/** Bild-Tag mit ID und Alt-Text. */
function stt_export_img( $id, $url, &$bilder ) {
	$id  = (int) $id;
	$url = (string) $url;
	if ( ! $id && $url ) {
		$id = stt_export_bild_id( $url );
	}
	if ( $id && ! $url ) {
		$url = (string) wp_get_attachment_url( $id );
	}
	if ( ! $url ) {
		return '';
	}
	$alt      = $id ? (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) : '';
	$bilder[] = array( 'id' => $id, 'url' => $url, 'alt' => $alt );
	return sprintf( '<img src="%s" alt="%s" data-id="%d">', esc_url( $url ), esc_attr( $alt ), $id );
}

/** Shortcodes in einem Text finden. */
function stt_export_shortcodes_finden( $text, &$shortcodes ) {
	if ( ! is_string( $text ) || false === strpos( $text, '[' ) ) {
		return;
	}
	// Auch nicht registrierte Shortcodes finden (Plugin evtl. lokal inaktiv): [name …] bzw. [name …]…[/name].
	$muster = '/\[(?!\/)([a-z][a-z0-9_-]*)(?:\s[^\[\]]*)?\](?:(?:(?!\[\/\1\]).)*\[\/\1\])?/s';
	if ( preg_match_all( $muster, $text, $treffer ) ) {
		foreach ( $treffer[0] as $sc ) {
			$shortcodes[] = trim( $sc );
		}
	}
}

/**
 * Elementor-Elementbaum in einfaches HTML übersetzen.
 *
 * @param array $elemente   Elemente einer Ebene.
 * @param array $kontext    Sammelt shortcodes, widgets, bilder, hinweise (per Referenz).
 * @param int   $tiefe      Verschachtelungstiefe.
 * @return string
 */
function stt_export_elementor( $elemente, &$kontext, $tiefe = 0 ) {
	$html = '';
	foreach ( (array) $elemente as $el ) {
		if ( ! is_array( $el ) ) {
			continue;
		}
		$typ    = isset( $el['elType'] ) ? $el['elType'] : '';
		$s      = isset( $el['settings'] ) && is_array( $el['settings'] ) ? $el['settings'] : array();
		$kinder = isset( $el['elements'] ) ? $el['elements'] : array();

		if ( 'widget' !== $typ ) {
			// section, column, container: Struktur andeuten, Inhalt rekursiv.
			$innen = stt_export_elementor( $kinder, $kontext, $tiefe + 1 );
			if ( '' === trim( $innen ) ) {
				continue;
			}
			if ( 0 === $tiefe ) {
				$html .= "\n<section data-abschnitt=\"" . esc_attr( $typ ) . "\">\n" . $innen . "\n</section>\n";
			} elseif ( 'column' === $typ || ( 'container' === $typ && count( $kinder ) > 0 ) ) {
				$html .= "\n<div data-spalte=\"" . esc_attr( $typ ) . "\">\n" . $innen . "\n</div>\n";
			} else {
				$html .= $innen;
			}
			continue;
		}

		$w                     = isset( $el['widgetType'] ) ? $el['widgetType'] : 'unbekannt';
		$kontext['widgets'][]  = $w;
		$link                  = function ( $l ) {
			return ( is_array( $l ) && ! empty( $l['url'] ) ) ? (string) $l['url'] : '';
		};

		switch ( $w ) {
			case 'heading':
				$tag   = ( isset( $s['header_size'] ) && preg_match( '/^h[1-6]$/', $s['header_size'] ) ) ? $s['header_size'] : 'h2';
				$titel = isset( $s['title'] ) ? $s['title'] : '';
				$url   = $link( $s['link'] ?? null );
				$innen = $url ? '<a href="' . esc_url( $url ) . '">' . $titel . '</a>' : $titel;
				$html .= "<{$tag}>{$innen}</{$tag}>\n";
				break;

			case 'text-editor':
				$text = isset( $s['editor'] ) ? $s['editor'] : '';
				stt_export_shortcodes_finden( $text, $kontext['shortcodes'] );
				$html .= wpautop( $text ) . "\n";
				break;

			case 'image':
				$bild  = isset( $s['image'] ) && is_array( $s['image'] ) ? $s['image'] : array();
				$img   = stt_export_img( $bild['id'] ?? 0, $bild['url'] ?? '', $kontext['bilder'] );
				$cap   = ! empty( $s['caption'] ) ? '<figcaption>' . $s['caption'] . '</figcaption>' : '';
				$url   = $link( $s['link'] ?? null );
				if ( $img ) {
					$img   = $url ? '<a href="' . esc_url( $url ) . '">' . $img . '</a>' : $img;
					$html .= "<figure>{$img}{$cap}</figure>\n";
				}
				break;

			case 'image-box':
				$bild  = isset( $s['image'] ) && is_array( $s['image'] ) ? $s['image'] : array();
				$html .= stt_export_img( $bild['id'] ?? 0, $bild['url'] ?? '', $kontext['bilder'] ) . "\n";
				if ( ! empty( $s['title_text'] ) ) {
					$html .= '<h3>' . $s['title_text'] . "</h3>\n";
				}
				if ( ! empty( $s['description_text'] ) ) {
					$html .= wpautop( $s['description_text'] ) . "\n";
				}
				break;

			case 'icon-box':
				if ( ! empty( $s['title_text'] ) ) {
					$html .= '<h3>' . $s['title_text'] . "</h3>\n";
				}
				if ( ! empty( $s['description_text'] ) ) {
					$html .= wpautop( $s['description_text'] ) . "\n";
				}
				break;

			case 'button':
				$text  = isset( $s['text'] ) ? $s['text'] : '';
				$url   = $link( $s['link'] ?? null );
				$html .= '<p><a href="' . esc_url( $url ) . '">' . $text . "</a></p>\n";
				$kontext['hinweise'][] = 'Button: ' . wp_strip_all_tags( $text ) . ' → ' . $url;
				break;

			case 'icon-list':
				$html .= "<ul>\n";
				foreach ( (array) ( $s['icon_list'] ?? array() ) as $punkt ) {
					$text  = $punkt['text'] ?? '';
					$url   = $link( $punkt['link'] ?? null );
					$html .= '<li>' . ( $url ? '<a href="' . esc_url( $url ) . '">' . $text . '</a>' : $text ) . "</li>\n";
				}
				$html .= "</ul>\n";
				break;

			case 'shortcode':
				$sc = isset( $s['shortcode'] ) ? trim( (string) $s['shortcode'] ) : '';
				if ( $sc ) {
					$kontext['shortcodes'][] = $sc;
					$html .= "\n<!-- SHORTCODE -->\n" . $sc . "\n<!-- /SHORTCODE -->\n";
				}
				break;

			case 'image-gallery':
			case 'gallery':
			case 'media-carousel':
			case 'image-carousel':
				$liste = $s['wp_gallery'] ?? ( $s['gallery'] ?? ( $s['carousel'] ?? ( $s['slides'] ?? array() ) ) );
				$html .= "<!-- GALERIE ({$w}) -->\n";
				foreach ( (array) $liste as $b ) {
					$b     = isset( $b['image'] ) && is_array( $b['image'] ) ? $b['image'] : $b;
					$html .= stt_export_img( $b['id'] ?? 0, $b['url'] ?? '', $kontext['bilder'] ) . "\n";
				}
				break;

			case 'accordion':
			case 'toggle':
				foreach ( (array) ( $s['tabs'] ?? array() ) as $tab ) {
					$html .= '<details><summary>' . ( $tab['tab_title'] ?? '' ) . '</summary>' . wpautop( $tab['tab_content'] ?? '' ) . "</details>\n";
					stt_export_shortcodes_finden( $tab['tab_content'] ?? '', $kontext['shortcodes'] );
				}
				break;

			case 'form':
				$felder = array();
				foreach ( (array) ( $s['form_fields'] ?? array() ) as $f ) {
					$felder[] = ( $f['field_label'] ?? ( $f['custom_id'] ?? '?' ) ) . ' [' . ( $f['field_type'] ?? 'text' ) . ( ! empty( $f['required'] ) ? ', Pflicht' : '' ) . ']';
				}
				$kontext['hinweise'][] = 'Formular: ' . implode( '; ', $felder );
				$html .= "\n<!-- FORMULAR: " . esc_html( implode( '; ', $felder ) ) . " -->\n";
				break;

			case 'html':
				$roh = isset( $s['html'] ) ? (string) $s['html'] : '';
				stt_export_shortcodes_finden( $roh, $kontext['shortcodes'] );
				$kontext['hinweise'][] = 'HTML-Widget vorhanden (Inhalt als Kommentar im Export)';
				$html .= "\n<!-- HTML-WIDGET\n" . esc_html( $roh ) . "\n-->\n";
				break;

			case 'video':
				$url   = $s['youtube_url'] ?? ( $s['vimeo_url'] ?? ( $s['hosted_url']['url'] ?? '' ) );
				$html .= '<p><a href="' . esc_url( (string) $url ) . '">[Video]</a></p>' . "\n";
				break;

			case 'divider':
				$html .= "<hr>\n";
				break;

			case 'spacer':
			case 'menu-anchor':
				break;

			case 'global':
				$kontext['hinweise'][] = 'Globales Widget (templateID ' . ( $el['templateID'] ?? '?' ) . ') – Inhalt separat prüfen';
				$html .= "<!-- GLOBALES WIDGET -->\n";
				break;

			case 'template':
				$kontext['hinweise'][] = 'Elementor-Vorlage eingebunden (template_id ' . ( $s['template_id'] ?? '?' ) . ')';
				$html .= "<!-- ELEMENTOR-VORLAGE -->\n";
				break;

			default:
				// Unbekanntes Widget: alle Textwerte als Hinweis sichern.
				$texte = array();
				array_walk_recursive(
					$s,
					function ( $wert, $schluessel ) use ( &$texte ) {
						if ( is_string( $wert ) && strlen( wp_strip_all_tags( $wert ) ) > 2 && ! preg_match( '/^(#|rgba?\(|\d|px|em|yes|no)/', $wert ) && preg_match( '/(text|title|content|editor|description|label)/', (string) $schluessel ) ) {
							$texte[] = $wert;
						}
					}
				);
				$kontext['hinweise'][] = "Unbekanntes Widget „{$w}“";
				$html .= "<!-- UNBEKANNT: {$w} -->\n" . ( $texte ? wpautop( implode( "\n\n", $texte ) ) . "\n" : '' );
		}
	}
	return $html;
}

/* -------------------------------------------------------------------------
 * Seiten exportieren
 * ---------------------------------------------------------------------- */
$stt_index       = array();
$stt_front       = (int) get_option( 'page_on_front' );
$stt_elementor_an = did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' );

$stt_seiten = get_posts(
	array(
		'post_type'      => 'page',
		'post_status'    => array( 'publish', 'private', 'draft' ),
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	)
);

foreach ( $stt_seiten as $stt_seite ) {
	$id        = (int) $stt_seite->ID;
	$slug      = $stt_seite->post_name ? $stt_seite->post_name : 'seite-' . $id;
	$elementor = 'builder' === get_post_meta( $id, '_elementor_edit_mode', true );
	$kontext   = array( 'shortcodes' => array(), 'widgets' => array(), 'bilder' => array(), 'hinweise' => array() );

	$eintrag = array(
		'id'           => $id,
		'slug'         => $slug,
		'pfad'         => get_page_uri( $id ),
		'titel'        => html_entity_decode( get_the_title( $id ), ENT_QUOTES, 'UTF-8' ),
		'status'       => $stt_seite->post_status,
		'eltern'       => $stt_seite->post_parent ? get_post_field( 'post_name', $stt_seite->post_parent ) : '',
		'menu_order'   => (int) $stt_seite->menu_order,
		'vorlage'      => (string) get_page_template_slug( $id ),
		'startseite'   => $id === $stt_front,
		'elementor'    => $elementor,
		'excerpt'      => (string) $stt_seite->post_excerpt,
		'thumbnail_id' => (int) get_post_thumbnail_id( $id ),
		'geaendert'    => $stt_seite->post_modified,
		'datei'        => '',
	);

	if ( 'publish' !== $stt_seite->post_status ) {
		$stt_index[] = $eintrag;
		continue;
	}

	if ( $elementor ) {
		$daten = json_decode( (string) get_post_meta( $id, '_elementor_data', true ), true );
		$html  = is_array( $daten ) ? stt_export_elementor( $daten, $kontext ) : '';
		if ( ! $html ) {
			$kontext['hinweise'][] = 'Elementor-Daten leer oder unlesbar – post_content verwendet';
			$html                  = $stt_seite->post_content;
		}
		if ( $stt_elementor_an ) {
			try {
				$gerendert = \Elementor\Plugin::instance()->frontend->get_builder_content( $id, false );
				if ( $gerendert ) {
					file_put_contents( $stt_ziel . '/' . $slug . '.elementor.html', $gerendert ); // phpcs:ignore WordPress.WP.AlternativeFunctions
				}
			} catch ( \Throwable $e ) {
				$kontext['hinweise'][] = 'Elementor-Rendering fehlgeschlagen: ' . $e->getMessage();
			}
		}
	} else {
		$html = $stt_seite->post_content;
		stt_export_shortcodes_finden( $html, $kontext['shortcodes'] );
		if ( has_blocks( $html ) ) {
			$kontext['hinweise'][] = 'Seite besteht bereits aus Blöcken – Block-Markup unverändert in <slug>.bloecke.html';
			file_put_contents( $stt_ziel . '/' . $slug . '.bloecke.html', $html ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		}
		if ( preg_match_all( '/<img[^>]+src="([^"]+)"/i', $html, $m ) ) {
			foreach ( $m[1] as $u ) {
				stt_export_img( 0, $u, $kontext['bilder'] );
			}
		}
	}

	// Shortcodes aus dem HTML-Text wieder lesbar machen (oben für den Export escaped).
	$html  = str_replace( array( '&#091;', '&#093;' ), array( '[', ']' ), $html );
	$sauber = stt_export_sauber( $html );
	// Kommentare (Shortcodes, Formulare, Hinweise) bleiben erhalten – kses entfernt sie nicht.

	$kopf  = "<!--\n  Export: " . gmdate( 'Y-m-d H:i' ) . " UTC\n  Seite: {$eintrag['titel']} (ID {$id}, /{$eintrag['pfad']}/)\n  Elementor: " . ( $elementor ? 'ja' : 'nein' ) . "\n-->\n";
	$datei = $slug . '.html';
	file_put_contents( $stt_ziel . '/' . $datei, $kopf . $sauber . "\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions

	$eintrag['datei']      = $datei;
	$eintrag['shortcodes'] = array_values( array_unique( $kontext['shortcodes'] ) );
	$eintrag['widgets']    = array_count_values( $kontext['widgets'] );
	$eintrag['bilder']     = array_values( array_unique( $kontext['bilder'], SORT_REGULAR ) );
	$eintrag['hinweise']   = array_values( array_unique( $kontext['hinweise'] ) );
	$stt_index[]           = $eintrag;

	WP_CLI::log( sprintf( '  %-32s %s%s', $slug, $elementor ? 'Elementor' : 'Inhalt', $eintrag['shortcodes'] ? '  Shortcodes: ' . implode( ' ', $eintrag['shortcodes'] ) : '' ) );
}

/* -------------------------------------------------------------------------
 * Menüs und Grundeinstellungen
 * ---------------------------------------------------------------------- */
$stt_menues = array( 'positionen' => get_nav_menu_locations(), 'menues' => array() );
foreach ( wp_get_nav_menus() as $menue ) {
	$punkte = array();
	foreach ( (array) wp_get_nav_menu_items( $menue->term_id ) as $p ) {
		$punkte[] = array(
			'id'     => (int) $p->ID,
			'eltern' => (int) $p->menu_item_parent,
			'titel'  => $p->title,
			'url'    => $p->url,
			'typ'    => $p->type,
			'objekt' => $p->object,
			'ziel'   => (int) $p->object_id,
		);
	}
	$stt_menues['menues'][] = array( 'id' => (int) $menue->term_id, 'name' => $menue->name, 'slug' => $menue->slug, 'punkte' => $punkte );
}

$stt_site = array(
	'name'          => get_bloginfo( 'name' ),
	'beschreibung'  => get_bloginfo( 'description' ),
	'home'          => home_url( '/' ),
	'show_on_front' => get_option( 'show_on_front' ),
	'page_on_front' => $stt_front,
	'page_for_posts' => (int) get_option( 'page_for_posts' ),
	'custom_logo'   => (int) get_theme_mod( 'custom_logo' ),
	'site_icon'     => (int) get_option( 'site_icon' ),
	'privacy_page'  => (int) get_option( 'wp_page_for_privacy_policy' ),
	'plugins_aktiv' => array_values( (array) get_option( 'active_plugins', array() ) ),
	'export'        => gmdate( 'c' ),
);

$stt_flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
file_put_contents( $stt_ziel . '/index.json', wp_json_encode( $stt_index, $stt_flags ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
file_put_contents( $stt_ziel . '/menus.json', wp_json_encode( $stt_menues, $stt_flags ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
file_put_contents( $stt_ziel . '/site.json', wp_json_encode( $stt_site, $stt_flags ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions

WP_CLI::success( count( $stt_index ) . ' Seiten exportiert nach ' . $stt_ziel );
