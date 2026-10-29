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
	</div>
	<div class="fusszeile__leiste">
		<div class="wrap fusszeile__leiste-innen">
			<?php
			wp_nav_menu(
				array(
					'theme_location'       => 'fuss',
					'container'            => 'nav',
					'container_aria_label' => __( 'Fußmenü', 'systelios-transfer' ),
					'menu_class'           => 'fusszeile__menue',
					'depth'                => 1,
					'fallback_cb'          => false,
				)
			);
			?>
			<span class="fusszeile__copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
			<?php // ENTSCHEIDUNG D14: „Nach oben“ als reiner Anker-Link, ohne JavaScript. ?>
			<a class="nach-oben" href="#inhalt">
				<svg aria-hidden="true" focusable="false" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 15l7-7 7 7"/></svg>
				<span class="sr"><?php esc_html_e( 'Nach oben', 'systelios-transfer' ); ?></span>
			</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
