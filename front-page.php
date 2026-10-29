<?php
/**
 * Startseite: Seiteninhalt oder – solange die Startseite noch nicht übernommen ist – das Fallback-Muster
 * (stt/startseite). Siehe inc/inhalte.php.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_page() ) {
	while ( have_posts() ) {
		the_post();
		$html  = stt_seiteninhalt();
		$titel = get_the_title();
	}
} else {
	// Startseite zeigt die neuesten Beiträge (keine statische Seite): Gesamtmuster ausgeben.
	$muster = WP_Block_Patterns_Registry::get_instance()->get_registered( 'stt/startseite' );
	$html   = $muster ? apply_filters( 'the_content', $muster['content'] ) : '';
	$titel  = get_bloginfo( 'name' );
}

// Die H1 steht im Einstieg des Startseiten-Musters; fehlt sie, kommt sie aus dem Seitentitel.
if ( false === stripos( $html, '<h1' ) ) {
	echo '<h1 class="sr">' . esc_html( $titel ) . '</h1>';
}
?>
<div class="inhalt">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content-Filter ?>
</div>
<?php
get_footer();
