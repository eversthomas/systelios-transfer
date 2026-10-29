<?php
/**
 * Anbindung an das Plugin BSEasy Sync: erkennt das Plugin und lädt plugin-bseasy.css nur auf Seiten,
 * die dessen Shortcodes verwenden. Den Plugin-Code ändert das Theme nicht.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ist BSEasy Sync aktiv? (Shortcode vorhanden)
 *
 * @return bool
 */
function stt_bseasy_aktiv() {
	return shortcode_exists( 'bes_members' ) || shortcode_exists( 'bes_kalender' );
}

/**
 * CSS nur laden, wenn die Seite Inhalte des Plugins zeigt (Shortcode im Seiteninhalt oder im Fallback-Muster).
 */
function stt_bseasy_css() {
	if ( ! stt_bseasy_aktiv() || ! is_singular() ) {
		return;
	}
	$beitrag = get_post();
	if ( ! $beitrag ) {
		return;
	}
	$inhalt = $beitrag->post_content;
	if ( 'page' === $beitrag->post_type && function_exists( 'stt_zeigt_fallback' ) && stt_zeigt_fallback( $beitrag ) ) {
		$eintrag = stt_fallback_eintrag( $beitrag );
		$muster  = $eintrag ? WP_Block_Patterns_Registry::get_instance()->get_registered( $eintrag['muster'] ) : null;
		$inhalt  = $muster ? $muster['content'] : $inhalt;
	}
	if ( has_shortcode( $inhalt, 'bes_members' ) || has_shortcode( $inhalt, 'bes_kalender' ) ) {
		wp_enqueue_style( 'stt-plugin-bseasy', STT_URI . '/assets/css/plugin-bseasy.css', array( 'stt-komponenten' ), stt_asset_version( 'assets/css/plugin-bseasy.css' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'stt_bseasy_css', 30 );
