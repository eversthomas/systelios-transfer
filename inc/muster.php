<?php
/**
 * Muster: Kategorie „Transfer“, Hilfsfunktionen für Muster-Dateien und synchronisierte Muster.
 * Die Muster selbst liegen in patterns/ (Doku 03).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Muster-Kategorie „Transfer“.
 */
function stt_muster_kategorie() {
	register_block_pattern_category(
		'stt-transfer',
		array( 'label' => __( 'Transfer', 'systelios-transfer' ) )
	);
}
add_action( 'init', 'stt_muster_kategorie' );

/**
 * Anhang-ID anhand eines Teils des Dateinamens finden (Mediathek).
 * Muster referenzieren Bilder so, damit sie lokal wie live funktionieren; fehlt das Bild, wird es weggelassen.
 *
 * @param string $teil Teil des Dateinamens.
 * @return int 0, wenn nichts gefunden wurde.
 */
function stt_anhang_nach_name( $teil ) {
	static $zwischenspeicher = array();
	if ( isset( $zwischenspeicher[ $teil ] ) ) {
		return $zwischenspeicher[ $teil ];
	}
	$treffer = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'key'     => '_wp_attached_file',
					'value'   => $teil,
					'compare' => 'LIKE',
				),
			),
		)
	);
	$zwischenspeicher[ $teil ] = $treffer ? (int) $treffer[0] : 0;
	return $zwischenspeicher[ $teil ];
}

/**
 * Bild-Block als Markup. Ohne Anhang: leerer Bild-Block (Platzhalter im Editor) oder nichts.
 *
 * @param int    $id          Anhang-ID.
 * @param bool   $platzhalter true = ohne Bild einen leeren Bild-Block liefern.
 * @param string $groesse     Bildgröße.
 * @param string $alt         Alt-Text, falls die Mediathek keinen hat.
 * @param string $link        Optionales Linkziel des Bildes.
 * @return string
 */
function stt_bild_block( $id, $platzhalter = false, $groesse = 'large', $alt = '', $link = '' ) {
	$id  = (int) $id;
	$url = $id ? wp_get_attachment_image_url( $id, $groesse ) : '';
	if ( ! $url ) {
		return $platzhalter ? "<!-- wp:image -->\n<figure class=\"wp-block-image\"><img alt=\"\"/></figure>\n<!-- /wp:image -->" : '';
	}
	$mediathek_alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
	$alt           = '' !== $mediathek_alt ? $mediathek_alt : $alt;
	$bild          = sprintf( '<img src="%1$s" alt="%2$s" class="wp-image-%3$d"/>', esc_url( $url ), esc_attr( $alt ), $id );
	$attribute     = array(
		'id'              => $id,
		'sizeSlug'        => $groesse,
		'linkDestination' => '' !== $link ? 'custom' : 'none',
	);
	if ( '' !== $link ) {
		$bild = sprintf( '<a href="%s">%s</a>', esc_url( $link ), $bild );
	}
	return sprintf(
		"<!-- wp:image %1\$s -->\n<figure class=\"wp-block-image size-%2\$s\">%3\$s</figure>\n<!-- /wp:image -->",
		wp_json_encode( $attribute, JSON_UNESCAPED_SLASHES ),
		esc_attr( $groesse ),
		$bild
	);
}

/**
 * Adresse einer Seite anhand ihres Slugs (post_name), egal wo sie im Seitenbaum steht.
 * Fehlt die Seite, wird ein Pfad unter der Startadresse geliefert.
 *
 * @param string $slug Slug der Seite.
 * @return string
 */
function stt_seiten_url( $slug ) {
	static $zwischenspeicher = array();
	if ( ! isset( $zwischenspeicher[ $slug ] ) ) {
		$treffer                   = get_posts(
			array(
				'post_type'      => 'page',
				'name'           => $slug,
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$zwischenspeicher[ $slug ] = $treffer ? (string) get_permalink( $treffer[0] ) : home_url( '/' . $slug . '/' );
	}
	return $zwischenspeicher[ $slug ];
}

/**
 * Adresse einer Datei in der Mediathek (z. B. PDF), relativ zum Upload-Ordner.
 * So bleibt der Verweis lokal wie live richtig; fehlt die Datei lokal, ist der Link dort nur ein toter Link.
 *
 * @param string $pfad Pfad wie 2026/01/datei.pdf.
 * @return string
 */
function stt_upload_url( $pfad ) {
	$upload = wp_get_upload_dir();
	return trailingslashit( $upload['baseurl'] ) . ltrim( $pfad, '/' );
}

/* ---------- Bausteine für Fallback-Muster (liefern gültiges Block-Markup) ---------- */

/**
 * Link als HTML. Externe Links bekommen rel="noopener".
 *
 * @param string $text   Linktext.
 * @param string $url    Ziel.
 * @param bool   $extern Externer Link?
 * @return string
 */
function stt_m_link( $text, $url, $extern = false ) {
	return sprintf( '<a href="%s"%s>%s</a>', esc_url( $url ), $extern ? ' rel="noopener"' : '', esc_html( $text ) );
}

/**
 * Absatz.
 *
 * @param string $html   Inhalt (bereits sicheres HTML, z. B. aus stt_m_link()).
 * @param string $klasse Optional: Block-Stil, z. B. is-style-lead.
 * @return string
 */
function stt_m_absatz( $html, $klasse = '' ) {
	$attr = '' !== $klasse ? ' ' . wp_json_encode( array( 'className' => $klasse ) ) : '';
	$cls  = '' !== $klasse ? ' class="' . esc_attr( $klasse ) . '"' : '';
	return "<!-- wp:paragraph{$attr} -->\n<p{$cls}>{$html}</p>\n<!-- /wp:paragraph -->";
}

/**
 * Überschrift (Standard H2), optional mit Anker.
 *
 * @param string $text   Text.
 * @param int    $ebene  2–4.
 * @param string $anker  Optionaler Anker.
 * @return string
 */
function stt_m_ueberschrift( $text, $ebene = 2, $anker = '' ) {
	$attribute = array();
	if ( 2 !== $ebene ) {
		$attribute['level'] = $ebene;
	}
	if ( '' !== $anker ) {
		$attribute['anchor'] = $anker;
	}
	$attr = $attribute ? ' ' . wp_json_encode( $attribute ) : '';
	$id   = '' !== $anker ? ' id="' . esc_attr( $anker ) . '"' : '';
	return "<!-- wp:heading{$attr} -->\n<h{$ebene} class=\"wp-block-heading\"{$id}>" . esc_html( $text ) . "</h{$ebene}>\n<!-- /wp:heading -->";
}

/**
 * Liste.
 *
 * @param string[] $eintraege Einträge als sicheres HTML.
 * @param string   $stil      Optional: Block-Stil ohne Präfix (haken, nummern-gross).
 * @param bool     $geordnet  Nummerierte Liste?
 * @return string
 */
function stt_m_liste( $eintraege, $stil = '', $geordnet = false ) {
	$attribute = array();
	$klassen   = 'wp-block-list';
	if ( $geordnet ) {
		$attribute['ordered'] = true;
	}
	if ( '' !== $stil ) {
		$attribute['className'] = 'is-style-' . $stil;
		$klassen               .= ' is-style-' . $stil;
	}
	$attr = $attribute ? ' ' . wp_json_encode( $attribute ) : '';
	$tag  = $geordnet ? 'ol' : 'ul';
	$innen = '';
	foreach ( $eintraege as $eintrag ) {
		$innen .= "<!-- wp:list-item -->\n<li>{$eintrag}</li>\n<!-- /wp:list-item -->\n\n";
	}
	return "<!-- wp:list{$attr} -->\n<{$tag} class=\"{$klassen}\">" . rtrim( $innen ) . "</{$tag}>\n<!-- /wp:list -->";
}

/**
 * Einzelner Button in einer Buttons-Gruppe.
 *
 * @param string $text  Beschriftung.
 * @param string $url   Ziel.
 * @param string $stil  Optional: umriss | dunkel.
 * @return string
 */
function stt_m_knopf( $text, $url, $stil = '' ) {
	$attr = '' !== $stil ? ' ' . wp_json_encode( array( 'className' => 'is-style-' . $stil ) ) : '';
	$cls  = '' !== $stil ? ' is-style-' . $stil : '';
	return "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button{$attr} -->\n<div class=\"wp-block-button{$cls}\"><a class=\"wp-block-button__link wp-element-button\" href=\"" . esc_url( $url ) . '">' . esc_html( $text ) . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->";
}

/**
 * Gruppe mit Klassen (Block-Stile) und beliebigem Inhalt.
 *
 * @param string $innen   Block-Markup.
 * @param string $klassen Klassen, z. B. is-style-karte hat-punkt.
 * @param string $breite  '' | wide | full.
 * @return string
 */
function stt_m_gruppe( $innen, $klassen = '', $breite = '' ) {
	$attribute = array();
	if ( '' !== $breite ) {
		$attribute['align'] = $breite;
	}
	if ( '' !== $klassen ) {
		$attribute['className'] = $klassen;
	}
	$attribute['layout'] = array( 'type' => 'constrained' );
	$cls                 = trim( 'wp-block-group' . ( '' !== $breite ? ' align' . $breite : '' ) . ( '' !== $klassen ? ' ' . $klassen : '' ) );
	return '<!-- wp:group ' . wp_json_encode( $attribute ) . " -->\n<div class=\"" . esc_attr( $cls ) . "\">{$innen}</div>\n<!-- /wp:group -->";
}

/**
 * Band über die volle Breite (warm | dunkel).
 *
 * @param string $stil   warm | dunkel.
 * @param string $innen  Block-Markup.
 * @return string
 */
function stt_m_band( $stil, $innen ) {
	return stt_m_gruppe( "\n" . $innen . "\n", 'is-style-' . $stil, 'full' );
}

/**
 * Spalten. Jede Spalte: array( 'breite' => '60%'|null, 'inhalt' => Block-Markup ).
 *
 * @param array  $spalten Spalten.
 * @param string $klasse  Optional: weitere Klasse (stt-raster).
 * @return string
 */
function stt_m_spalten( $spalten, $klasse = '' ) {
	$attribute = array( 'align' => 'wide' );
	if ( '' !== $klasse ) {
		$attribute['className'] = $klasse;
	}
	$html = '<!-- wp:columns ' . wp_json_encode( $attribute ) . " -->\n<div class=\"wp-block-columns alignwide" . ( '' !== $klasse ? ' ' . esc_attr( $klasse ) : '' ) . '">';
	foreach ( $spalten as $spalte ) {
		if ( ! empty( $spalte['breite'] ) ) {
			$html .= '<!-- wp:column ' . wp_json_encode( array( 'width' => $spalte['breite'] ) ) . " -->\n<div class=\"wp-block-column\" style=\"flex-basis:" . esc_attr( $spalte['breite'] ) . '">';
		} else {
			$html .= "<!-- wp:column -->\n<div class=\"wp-block-column\">";
		}
		$html .= $spalte['inhalt'] . "</div>\n<!-- /wp:column -->\n\n";
	}
	return rtrim( $html ) . "</div>\n<!-- /wp:columns -->";
}

/**
 * Block-Markup aus mehreren Teilen verbinden (leere Teile entfallen).
 *
 * @param string[] $teile Teile.
 * @return string
 */
function stt_m_zusammen( $teile ) {
	return implode( "\n\n", array_filter( $teile, 'strlen' ) );
}

/**
 * Sprungleiste „Auf dieser Seite“ mit Ankerlinks.
 *
 * @param array $punkte Anker => Beschriftung.
 * @return string
 */
function stt_m_sprungleiste( $punkte ) {
	$eintraege = array();
	foreach ( $punkte as $anker => $label ) {
		$eintraege[] = stt_m_link( $label, '#' . $anker );
	}
	return stt_m_gruppe(
		"\n" . stt_m_zusammen(
			array(
				stt_m_absatz( 'Auf dieser Seite', 'is-style-tag' ),
				stt_m_liste( $eintraege ),
			)
		) . "\n",
		'is-style-warm stt-klein'
	);
}

/**
 * Regionale Übersicht: je Bereich eine H2 mit Anker und eine Liste.
 * Ein Eintrag ist entweder array( 'text' => …, 'upload' => '2026/01/datei.pdf' ),
 * array( 'text' => …, 'url' => 'https://…' ) oder array( 'text' => … ) ohne Link.
 *
 * @param array $bereiche Anker => array( 'titel' => …, 'eintraege' => array(…) ).
 * @return string
 */
function stt_m_regionen( $bereiche ) {
	$teile = array();
	foreach ( $bereiche as $anker => $bereich ) {
		$eintraege = array();
		foreach ( $bereich['eintraege'] as $eintrag ) {
			if ( ! empty( $eintrag['upload'] ) ) {
				$eintraege[] = stt_m_link( $eintrag['text'], stt_upload_url( $eintrag['upload'] ) );
			} elseif ( ! empty( $eintrag['url'] ) ) {
				$eintraege[] = stt_m_link( $eintrag['text'], $eintrag['url'], true );
			} else {
				$eintraege[] = esc_html( $eintrag['text'] );
			}
		}
		$teile[] = stt_m_ueberschrift( $bereich['titel'], 2, $anker );
		$teile[] = stt_m_liste( $eintraege );
	}
	return stt_m_zusammen( $teile );
}

/**
 * Hinweis Heilkunde: das synchronisierte Muster, sonst derselbe Text als Absatz.
 *
 * @return string
 */
function stt_m_heilkunde() {
	$ref = stt_sync_muster_id( 'heilkunde' );
	if ( $ref > 0 ) {
		return '<!-- wp:block ' . wp_json_encode( array( 'ref' => $ref ) ) . ' /-->';
	}
	$definitionen = stt_sync_muster_definitionen();
	return $definitionen['heilkunde']['inhalt'];
}

/**
 * Hinweis aus der Familie: Karte in der Farbe des Hauses, auf das verwiesen wird (Doku 05, Abschnitt 2).
 *
 * @param string $kennung  Kennung des Hauses, z. B. lebensart.
 * @param string $titel    Überschrift der Karte.
 * @param string $text     Text (Platzhalter in eckigen Klammern, bis Texte vorliegen).
 * @param array  $knopf    array( 'lernreise' => 'Beschriftung' ) oder array( 'text' => …, 'url' => … ).
 * @return string
 */
function stt_m_familienhinweis( $kennung, $titel, $text, $knopf ) {
	$haus  = stt_familie_haus( $kennung );
	$name  = $haus ? $haus['rolle'] : 'sysTelios ' . strtoupper( $kennung );
	$innen = array(
		stt_m_absatz( esc_html( $name ), 'is-style-augenbraue' ),
		stt_m_ueberschrift( $titel, 3 ),
		stt_m_absatz( esc_html( $text ) ),
	);
	if ( isset( $knopf['lernreise'] ) ) {
		$innen[] = "<!-- wp:shortcode -->\n[stt_lernreise_button text=\"" . esc_attr( $knopf['lernreise'] ) . "\"]\n<!-- /wp:shortcode -->";
	} else {
		$innen[] = stt_m_knopf( $knopf['text'], $knopf['url'], 'umriss' );
	}
	return stt_m_gruppe( "\n" . stt_m_zusammen( $innen ) . "\n", 'is-style-karte ist-haus-' . sanitize_key( $kennung ) );
}

/**
 * Verbundener Anbieter: Logo mit Link, sonst nur der Name als Link.
 *
 * @param string $name   Name.
 * @param string $url    Adresse.
 * @param string $logo   Teil des Logo-Dateinamens in der Mediathek.
 * @return string
 */
function stt_m_anbieter( $name, $url, $logo ) {
	$id   = '' !== $logo ? stt_anhang_nach_name( $logo ) : 0;
	$bild = $id ? stt_bild_block( $id, false, 'medium', $name, $url ) : '';
	return '' !== $bild ? $bild : stt_m_absatz( stt_m_link( $name, $url, true ) );
}

/**
 * Abschnitt „Wirkungsfamilie und verbundene Anbieter“ (Startseite und Fußbereich der Kontaktseite).
 *
 * @return string
 */
function stt_m_familie_abschnitt() {
	$anbieter = array(
		array( 'Meta Forum Sommercamp', 'https://www.metaforum-sommercamp.com/', 'Logo-Metaforum' ),
		array( 'Milton Erickson Institut Heidelberg', 'http://www.meihei.de', 'milton-erickson-institut-heidelberg-logo' ),
		array( 'Augenhöhe (Film)', 'https://augenhoehe-film.de/', '' ),
	);
	$spalten  = array();
	foreach ( $anbieter as $a ) {
		$spalten[] = array( 'inhalt' => stt_m_anbieter( $a[0], $a[1], $a[2] ) );
	}
	return stt_m_band(
		'warm',
		stt_m_zusammen(
			array(
				stt_m_ueberschrift( 'Die sysTelios-Wirkungsfamilie und verbundene Anbieter' ),
				stt_m_absatz( 'Hier finden Sie Links zu den anderen Angeboten der sysTelios-Wirkungsfamilie sowie einigen uns sehr verbundenen Anbietern und Anbieterinnen – für weitere Impulse im hypnosystemischen und systemischen Sinne.' ),
				"<!-- wp:shortcode -->\n[stt_familie]\n<!-- /wp:shortcode -->",
				stt_m_ueberschrift( 'Verbundene Anbieter', 3 ),
				stt_m_spalten( $spalten, 'stt-anbieter' ),
			)
		)
	);
}

/**
 * Inhalte der synchronisierten Muster. Schlüssel = Kennung (Meta _stt_kennung).
 *
 * @return array
 */
function stt_sync_muster_definitionen() {
	$kontakt = esc_url( home_url( '/kontaktaufnahme/' ) );

	$kontaktflaeche = '<!-- wp:group {"align":"wide","className":"is-style-akzent","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide is-style-akzent"><!-- wp:heading -->
<h2 class="wp-block-heading">Ins Gespräch kommen</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Wir freuen uns über Ihre Nachricht und helfen Ihnen, im Netzwerk das passende Angebot oder die passende Person zu finden.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-dunkel"} -->
<div class="wp-block-button is-style-dunkel"><a class="wp-block-button__link wp-element-button" href="' . $kontakt . '">Kontakt aufnehmen</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->';

	$heilkunde = '<!-- wp:paragraph {"className":"is-style-hinweis"} -->
<p class="is-style-hinweis">Die hier unter dem Namen sysTelios TRANSFER dargestellten Angebote stellen keine Angebote der medizinischen oder therapeutischen Heilkunde dar. Wenden Sie sich dazu gerne direkt an die Kollegen und Kolleginnen, die eine entsprechende Heilerlaubnis haben. Sie können das in der Übersicht unserer Netzwerkmitglieder zunächst daran erkennen, dass bei ihnen, das Wort „Therapie“ steht. Dazu verbindliche Aussagen finden Sie auf den Webseiten der jeweiligen Kolleginnen und Kollegen.</p>
<!-- /wp:paragraph -->';

	return array(
		'kontaktflaeche' => array(
			'titel'   => 'Kontaktfläche „Ins Gespräch kommen“',
			'inhalt'  => $kontaktflaeche,
		),
		'heilkunde'      => array(
			'titel'   => 'Hinweis Heilkunde',
			'inhalt'  => $heilkunde,
		),
	);
}

/**
 * ID eines synchronisierten Musters (wp_block) anhand der Kennung.
 *
 * @param string $kennung Kennung, z. B. kontaktflaeche.
 * @return int 0, wenn es das Muster nicht gibt.
 */
function stt_sync_muster_id( $kennung ) {
	$treffer = get_posts(
		array(
			'post_type'      => 'wp_block',
			'post_status'    => array( 'publish', 'draft', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_stt_kennung', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => sanitize_key( $kennung ), // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	return $treffer ? (int) $treffer[0] : 0;
}

/**
 * Fehlende synchronisierte Muster anlegen. Vorhandene werden nie verändert.
 *
 * @return int Anzahl neu angelegter Muster.
 */
function stt_sync_muster_anlegen() {
	$neu = 0;
	foreach ( stt_sync_muster_definitionen() as $kennung => $muster ) {
		if ( stt_sync_muster_id( $kennung ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'wp_block',
				'post_status'  => 'publish',
				'post_title'   => $muster['titel'],
				'post_content' => $muster['inhalt'],
				'meta_input'   => array( '_stt_kennung' => $kennung ),
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			++$neu;
		}
	}
	return $neu;
}
add_action( 'after_switch_theme', 'stt_sync_muster_anlegen' );

/**
 * Nachholen, falls das Theme schon aktiv war (oder Muster gelöscht wurden und neu gewünscht sind):
 * einmal pro Theme-Version im Backend prüfen.
 */
function stt_sync_muster_nachholen() {
	if ( ! current_user_can( 'edit_pages' ) || get_option( 'stt_muster_version' ) === STT_VERSION ) {
		return;
	}
	stt_sync_muster_anlegen();
	update_option( 'stt_muster_version', STT_VERSION );
}
add_action( 'admin_init', 'stt_sync_muster_nachholen' );
