<?php
/**
 * Shortcodes des Themes: [stt_familie] [stt_newsletter] [stt_lernreise_button] sowie ein Ersatz für [stt_kontakt].
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [stt_familie] – Familienleiste.
 *
 * @return string
 */
function stt_sc_familie() {
	return stt_familienleiste();
}

/**
 * [stt_newsletter] – Newsletter-Hinweis (leer, solange keine URL gesetzt ist).
 *
 * @return string
 */
function stt_sc_newsletter() {
	ob_start();
	get_template_part( 'template-parts/newsletter-hinweis' );
	return (string) ob_get_clean();
}

/**
 * [stt_lernreise_button text="…"] – Button zur Lernreise bei LEBENSART. Ziel: Einstellung „Lernreise-Adresse“.
 *
 * @param array|string $atts Attribute.
 * @return string
 */
function stt_sc_lernreise_button( $atts ) {
	$atts = shortcode_atts(
		array(
			'text' => __( 'Zur Lernreise bei LEBENSART', 'systelios-transfer' ),
		),
		$atts,
		'stt_lernreise_button'
	);
	$url = (string) get_option( 'stt_lernreise_url', '' );
	if ( '' === $url ) {
		if ( current_user_can( 'manage_options' ) ) {
			return '<p class="hinweis-leer">' . esc_html__( 'Hinweis für Administrator*innen: Die Lernreise-Adresse fehlt noch (Design → Transfer-Einstellungen).', 'systelios-transfer' ) . '</p>';
		}
		return '';
	}
	return '<div class="wp-block-buttons"><div class="wp-block-button is-style-umriss"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '" rel="noopener">' . esc_html( $atts['text'] ) . '</a></div></div>';
}

/**
 * Ersatz für [stt_kontakt], solange das Kontaktformular-Plugin (stt-kontakt) nicht aktiv ist.
 *
 * @return string
 */
function stt_sc_kontakt_ersatz() {
	$mail = (string) get_option( 'stt_kontakt_email', '' );
	if ( '' === $mail ) {
		$mail = 'transfer@systelios.de';
	}
	return '<p>' . sprintf(
		/* translators: %s: E-Mail-Adresse als Link */
		esc_html__( 'Das Kontaktformular ist derzeit nicht verfügbar. Schreiben Sie uns gern per E-Mail an %s.', 'systelios-transfer' ),
		'<a href="' . esc_url( 'mailto:' . $mail ) . '">' . esc_html( $mail ) . '</a>'
	) . '</p>';
}

/**
 * Shortcodes anmelden. Der Ersatz für [stt_kontakt] spät, damit das Plugin Vorrang hat.
 */
function stt_shortcodes_anmelden() {
	add_shortcode( 'stt_familie', 'stt_sc_familie' );
	add_shortcode( 'stt_newsletter', 'stt_sc_newsletter' );
	add_shortcode( 'stt_lernreise_button', 'stt_sc_lernreise_button' );
}
add_action( 'init', 'stt_shortcodes_anmelden' );

add_action(
	'init',
	static function () {
		if ( ! shortcode_exists( 'stt_kontakt' ) ) {
			add_shortcode( 'stt_kontakt', 'stt_sc_kontakt_ersatz' );
		}
	},
	99
);
