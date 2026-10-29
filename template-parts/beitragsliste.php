<?php
/**
 * Liste von Beiträgen/Treffern (index.php, search.php).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) :
	?>
	<ul class="beitragsliste">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<li class="beitragsliste__eintrag">
				<h2 class="beitragsliste__titel"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php if ( has_excerpt() ) : ?>
					<p class="beitragsliste__auszug"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php
	the_posts_pagination(
		array(
			'class'     => 'seitennavigation',
			'prev_text' => esc_html__( 'Zurück', 'systelios-transfer' ),
			'next_text' => esc_html__( 'Weiter', 'systelios-transfer' ),
		)
	);
else :
	?>
	<p class="hinweis-leer"><?php esc_html_e( 'Keine Treffer gefunden.', 'systelios-transfer' ); ?></p>
	<?php
endif;
