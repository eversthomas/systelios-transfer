<?php
/**
 * Title: Sprungleiste „Auf dieser Seite“
 * Slug: stt/sprungleiste
 * Categories: stt-transfer
 * Description: Kleine Creme-Box mit Ankerlinks zu den Abschnitten einer langen Seite. Den Abschnitts-Überschriften unter „Erweitert → HTML-Anker“ den passenden Namen geben.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"className":"is-style-warm stt-klein","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-warm stt-klein"><!-- wp:paragraph {"className":"is-style-tag"} -->
<p class="is-style-tag">Auf dieser Seite</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="#abschnitt-1">[Abschnitt 1]</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#abschnitt-2">[Abschnitt 2]</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#abschnitt-3">[Abschnitt 3]</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->
