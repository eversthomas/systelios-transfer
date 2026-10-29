<?php
/**
 * Title: Verzeichnis Begleiter*innen
 * Slug: stt/verzeichnis
 * Categories: stt-transfer
 * Description: Verzeichnis der Begleiter*innen aus BSEasy Sync (Shortcode, wird vom Plugin gefüllt).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shortcodes = stt_shortcodes();
?>
<!-- wp:shortcode -->
<?php echo $shortcodes['verzeichnis']; // phpcs:ignore WordPress.Security.EscapeOutput -- feste Konfiguration ?>
<!-- /wp:shortcode -->
