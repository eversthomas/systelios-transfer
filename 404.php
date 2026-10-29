<?php
/**
 * Seite nicht gefunden.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part(
	'template-parts/seitenkopf',
	null,
	array(
		'titel'  => __( 'Seite nicht gefunden', 'systelios-transfer' ),
		'lead'   => __( 'Diese Adresse gibt es nicht (mehr). Vielleicht hilft Ihnen die Suche oder ein Blick ins Menü.', 'systelios-transfer' ),
		'bild'   => 0,
		'krumen' => array(),
	)
);
?>
<div class="inhalt">
	<?php get_search_form(); ?>
	<p><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Zur Startseite', 'systelios-transfer' ); ?></a></p>
</div>
<?php
get_footer();
