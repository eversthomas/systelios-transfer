<?php
/**
 * Allgemeine Liste (Beiträge, Archive). Schlicht im Theme-Stil, siehe Entscheidung D13.
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
		'titel'  => is_home() && ! is_front_page() ? get_the_title( (int) get_option( 'page_for_posts' ) ) : get_the_archive_title(),
		'lead'   => '',
		'bild'   => 0,
		'krumen' => array(),
	)
);
?>
<div class="inhalt">
	<?php get_template_part( 'template-parts/beitragsliste' ); ?>
</div>
<?php
get_footer();
