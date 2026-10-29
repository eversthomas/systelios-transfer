<?php
/**
 * Optionales JSON-LD (Organisation mit Verweis auf die Familie). Standard: aus.
 * Ein aktives SEO-Plugin (Yoast, Rank Math) bleibt zuständig – dann gibt das Theme nichts aus.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JSON-LD auf der Startseite ausgeben, wenn eingeschaltet.
 */
function stt_jsonld_ausgeben() {
	if ( ! is_front_page() || ! get_option( 'stt_jsonld_familie', false ) ) {
		return;
	}
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}

	$daten = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'@id'      => home_url( '/#organisation' ),
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	);

	$logo_id = (int) get_theme_mod( 'custom_logo' );
	$logo    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : STT_URI . '/assets/img/logo-transfer.png';
	if ( $logo ) {
		$daten['logo'] = $logo;
	}

	// ENTSCHEIDUNG D7: neutraler Verweis auf die anderen Häuser; parentOrganization nur, wenn rechtlich zutreffend.
	$verweise = array();
	foreach ( stt_familie_daten() as $haus ) {
		if ( empty( $haus['wir'] ) && ! empty( $haus['link'] ) ) {
			$verweise[] = esc_url_raw( $haus['link'] );
		}
	}
	if ( $verweise ) {
		$daten['sameAs'] = $verweise;
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $daten, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
}
add_action( 'wp_head', 'stt_jsonld_ausgeben', 20 );
