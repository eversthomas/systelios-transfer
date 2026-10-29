<?php
/**
 * Title: Fallback – Therapeuten und Coaches
 * Slug: stt/inhalt-therapeuten-und-coaches
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Therapeuten und Coaches“ (Stand 29.10.2026). Das Verzeichnis kommt per Shortcode aus BSEasy Sync.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shortcodes = stt_shortcodes();

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_ueberschrift( 'Was alle Mitglieder verbindet' ),
		stt_m_liste(
			array(
				'Sie leben die ' . stt_m_link( 'hypnosystemische Haltung', stt_seiten_url( 'was-ist-hypnosystemik' ) ) . '.',
				'Sie haben entsprechende Aus- und Weiterbildungen absolviert.',
				'Sie fühlen sich dieser Haltung selbst verpflichtet.',
				'Sie vernetzen sich regelmäßig, tauschen sich aus und bilden sich weiter.',
			),
			'haken'
		),
		stt_m_absatz( 'Die Angebote reichen von Psychotherapie über Coaching, Organisations- und Teamentwicklung bis zu Mediation und Supervision. Gruppenangebote für ehemalige Klientinnen und Klienten, Angehörige und Interessierte finden Sie unter ' . stt_m_link( 'Angebote', stt_seiten_url( 'unsere-angebote' ) ) . '.' ),
		stt_m_absatz( 'Hinweis: Beratungen und Angebote werden von den einzelnen Mitgliedern eigenverantwortlich erbracht, nicht im Namen von sysTelios TRANSFER. Die Reihenfolge der Profile ist zufällig – nutzen Sie gern die Suchfelder.', 'is-style-hinweis' ),
		stt_m_ueberschrift( 'Teil des Netzwerks werden' ),
		stt_m_absatz( 'Sie fühlen sich der hypnosystemischen Haltung verbunden und möchten selbst Mitglied werden – oder haben Fragen dazu? Offenheit prägt unser Netzwerk. Wir freuen uns auf Ihre Nachricht.' ),
		stt_m_knopf( 'Kontakt aufnehmen', stt_seiten_url( 'kontaktaufnahme' ) ),
		"<!-- wp:shortcode -->\n" . $shortcodes['verzeichnis'] . "\n<!-- /wp:shortcode -->",
	)
);
