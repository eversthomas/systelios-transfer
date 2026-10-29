<?php
/**
 * Vollbild-Menü für schmale Fenster. Wird von assets/js/menue.js geöffnet und geschlossen.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="mobilmenue" id="mobilmenue" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menü', 'systelios-transfer' ); ?>" hidden>
	<div class="mobilmenue__kopf">
		<span class="mobilmenue__titel"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		<button class="mobilmenue__zu" type="button">
			<svg class="punkte" viewBox="0 0 30 24" width="30" height="24" aria-hidden="true" focusable="false">
				<circle cx="6" cy="6" r="4.5" />
				<circle cx="21" cy="9" r="6" />
				<circle cx="9" cy="19" r="3.5" />
			</svg>
			<span><?php esc_html_e( 'Schließen', 'systelios-transfer' ); ?></span>
		</button>
	</div>
	<nav aria-label="<?php esc_attr_e( 'Hauptnavigation', 'systelios-transfer' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'haupt',
				'container'      => false,
				'menu_id'        => 'mobilmenue-liste',
				'menu_class'     => 'mobilmenue__liste',
				'depth'          => 2,
				'fallback_cb'    => 'stt_menue_ersatz',
			)
		);
		?>
	</nav>
</div>
