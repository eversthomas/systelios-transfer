<?php
/**
 * Muster: Kategorie „Transfer“, Hilfsfunktionen für Muster-Dateien und synchronisierte Muster.
 * Die Muster selbst liegen in patterns/ (Doku 03).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Muster-Kategorie „Transfer“.
 */
function stt_muster_kategorie() {
	register_block_pattern_category(
		'stt-transfer',
		array( 'label' => __( 'Transfer', 'systelios-transfer' ) )
	);
}
add_action( 'init', 'stt_muster_kategorie' );

/**
 * Anhang-ID anhand eines Teils des Dateinamens finden (Mediathek).
 * Muster referenzieren Bilder so, damit sie lokal wie live funktionieren; fehlt das Bild, wird es weggelassen.
 *
 * @param string $teil Teil des Dateinamens.
 * @return int 0, wenn nichts gefunden wurde.
 */
function stt_anhang_nach_name( $teil ) {
	static $zwischenspeicher = array();
	if ( isset( $zwischenspeicher[ $teil ] ) ) {
		return $zwischenspeicher[ $teil ];
	}
	$treffer = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'key'     => '_wp_attached_file',
					'value'   => $teil,
					'compare' => 'LIKE',
				),
			),
		)
	);
	$zwischenspeicher[ $teil ] = $treffer ? (int) $treffer[0] : 0;
	return $zwischenspeicher[ $teil ];
}

/**
 * Bild-Block als Markup. Ohne Anhang: leerer Bild-Block (Platzhalter im Editor) oder nichts.
 *
 * @param int  $id           Anhang-ID.
 * @param bool $platzhalter  true = ohne Bild einen leeren Bild-Block liefern.
 * @param string $groesse    Bildgröße.
 * @return string
 */
function stt_bild_block( $id, $platzhalter = false, $groesse = 'large' ) {
	$id  = (int) $id;
	$url = $id ? wp_get_attachment_image_url( $id, $groesse ) : '';
	if ( ! $url ) {
		return $platzhalter ? "<!-- wp:image -->\n<figure class=\"wp-block-image\"><img alt=\"\"/></figure>\n<!-- /wp:image -->" : '';
	}
	$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
	return sprintf(
		"<!-- wp:image {\"id\":%1\$d,\"sizeSlug\":\"%2\$s\",\"linkDestination\":\"none\"} -->\n<figure class=\"wp-block-image size-%2\$s\"><img src=\"%3\$s\" alt=\"%4\$s\" class=\"wp-image-%1\$d\"/></figure>\n<!-- /wp:image -->",
		$id,
		esc_attr( $groesse ),
		esc_url( $url ),
		esc_attr( $alt )
	);
}

/**
 * Inhalte der synchronisierten Muster. Schlüssel = Kennung (Meta _stt_kennung).
 *
 * @return array
 */
function stt_sync_muster_definitionen() {
	$kontakt = esc_url( home_url( '/kontaktaufnahme/' ) );

	$kontaktflaeche = '<!-- wp:group {"align":"wide","className":"is-style-akzent","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide is-style-akzent"><!-- wp:heading -->
<h2 class="wp-block-heading">Ins Gespräch kommen</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Wir freuen uns über Ihre Nachricht und helfen Ihnen, im Netzwerk das passende Angebot oder die passende Person zu finden.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-dunkel"} -->
<div class="wp-block-button is-style-dunkel"><a class="wp-block-button__link wp-element-button" href="' . $kontakt . '">Kontakt aufnehmen</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->';

	$heilkunde = '<!-- wp:paragraph {"className":"is-style-hinweis"} -->
<p class="is-style-hinweis">Die Angebote stellen keine Ausübung von Heilkunde dar. Für Behandlungen wenden Sie sich bitte an Fachleute mit Heilerlaubnis – im Verzeichnis erkennbar am Angebot „Therapie“.</p>
<!-- /wp:paragraph -->';

	return array(
		'kontaktflaeche' => array(
			'titel'   => 'Kontaktfläche „Ins Gespräch kommen“',
			'inhalt'  => $kontaktflaeche,
		),
		'heilkunde'      => array(
			'titel'   => 'Hinweis Heilkunde',
			'inhalt'  => $heilkunde,
		),
	);
}

/**
 * ID eines synchronisierten Musters (wp_block) anhand der Kennung.
 *
 * @param string $kennung Kennung, z. B. kontaktflaeche.
 * @return int 0, wenn es das Muster nicht gibt.
 */
function stt_sync_muster_id( $kennung ) {
	$treffer = get_posts(
		array(
			'post_type'      => 'wp_block',
			'post_status'    => array( 'publish', 'draft', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_stt_kennung', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => sanitize_key( $kennung ), // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	return $treffer ? (int) $treffer[0] : 0;
}

/**
 * Fehlende synchronisierte Muster anlegen. Vorhandene werden nie verändert.
 *
 * @return int Anzahl neu angelegter Muster.
 */
function stt_sync_muster_anlegen() {
	$neu = 0;
	foreach ( stt_sync_muster_definitionen() as $kennung => $muster ) {
		if ( stt_sync_muster_id( $kennung ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'wp_block',
				'post_status'  => 'publish',
				'post_title'   => $muster['titel'],
				'post_content' => $muster['inhalt'],
				'meta_input'   => array( '_stt_kennung' => $kennung ),
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			++$neu;
		}
	}
	return $neu;
}
add_action( 'after_switch_theme', 'stt_sync_muster_anlegen' );

/**
 * Nachholen, falls das Theme schon aktiv war (oder Muster gelöscht wurden und neu gewünscht sind):
 * einmal pro Theme-Version im Backend prüfen.
 */
function stt_sync_muster_nachholen() {
	if ( ! current_user_can( 'edit_pages' ) || get_option( 'stt_muster_version' ) === STT_VERSION ) {
		return;
	}
	stt_sync_muster_anlegen();
	update_option( 'stt_muster_version', STT_VERSION );
}
add_action( 'admin_init', 'stt_sync_muster_nachholen' );
