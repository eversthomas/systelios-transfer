<?php
/**
 * Seite: Seitenkopf (Titel, Einleitung, Bildband) und Inhalt.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part(
		'template-parts/seitenkopf',
		null,
		array(
			'titel'  => get_the_title(),
			'lead'   => stt_seitenkopf_lead(),
			'bild'   => stt_seitenkopf_bild(),
			'krumen' => stt_brotkrumen(),
		)
	);
	?>
	<div class="inhalt">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();
