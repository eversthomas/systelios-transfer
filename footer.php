<?php
/**
 * Fuß: dunkle Fläche mit Claim, Fußmenü und Copyright.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="fusszeile">
	<div class="wrap fusszeile__innen">
		<?php if ( '' !== get_bloginfo( 'description' ) ) : ?>
			<p class="fusszeile__claim"><?php bloginfo( 'description' ); ?></p>
		<?php endif; ?>
		<?php get_template_part( 'template-parts/newsletter-hinweis' ); ?>
		<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'fuss',
				'container'      => 'nav',
				'container_aria_label' => __( 'Fußmenü', 'systelios-transfer' ),
				'menu_class'     => 'fusszeile__menue',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
