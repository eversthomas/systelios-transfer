<?php
/**
 * Zentrale Konfiguration. Später (Phase 4) kommt hier stt_fallback_karte() dazu.
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
	// ENTSCHEIDUNG D2: Shortcodes aus dem Plugin BSEasy Sync (bes_members, bes_kalender). Bitte prüfen, vor allem die Kalender-ID.
	return array(
		'verzeichnis'            => '[bes_members view="toggle"]',
		'termine_transferabend'  => '[bes_kalender id="transferabend" limit="10"]',
		// ENTSCHEIDUNG D5: Das Plugin kennt keine URL-Parameter für Filter, daher auf der Startseite nur ein Knopf zum Verzeichnis.
		'verzeichnis_parameter'  => array(),
	);
}
