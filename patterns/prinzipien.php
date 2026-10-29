<?php
/**
 * Title: Prinzipien (4 Karten)
 * Slug: stt/prinzipien
 * Categories: stt-transfer
 * Description: Vier Karten mit kleinem Punkt, Überschrift und kurzem Text.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$karten = array( 1, 2, 3, 4 );
?>
<!-- wp:columns {"align":"wide","className":"stt-raster"} -->
<div class="wp-block-columns alignwide stt-raster">
<?php foreach ( $karten as $nr ) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte hat-punkt","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte hat-punkt"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">[Prinzip <?php echo (int) $nr; ?>]</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Ein bis zwei Sätze dazu.]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
