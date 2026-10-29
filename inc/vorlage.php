<?php
/**
 * Hilfsfunktionen für die Templates: Seitenkopf und Brotkrumen.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Einleitung für den Seitenkopf: Textauszug der Seite.
 * Phase 4 ergänzt über den Filter den mitgelieferten Text des Fallbacks.
 *
 * @param WP_Post|null $beitrag Seite.
 * @return string
 */
function stt_seitenkopf_lead( $beitrag = null ) {
	$beitrag = get_post( $beitrag );
	$lead    = '';
	if ( $beitrag && has_excerpt( $beitrag ) ) {
		$lead = $beitrag->post_excerpt;
	}
	return (string) apply_filters( 'stt_seitenkopf_lead', $lead, $beitrag );
}

/**
 * Anhang-ID des Bildbands: Beitragsbild, sonst per Filter (Fallback in Phase 4).
 *
 * @param WP_Post|null $beitrag Seite.
 * @return int
 */
function stt_seitenkopf_bild( $beitrag = null ) {
	$beitrag = get_post( $beitrag );
	$id      = $beitrag ? (int) get_post_thumbnail_id( $beitrag ) : 0;
	return (int) apply_filters( 'stt_seitenkopf_bild', $id, $beitrag );
}

/**
 * Brotkrumen: Start › übergeordnete Seiten › aktuelle Seite.
 *
 * @param WP_Post|null $beitrag Seite.
 * @return array Liste aus Arrays mit label und url (url leer = aktuelle Seite).
 */
function stt_brotkrumen( $beitrag = null ) {
	$beitrag = get_post( $beitrag );
	$spur    = array(
		array(
			'label' => __( 'Start', 'systelios-transfer' ),
			'url'   => home_url( '/' ),
		),
	);
	if ( ! $beitrag ) {
		return $spur;
	}
	foreach ( array_reverse( get_post_ancestors( $beitrag ) ) as $eltern_id ) {
		$spur[] = array(
			'label' => get_the_title( $eltern_id ),
			'url'   => get_permalink( $eltern_id ),
		);
	}
	$spur[] = array(
		'label' => get_the_title( $beitrag ),
		'url'   => '',
	);
	return $spur;
}
