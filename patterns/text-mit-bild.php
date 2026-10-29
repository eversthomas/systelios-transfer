<?php
/**
 * Title: Text mit Bild
 * Slug: stt/text-mit-bild
 * Categories: stt-transfer
 * Description: Zwei Spalten: Überschrift und Text links, Bild rechts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading -->
<h2 class="wp-block-heading">[Überschrift]</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Text. Ersetzen Sie diesen Platzhalter durch Ihren eigenen Text.]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><?php echo stt_bild_block( 0, true ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
