<?php
/**
 * Title: Drei Karten
 * Slug: stt/drei-karten
 * Categories: stt-transfer
 * Description: Drei Karten nebeneinander mit Punkt, Überschrift, Text und Link.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$karten = array( 1, 2, 3 );
?>
<!-- wp:columns {"align":"wide","className":"stt-raster"} -->
<div class="wp-block-columns alignwide stt-raster">
<?php foreach ( $karten as $nr ) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte hat-punkt","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte hat-punkt"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">[Titel <?php echo (int) $nr; ?>]</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Kurzer Text zur Karte.]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Mehr →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
