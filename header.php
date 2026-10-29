<?php
/**
 * Kopf: Skip-Link, Kopfleiste mit Logo und Hauptmenü, mobiles Menü.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="<?php echo esc_attr( array( 'auto' => 'light dark', 'hell' => 'light', 'dunkel' => 'dark' )[ stt_farbschema() ] ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#inhalt"><?php esc_html_e( 'Zum Inhalt springen', 'systelios-transfer' ); ?></a>

<header class="kopfleiste">
	<div class="wrap kopfleiste__innen">
		<a class="marke" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: Name der Website */ __( '%s, zur Startseite', 'systelios-transfer' ), get_bloginfo( 'name' ) ) ); ?>">
			<img src="<?php echo esc_url( STT_URI . '/assets/img/logo-transfer.png' ); ?>" width="83" height="52" alt="">
		</a>

		<nav class="hauptmenue" aria-label="<?php esc_attr_e( 'Hauptnavigation', 'systelios-transfer' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'haupt',
					'container'      => false,
					'menu_id'        => 'hauptmenue-liste',
					'menu_class'     => 'menue',
					'depth'          => 1,
					'fallback_cb'    => 'stt_menue_ersatz',
				)
			);
			?>
		</nav>

		<button class="menueknopf" type="button" aria-expanded="false" aria-controls="mobilmenue" aria-haspopup="dialog">
			<svg class="punkte" viewBox="0 0 30 24" width="30" height="24" aria-hidden="true" focusable="false">
				<circle cx="6" cy="6" r="4.5" />
				<circle cx="21" cy="9" r="6" />
				<circle cx="9" cy="19" r="3.5" />
			</svg>
			<span><?php esc_html_e( 'Menü', 'systelios-transfer' ); ?></span>
		</button>
	</div>
</header>

<?php get_template_part( 'template-parts/menue-mobil' ); ?>

<main id="inhalt" tabindex="-1">
