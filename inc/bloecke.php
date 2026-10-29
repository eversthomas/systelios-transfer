<?php
/**
 * Block-Stile statt Farbwähler. Die Gestaltung liegt in assets/css/bloecke.css.
 * Namen und Wirkung: docs/03-pflegekonzept.md, Abschnitt 3.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block-Stile registrieren.
 */
function stt_block_stile() {
	$stile = array(
		'core/group'     => array(
			'warm'   => __( 'Warmes Band', 'systelios-transfer' ),
			'dunkel' => __( 'Dunkles Band', 'systelios-transfer' ),
			'karte'  => __( 'Karte', 'systelios-transfer' ),
			'akzent' => __( 'Akzentfläche', 'systelios-transfer' ),
		),
		'core/button'    => array(
			'umriss' => __( 'Umriss', 'systelios-transfer' ),
			'dunkel' => __( 'Dunkel', 'systelios-transfer' ),
		),
		'core/image'     => array(
			'eckig' => __( 'Eckig', 'systelios-transfer' ),
		),
		'core/quote'     => array(
			'punkte' => __( 'Zitat mit Punkten', 'systelios-transfer' ),
		),
		'core/list'      => array(
			'haken'         => __( 'Haken', 'systelios-transfer' ),
			'nummern-gross' => __( 'Große Nummern', 'systelios-transfer' ),
		),
		'core/paragraph' => array(
			'lead'       => __( 'Einleitung', 'systelios-transfer' ),
			'hinweis'    => __( 'Hinweis', 'systelios-transfer' ),
			'augenbraue' => __( 'Augenbraue', 'systelios-transfer' ),
			'tag'        => __( 'Etikett', 'systelios-transfer' ),
		),
	);

	foreach ( $stile as $block => $liste ) {
		foreach ( $liste as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'stt_block_stile' );
