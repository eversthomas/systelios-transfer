<?php
/**
 * Zentrale Konfiguration: BSEasy-Shortcodes und die Zuordnung Seite → Fallback-Muster.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcodes des Plugins BSEasy Sync – die einzige Stelle, an der sie stehen.
 * Muster geben sie über diese Funktion aus.
 *
 * @return array
 */
function stt_shortcodes() {
	// ENTSCHEIDUNG D2: Shortcodes aus dem Plugin BSEasy Sync (bes_members, bes_kalender). Kalender-IDs in BSEasy Sync: transfer, mitglieder, intern.
	return array(
		'verzeichnis'            => '[bes_members view="toggle"]',
		'termine_transferabend'  => '[bes_kalender id="transfer" limit="10"]',
		// ENTSCHEIDUNG D5: Das Plugin kennt keine URL-Parameter für Filter, daher auf der Startseite nur ein Knopf zum Verzeichnis.
		'verzeichnis_parameter'  => array(),
	);
}

/**
 * Zuordnung Seite → Fallback-Muster. Schlüssel = post_name, „__startseite“ = Seite aus page_on_front.
 * Neue Einträge entstehen mit dem Skill inhalt-zu-muster (Phase 4, aus dem Export in inhalte/).
 *
 * Felder: muster (Slug), lead (Einleitung im Seitenkopf), bild (Anhang-ID für das Bildband, 0 = keins).
 *
 * @return array
 */
function stt_fallback_karte() {
	// „bild“: Anhang-ID oder ein Teil des Dateinamens in der Mediathek (0 = kein Bildband).
	$karte = array(
		'__startseite'            => array( 'muster' => 'stt/startseite' ),
		'unsere-angebote'         => array(
			'muster' => 'stt/inhalt-angebote',
			'lead'   => 'Vielfältige Angebote für Sie – online und vor Ort',
			'bild'   => 'D87CA115-20D3',
		),
		'transferabend-online'    => array(
			'muster' => 'stt/inhalt-transferabend-online',
			'lead'   => 'Monatlicher online-Transferabend des Netzwerks',
			'bild'   => 0,
		),
		'gruppen-vor-ort'         => array(
			'muster' => 'stt/inhalt-gruppen-vor-ort',
			'lead'   => 'sysTelios Transfer in den Gruppen vor Ort erleben',
			'bild'   => 0,
		),
		'angehoerige'             => array(
			'muster' => 'stt/inhalt-angehoerige',
			'lead'   => 'sysTelios Transfer für Angehörige',
			'bild'   => 0,
		),
		'therapeuten-und-coaches' => array(
			'muster' => 'stt/inhalt-therapeuten-und-coaches',
			'lead'   => 'Im Netzwerk von sysTelios TRANSFER arbeiten über 200 Therapeutinnen und Therapeuten, Coaches, Beraterinnen und Berater hypnosystemisch – mit Einzelpersonen, Gruppen und Organisationen, vor Ort und online. Hier finden Sie ihre Profile.',
			'bild'   => 'netzwerk-treffen-systelios-transfer',
		),
		'was-ist-hypnosystemik'   => array(
			'muster' => 'stt/inhalt-was-ist-hypnosystemik',
			'lead'   => 'Eine Haltung, die verbindet.',
			'bild'   => 0,
		),
		'impressum'               => array(
			'muster' => 'stt/inhalt-impressum',
			'lead'   => '',
			'bild'   => 0,
		),
		'datenschutzerklaerung'   => array(
			'muster' => 'stt/inhalt-datenschutzerklaerung',
			'lead'   => '',
			'bild'   => 0,
		),
		'charta'                  => array(
			'muster' => 'stt/inhalt-charta',
			'lead'   => 'Die Prinzipien unserer Arbeit und dieses Ansatzes wurden durch die Netzwerkgruppe in Form einer Charta zusammengefasst.',
			'bild'   => 0,
		),
		'lernreise'               => array(
			'muster' => 'stt/inhalt-lernreise',
			'lead'   => '[Einleitung zur Lernreise aus Sicht von Transfer]',
			'bild'   => 0,
		),
		'kontaktaufnahme'         => array(
			'muster' => 'stt/inhalt-kontaktaufnahme',
			'lead'   => 'Sie haben Fragen zum Netzwerk, zu unseren Angeboten oder möchten Mitglied werden? Schreiben Sie uns – wir melden uns bei Ihnen.',
			'bild'   => 'regenbogen-kontakt-systelios-transfer',
		),
	);
	return (array) apply_filters( 'stt_fallback_karte', $karte );
}
