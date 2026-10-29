<?php
/**
 * Title: Termine Transferabend
 * Slug: stt/termine-transferabend
 * Categories: stt-transfer
 * Description: Terminliste des Transferabends aus BSEasy Sync (Shortcode, wird vom Plugin gefüllt).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shortcodes = stt_shortcodes();
?>
<!-- wp:shortcode -->
<?php echo $shortcodes['termine_transferabend']; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Konfiguration ?>
<!-- /wp:shortcode -->
