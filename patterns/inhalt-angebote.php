<?php
/**
 * Title: Fallback – Angebote
 * Slug: stt/inhalt-angebote
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Angebote“ (Stand 29.10.2026, von der öffentlichen Seite übernommen).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$abend  = stt_seiten_url( 'transferabend-online' );
$gruppe = stt_seiten_url( 'gruppen-vor-ort' );
$angeh  = stt_seiten_url( 'angehoerige' );
$begl   = stt_seiten_url( 'therapeuten-und-coaches' );

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_ueberschrift( 'Regelmäßige Online-Abende von sysTelios TRANSFER' ),
		stt_m_absatz( 'Einmal im Monat treffen sich Interessierte, ehemalige Klientinnen und Klienten und Netzwerkmitglieder online. Jeder Abend hat ein eigenes Thema und wird von wechselnden Menschen aus dem Netzwerk gestaltet – Sie können von zu Hause aus teilnehmen, ganz gleich, wo Sie wohnen.' ),
		stt_m_liste(
			array(
				'Vielfältige Online-Formate: Im geschützten Raum mit wechselnden Inhalten und Anbietern',
				'Thematische Workshops: z. B. Burnout-Resilienz, Umgang mit Stresseinladungen, innere Stimmigkeit, Ressourcenarbeit, Imaginationstechniken',
				'niedrigschwelliger Zugang, regionale Offenheit',
				'Regelmäßig einmal im Monat',
			),
			'haken'
		),
		stt_m_knopf( 'Transferabend online', $abend ),

		stt_m_ueberschrift( 'Transfer vor Ort – für unterschiedliche Zielgruppen' ),
		stt_m_absatz( 'In regionalen Gruppen können ehemalige Klientinnen und Klienten der sysTelios KLINIK an ihre Erfahrungen anknüpfen und sie im Alltag lebendig halten. Die Gruppen werden von erfahrenen Netzwerkmitgliedern begleitet und stehen teilweise auch Menschen offen, die sich auf einen Aufenthalt in der Klinik vorbereiten.' ),
		stt_m_liste(
			array(
				'Transfergruppen vor Ort: mit Austausch, Meditation und Achtsamkeit, Anliegenarbeit',
				'Für ' . stt_m_link( 'ehemalige Klienten und Klientinnen', $gruppe ) . ' des sysTelios KLINIK und für ' . stt_m_link( 'Angehörige', $angeh ),
				'Hypnosystemisch – und im sysTelios-Stil: Augenhöhe, Resonanzräume, Herz- und Transparenzkultur',
				'Die Brücke von Klinik zu Alltag gestalten wir gemeinsam mit Ihnen',
				'Begleitung bei Herausforderungen (persönlich, beruflich, Übergang)',
				'Die Formate variieren je nach Ausgestaltung der Treffen durch die Netzwerkmitglieder und die Präferenzen der Teilnehmenden',
				'Auch im Vorfeld eines Aufenthalts in der sysTelios KLINIK',
			),
			'haken'
		),
		stt_m_knopf( 'Transfergruppen vor Ort', $gruppe ),

		stt_m_ueberschrift( 'Angebote für Angehörige – Austausch in der Region und online' ),
		stt_m_absatz( 'Wenn ein Mensch aus der Familie in der sysTelios KLINIK ist, bewegt das oft auch die Angehörigen zu Hause. Fragen tauchen auf, Rollen verändern sich, und der Wunsch nach Austausch wächst.' ),
		stt_m_liste(
			array(
				'Eigene Gruppen für Angehörige: Raum für Ihre Fragen und Erfahrungen, begleitet von erfahrenen Netzwerkmitgliedern',
				'Austausch mit anderen: Menschen kennenlernen, die in einer ähnlichen Situation sind',
				'In mehreren Regionen und online: Die aktuelle Übersicht mit Ansprechpersonen finden Sie auf der Seite für Angehörige',
				'Hypnosystemische Haltung: wertschätzend, an Ressourcen orientiert, auf Augenhöhe',
			),
			'haken'
		),
		stt_m_knopf( 'Angebote für Angehörige', $angeh ),

		stt_m_band(
			'warm',
			stt_m_zusammen(
				array(
					stt_m_ueberschrift( 'Direkt zu den Begleiter*innen' ),
					stt_m_absatz( 'Sie suchen eine Therapeutin, einen Coach oder eine Beraterin für Ihr persönliches Anliegen? In der Übersicht stellen sich die Mitglieder des Netzwerks vor.' ),
					stt_m_knopf( 'Begleiter*innen', $begl ),
				)
			)
		),

		stt_m_familienhinweis(
			'lebensart',
			'Weiterlernen in der Lernreise',
			'[Kurzer Text, was die Lernreise für Menschen aus dem Netzwerk bietet.]',
			array( 'lernreise' => 'Zur Lernreise bei LEBENSART' )
		),

		stt_m_heilkunde(),
	)
);
