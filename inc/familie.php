<?php
/**
 * Wirkungsfamilie: Daten und Ausgabe der Familienleiste.
 * stt_familie_daten() ist die EINZIGE Stelle, die die Daten liefert – später austauschbar gegen die
 * REST-Schnittstelle von LEBENSART (Stufe 2, docs/05-familie-newsletter-lernreise-seo.md).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Voreinstellung, solange in den Einstellungen nichts gespeichert ist.
 * ENTSCHEIDUNG D6: Namen, Reihenfolge und Farben stammen aus dem LEBENSART-Plugin und werden von Tom geliefert;
 * bis dahin Platzhalter (Transfer in der Hausfarbe, alle anderen Grau).
 *
 * @return array
 */
function stt_familie_standard() {
	return array(
		array(
			'kennung'      => 'klinik',
			'rolle'        => 'sysTelios KLINIK',
			'zuschreibung' => '',
			'hex'          => '#6F6E6E',
			'textfarbe'    => '#FFFFFF',
			'link'         => 'https://www.systelios.de/klinik',
			'logo'         => 0,
			'wir'          => false,
		),
		array(
			'kennung'      => 'akademie',
			'rolle'        => 'sysTelios AKADEMIE',
			'zuschreibung' => '',
			'hex'          => '#6F6E6E',
			'textfarbe'    => '#FFFFFF',
			'link'         => 'https://www.systelios-akademie.de/',
			'logo'         => 0,
			'wir'          => false,
		),
		array(
			'kennung'      => 'transfer',
			'rolle'        => 'sysTelios TRANSFER',
			'zuschreibung' => '',
			'hex'          => '#F6A500',
			'textfarbe'    => '#1F2A2F',
			'link'         => '',
			'logo'         => 0,
			'wir'          => true,
		),
		array(
			'kennung'      => 'lebensart',
			'rolle'        => 'sysTelios LEBENSART',
			'zuschreibung' => '',
			'hex'          => '#6F6E6E',
			'textfarbe'    => '#FFFFFF',
			'link'         => 'https://www.systelios-lebensart.de/',
			'logo'         => 0,
			'wir'          => false,
		),
	);
}

/**
 * Die Häuser der Wirkungsfamilie in der gespeicherten Reihenfolge.
 * Felder je Haus: kennung, rolle, zuschreibung, hex, textfarbe, link (leer = ohne Website), logo, wir.
 *
 * @return array
 */
function stt_familie_daten() {
	$gespeichert = get_option( 'stt_familie' );
	$zeilen      = is_array( $gespeichert ) && $gespeichert ? $gespeichert : stt_familie_standard();
	$haeuser     = array();
	foreach ( $zeilen as $zeile ) {
		if ( ! is_array( $zeile ) || empty( $zeile['rolle'] ) ) {
			continue;
		}
		$haeuser[] = wp_parse_args(
			$zeile,
			array(
				'kennung'      => '',
				'rolle'        => '',
				'zuschreibung' => '',
				'hex'          => '#6F6E6E',
				'textfarbe'    => '#FFFFFF',
				'link'         => '',
				'logo'         => 0,
				'wir'          => false,
			)
		);
	}
	return (array) apply_filters( 'stt_familie_daten', $haeuser );
}

/**
 * Ein Haus der Familie anhand der Kennung.
 *
 * @param string $kennung Kennung, z. B. lebensart.
 * @return array|null
 */
function stt_familie_haus( $kennung ) {
	foreach ( stt_familie_daten() as $haus ) {
		if ( $kennung === $haus['kennung'] ) {
			return $haus;
		}
	}
	return null;
}

/**
 * Familienleiste als HTML.
 *
 * @return string
 */
function stt_familienleiste() {
	ob_start();
	get_template_part( 'template-parts/familienleiste', null, array( 'haeuser' => stt_familie_daten() ) );
	return (string) ob_get_clean();
}

/**
 * Hausfarben als CSS-Variablen (--fam-<kennung>), damit Muster und Karten sie ohne feste Hex-Werte nutzen.
 *
 * @return string CSS
 */
function stt_familie_farben_css() {
	$css = ':root{';
	foreach ( stt_familie_daten() as $haus ) {
		if ( '' === $haus['kennung'] ) {
			continue;
		}
		$hex = sanitize_hex_color( $haus['hex'] );
		if ( $hex ) {
			$css .= '--fam-' . sanitize_key( $haus['kennung'] ) . ':' . $hex . ';';
		}
	}
	return $css . '}';
}

/**
 * Hausfarben im Frontend und im Block-Editor bereitstellen.
 */
function stt_familie_farben_ausgeben() {
	wp_add_inline_style( 'stt-haus', stt_familie_farben_css() );
}
add_action( 'wp_enqueue_scripts', 'stt_familie_farben_ausgeben', 20 );

/**
 * Hausfarben auch im Block-Editor.
 *
 * @param array $einstellungen Editor-Einstellungen.
 * @return array
 */
function stt_familie_farben_editor( $einstellungen ) {
	$einstellungen['styles'][] = array( 'css' => stt_familie_farben_css() );
	return $einstellungen;
}
add_filter( 'block_editor_settings_all', 'stt_familie_farben_editor' );
