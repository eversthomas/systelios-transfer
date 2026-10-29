<?php
/**
 * Fallback-System: bestehende Inhalte als veränderbarer Fallback (docs/04-inhalte-und-fallback.md).
 *
 * Zustände einer Seite (Meta _stt_inhalt: leer | eigen | fallback):
 *  - fallback_auto: Meta leer, Seite ist eine Elementor-Seite oder leer, und es gibt ein Muster
 *  - fallback:      Meta „fallback“ und es gibt ein Muster (zum Testen/Zurückstellen)
 *  - eigen:         Meta „eigen“ oder die Seite hat eigenen Inhalt
 *  - ohne:          es gibt kein Fallback-Muster
 *
 * Elementor-Meta (_elementor_*) wird hier nie geschrieben oder gelöscht.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fallback-Eintrag einer Seite, sofern ein Muster zugeordnet UND registriert ist.
 *
 * @param WP_Post|int|null $beitrag Seite.
 * @return array|null
 */
function stt_fallback_eintrag( $beitrag = null ) {
	$beitrag = get_post( $beitrag );
	if ( ! $beitrag || 'page' !== $beitrag->post_type ) {
		return null;
	}
	$karte      = stt_fallback_karte();
	$schluessel = $beitrag->post_name;
	if ( 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) === (int) $beitrag->ID ) {
		$schluessel = '__startseite';
	}
	if ( empty( $karte[ $schluessel ]['muster'] ) ) {
		return null;
	}
	$eintrag = wp_parse_args(
		$karte[ $schluessel ],
		array(
			'muster' => '',
			'lead'   => '',
			'bild'   => 0,
		)
	);
	if ( ! WP_Block_Patterns_Registry::get_instance()->is_registered( $eintrag['muster'] ) ) {
		return null;
	}
	// „bild“ darf ein Teil des Dateinamens sein (die Anhang-IDs unterscheiden sich lokal und live).
	if ( is_string( $eintrag['bild'] ) && '' !== $eintrag['bild'] && ! ctype_digit( $eintrag['bild'] ) ) {
		$eintrag['bild'] = stt_anhang_nach_name( $eintrag['bild'] );
	}
	return $eintrag;
}

/**
 * Ist die Seite eine (frühere) Elementor-Seite? Elementor muss dafür nicht aktiv sein.
 *
 * @param int $seite_id Seiten-ID.
 * @return bool
 */
function stt_ist_elementor_seite( $seite_id ) {
	return 'builder' === get_post_meta( $seite_id, '_elementor_edit_mode', true );
}

/**
 * Zustand einer Seite: fallback_auto | fallback | eigen | ohne.
 *
 * @param WP_Post|int|null $beitrag Seite.
 * @return string
 */
function stt_inhalt_zustand( $beitrag = null ) {
	$beitrag = get_post( $beitrag );
	if ( ! $beitrag ) {
		return 'ohne';
	}
	$meta = get_post_meta( $beitrag->ID, '_stt_inhalt', true );
	if ( 'eigen' === $meta ) {
		return 'eigen';
	}
	if ( null === stt_fallback_eintrag( $beitrag ) ) {
		return 'ohne';
	}
	if ( 'fallback' === $meta ) {
		return 'fallback';
	}
	if ( stt_ist_elementor_seite( $beitrag->ID ) || '' === trim( $beitrag->post_content ) ) {
		return 'fallback_auto';
	}
	return 'eigen';
}

/**
 * Zeigt das Frontend für diese Seite das mitgelieferte Muster?
 *
 * @param WP_Post|int|null $beitrag Seite.
 * @return bool
 */
function stt_zeigt_fallback( $beitrag = null ) {
	return in_array( stt_inhalt_zustand( $beitrag ), array( 'fallback_auto', 'fallback' ), true );
}

/**
 * Inhalt einer Seite fürs Frontend: Fallback-Muster oder der normale Seiteninhalt.
 * Gehört in die Schleife (wie the_content()).
 *
 * @param WP_Post|int|null $beitrag Seite.
 * @return string HTML
 */
function stt_seiteninhalt( $beitrag = null ) {
	$beitrag = get_post( $beitrag );
	if ( ! $beitrag ) {
		return '';
	}
	if ( stt_zeigt_fallback( $beitrag ) ) {
		$eintrag = stt_fallback_eintrag( $beitrag );
		$muster  = WP_Block_Patterns_Registry::get_instance()->get_registered( $eintrag['muster'] );
		return (string) apply_filters( 'the_content', $muster['content'] );
	}
	$inhalt = apply_filters( 'the_content', get_the_content( null, false, $beitrag ) );
	return str_replace( ']]>', ']]&gt;', (string) $inhalt );
}

/**
 * Seitenkopf im Fallback: Einleitung und Bildband aus der Karte, solange Textauszug/Beitragsbild leer sind.
 */
add_filter(
	'stt_seitenkopf_lead',
	static function ( $lead, $beitrag ) {
		if ( '' === $lead && $beitrag && stt_zeigt_fallback( $beitrag ) ) {
			$eintrag = stt_fallback_eintrag( $beitrag );
			return (string) $eintrag['lead'];
		}
		return $lead;
	},
	10,
	2
);
add_filter(
	'stt_seitenkopf_bild',
	static function ( $bild, $beitrag ) {
		if ( ! $bild && $beitrag && stt_zeigt_fallback( $beitrag ) ) {
			$eintrag = stt_fallback_eintrag( $beitrag );
			return (int) $eintrag['bild'];
		}
		return $bild;
	},
	10,
	2
);

/**
 * Seite übernehmen: Muster-Inhalt wird zum Seiteninhalt (WordPress legt dabei eine Revision an).
 * Textauszug und Beitragsbild werden nur gesetzt, wenn sie leer sind.
 *
 * @param int $seite_id Seiten-ID.
 * @return bool true bei Erfolg.
 */
function stt_seite_uebernehmen( $seite_id ) {
	$beitrag = get_post( $seite_id );
	$eintrag = stt_fallback_eintrag( $beitrag );
	if ( ! $beitrag || null === $eintrag ) {
		return false;
	}
	$muster = WP_Block_Patterns_Registry::get_instance()->get_registered( $eintrag['muster'] );

	$daten = array(
		'ID'           => $beitrag->ID,
		'post_content' => wp_slash( $muster['content'] ),
	);
	if ( '' === trim( $beitrag->post_excerpt ) && '' !== (string) $eintrag['lead'] ) {
		$daten['post_excerpt'] = wp_slash( $eintrag['lead'] );
	}
	$ergebnis = wp_update_post( $daten, true );
	if ( is_wp_error( $ergebnis ) ) {
		return false;
	}

	if ( ! has_post_thumbnail( $beitrag->ID ) && (int) $eintrag['bild'] > 0 ) {
		set_post_thumbnail( $beitrag->ID, (int) $eintrag['bild'] );
	}
	update_post_meta( $beitrag->ID, '_stt_inhalt', 'eigen' );
	update_post_meta( $beitrag->ID, '_stt_uebernommen', current_time( 'mysql' ) );
	return true;
}

/**
 * Seite auf Fallback zurückstellen. Der Inhalt bleibt erhalten, Revisionen bleiben nutzbar.
 *
 * @param int $seite_id Seiten-ID.
 * @return bool
 */
function stt_seite_zurueckstellen( $seite_id ) {
	if ( null === stt_fallback_eintrag( $seite_id ) ) {
		return false;
	}
	update_post_meta( $seite_id, '_stt_inhalt', 'fallback' );
	return true;
}

/**
 * Wer eine Fallback-Seite im Block-Editor mit Blöcken speichert, hat eigenen Inhalt:
 * sonst bliebe die Änderung (bei früheren Elementor-Seiten) unsichtbar.
 *
 * @param int     $beitrag_id Beitrags-ID.
 * @param WP_Post $beitrag    Beitrag.
 */
function stt_eigener_inhalt_merken( $beitrag_id, $beitrag ) {
	if ( 'page' !== $beitrag->post_type || wp_is_post_revision( $beitrag_id ) || wp_is_post_autosave( $beitrag_id ) ) {
		return;
	}
	if ( '' !== (string) get_post_meta( $beitrag_id, '_stt_inhalt', true ) ) {
		return;
	}
	if ( false !== strpos( $beitrag->post_content, '<!-- wp:' ) ) {
		update_post_meta( $beitrag_id, '_stt_inhalt', 'eigen' );
	}
}
add_action( 'save_post', 'stt_eigener_inhalt_merken', 10, 2 );
