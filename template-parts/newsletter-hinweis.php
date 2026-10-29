<?php
/**
 * Newsletter-Hinweis: nur ein Hinweis mit Link zu LEBENSART, kein Formular. Ohne URL in den Einstellungen keine Ausgabe.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$url = (string) get_option( 'stt_newsletter_url', '' );
if ( '' === $url ) {
	return;
}

$ueberschrift = (string) get_option( 'stt_newsletter_ueberschrift', '' );
if ( '' === $ueberschrift ) {
	$ueberschrift = __( 'Newsletter von sysTelios LEBENSART', 'systelios-transfer' );
}
$text  = (string) get_option( 'stt_newsletter_text', '' );
$haus  = stt_familie_haus( 'lebensart' );
$farbe = $haus ? sanitize_hex_color( $haus['hex'] ) : '';
?>
<aside class="newsletter-hinweis" aria-labelledby="newsletter-titel"<?php echo $farbe ? ' style="' . esc_attr( '--fam-c:' . $farbe ) . '"' : ''; ?>>
	<div class="newsletter-hinweis__text">
		<h2 class="newsletter-hinweis__titel" id="newsletter-titel"><?php echo esc_html( $ueberschrift ); ?></h2>
		<?php if ( '' !== $text ) : ?>
			<p><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
	</div>
	<a class="btn btn-sm newsletter-hinweis__knopf" href="<?php echo esc_url( $url ); ?>" rel="noopener"><?php esc_html_e( 'Zum Newsletter', 'systelios-transfer' ); ?></a>
</aside>
