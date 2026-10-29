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
	?>
	<h1 class="sr"><?php the_title(); ?></h1>
	<div class="inhalt">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();
