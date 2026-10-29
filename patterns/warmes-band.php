<?php
/**
 * Title: Warmes Band mit Text und Bild
 * Slug: stt/warmes-band
 * Categories: stt-transfer
 * Description: Cremefarbenes Band über die volle Breite mit Bild links und Text rechts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"align":"full","className":"is-style-warm","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-warm"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><?php echo stt_bild_block( 0, true ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading -->
<h2 class="wp-block-heading">[Überschrift]</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Text. Ersetzen Sie diesen Platzhalter durch Ihren eigenen Text.]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
