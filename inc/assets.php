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
 * Stylesheets und Skripte einbinden.
 */
function stt_assets_laden() {
	$css = array( 'familie', 'haus', 'layout', 'komponenten' );
	$vor = array();
	foreach ( $css as $name ) {
		$pfad = 'assets/css/' . $name . '.css';
		wp_enqueue_style( 'stt-' . $name, STT_URI . '/' . $pfad, $vor, stt_asset_version( $pfad ) );
		$vor = array( 'stt-' . $name );
	}

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
