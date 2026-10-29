<?php
/**
 * Stylesheets, Skripte und Schriften (alles lokal, keine externen Ressourcen).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Version einer Asset-Datei: Änderungszeit, damit Browser-Caches sich erneuern.
 *
 * @param string $pfad Pfad relativ zum Theme, z. B. assets/css/layout.css.
 * @return string
 */
function stt_asset_version( $pfad ) {
	$datei = STT_DIR . '/' . $pfad;
	return file_exists( $datei ) ? (string) filemtime( $datei ) : STT_VERSION;
}

/**
 * Farbschema der Website: auto (folgt dem System) | hell | dunkel. Einstellung unter Design → Transfer-Einstellungen.
 *
 * @return string
 */
function stt_farbschema() {
	$wert = get_option( 'stt_farbschema', 'auto' );
	return in_array( $wert, array( 'hell', 'dunkel' ), true ) ? $wert : 'auto';
}

/**
 * Stylesheets und Skripte einbinden.
 */
function stt_assets_laden() {
	$css       = array( 'familie', 'haus', 'dunkel', 'layout', 'komponenten', 'bloecke' );
	$farbschema = stt_farbschema();
	$vor       = array();
	foreach ( $css as $name ) {
		$medium = 'all';
		if ( 'dunkel' === $name ) {
			if ( 'hell' === $farbschema ) {
				continue;
			}
			$medium = 'auto' === $farbschema ? '(prefers-color-scheme: dark)' : 'all';
		}
		$pfad = 'assets/css/' . $name . '.css';
		wp_enqueue_style( 'stt-' . $name, STT_URI . '/' . $pfad, $vor, stt_asset_version( $pfad ), $medium );
		$vor = array( 'stt-' . $name );
	}
	if ( 'hell' === $farbschema ) {
		wp_add_inline_style( 'stt-haus', ':root{color-scheme:light}' );
	}

	// Druckansicht: eigene Datei, wird nur beim Drucken geladen.
	wp_enqueue_style( 'stt-druck', STT_URI . '/assets/css/druck.css', array( 'stt-bloecke' ), stt_asset_version( 'assets/css/druck.css' ), 'print' );

	wp_enqueue_script(
		'stt-menue',
		STT_URI . '/assets/js/menue.js',
		array(),
		stt_asset_version( 'assets/js/menue.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'stt_assets_laden' );

/**
 * Kennzeichnung „JavaScript verfügbar“, damit das Menü ohne JS als Liste sichtbar bleibt.
 */
function stt_js_klasse() {
	echo "<script>document.documentElement.className+=' js';</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
}
add_action( 'wp_head', 'stt_js_klasse', 0 );

/**
 * Die wichtigsten Schriftschnitte vorladen.
 */
function stt_schriften_vorladen() {
	$dateien = array( 'barlow-normal-400.woff2', 'barlow-italic-700.woff2' );
	foreach ( $dateien as $datei ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( STT_URI . '/assets/fonts/' . $datei )
		);
	}
}
add_action( 'wp_head', 'stt_schriften_vorladen', 1 );

/**
 * WordPress-Version nicht im Seitenquelltext ausgeben.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Nicht benötigte Stylesheets weglassen (Block-Stile des Themes ersetzen das Klassik-Theme-CSS).
 */
function stt_unnoetige_styles_entfernen() {
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'stt_unnoetige_styles_entfernen', 100 );

/**
 * Editor = Frontend: dieselben Stylesheets (Schriften, Farben, Radien, Block-Stile) im Block-Editor.
 */
function stt_editor_styles() {
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_editor_style(
		array(
			'assets/css/familie.css',
			'assets/css/haus.css',
			'assets/css/bloecke.css',
			'assets/css/editor.css',
		)
	);
}
add_action( 'after_setup_theme', 'stt_editor_styles' );
