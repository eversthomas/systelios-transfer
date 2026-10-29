<?php
/**
 * Startseite: gibt vorerst den Inhalt der Startseite aus.
 * Phase 3/4 ersetzen das durch das Startseiten-Muster (stt/startseite) bzw. den Fallback.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$inhalt = trim( get_the_content() );
	if ( '' === $inhalt ) {
		// Vorläufig (Phase 3): leere Startseite zeigt das Gesamtmuster. Phase 4 ersetzt das durch das Fallback-System.
		$muster = WP_Block_Patterns_Registry::get_instance()->get_registered( 'stt/startseite' );
		$inhalt = $muster ? $muster['content'] : '';
	}
	$html = apply_filters( 'the_content', $inhalt );
	// Die H1 steht im Einstieg des Startseiten-Musters; fehlt sie, kommt sie aus dem Seitentitel.
	if ( false === stripos( $html, '<h1' ) ) {
		echo '<h1 class="sr">' . esc_html( get_the_title() ) . '</h1>';
	}
	?>
	<div class="inhalt">
		<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content-Filter ?>
	</div>
	<?php
endwhile;

get_footer();
