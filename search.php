<?php
/**
 * Suchergebnisse.
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
		/* translators: %s: Suchbegriff */
		'titel'  => sprintf( __( 'Suche: %s', 'systelios-transfer' ), get_search_query() ),
		'lead'   => '',
		'bild'   => 0,
		'krumen' => array(),
	)
);
?>
<div class="inhalt">
	<?php get_search_form(); ?>
	<?php get_template_part( 'template-parts/beitragsliste' ); ?>
</div>
<?php
get_footer();
