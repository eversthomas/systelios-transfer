<?php
/**
 * Title: Fallback – Charta
 * Slug: stt/inhalt-charta
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Charta“ (Ist-Zustand von systelios-transfer.de, Stand 29.10.2026). Text der Charta der Netzwerkgruppe.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_ueberschrift( 'Charta' ),
		stt_m_absatz( 'Unsere Arbeit basiert auf der Überzeugung, dass Menschen und Organisationen sich selbst organisieren und weiterentwickeln können. Dabei sind Wahlfreiheit und Selbstbestimmung (Autopoiese) zentrale Werte unseres Ansatzes. Wir orientieren uns am Konstruktivismus, also der Idee, dass Wirklichkeit durch die Fokussierung unserer Aufmerksamkeit entsteht, und nutzen dabei das Wissen um synergetische, sich gegenseitig unterstützende Prozesse.' ),
		stt_m_absatz( 'Im Umgang mit Menschen bieten wir verschiedene Perspektiven und alternative Sichtweisen an. Wir begegnen unseren Klientinnen grundsätzlich mit Respekt, auf Augen- und Herzhöhe, und bringen ihnen Vertrauen und Offenheit entgegen. Durch kontinuierliche Feedbackschleifen sorgen wir für Transparenz bezüglich unserer eigenen Wahrnehmungen, Hypothesen und Interventionen.' ),
		stt_m_absatz( 'Unsere Haltung ist wertschätzend und forschend, und wir fördern aktiv den Austausch individueller Sichtweisen. Dabei verstehen wir unsere Klientinnen als Expert*innen für ihr eigenes Leben und ihre Prozesse.' ),
		stt_m_absatz( 'In der hypnosystemischen Arbeit legen wir besonderen Wert auf ein achtsames Bewusstsein für Kontext und Wirkung. Wir arbeiten mit inneren Anteilen und etablieren eine beobachtende Position, die Steuerung ermöglicht und auf Kongruenz von Inhalt und Form achtet.' ),
		stt_m_absatz( 'Hypnosystemische Prinzipien wie die Nutzung unbewusster Ressourcen, Trancephänomene und die Kybernetik zweiter Ordnung bilden dabei zentrale Bestandteile unseres methodischen Repertoires. Gleichzeitig reflektieren wir regelmäßig und systematisch unsere Prozesse.' ),
		stt_m_absatz( 'Wir betrachten Probleme nicht als Hindernisse, sondern als Lösungsversuche, die einen bestimmten Preis haben. Daher würdigen wir den Nutzen automatischer, unbewusster Prozesse und beziehen sowohl geistige als auch körperliche Wechselwirkungen mit ein.' ),
		stt_m_absatz( 'Unsere Arbeit fördert die Kooperation zwischen Bewusstem und Unbewusstem und schafft Raum für die individuelle Entwicklung im Kontext sozialer Beziehungen (bezogene Individuation). Dabei sehen wir Konzepte und Methoden nicht als starre Vorgaben, sondern als lebendige Werkzeuge, die stets flexibel angepasst und reflektiert werden können.' ),
		stt_m_ueberschrift( '1. Erkenntnis', 3 ),
		stt_m_liste(
			array(
				'Selbstorganisierende Prozesse und Organismen',
				'Wahlfreiheit',
				'Autopoiese',
				'Konstruktivismus',
				'Wirklichkeit wird ständig durch Fokussierung von Aufmerksamkeit erzeugt',
				'Synergetik',
			)
		),
		stt_m_ueberschrift( '2. Umgang mit Menschen', 3 ),
		stt_m_liste(
			array(
				'Angebote von Realitäten und alternativer Sichtweisen',
				'Vertrauensvorschuss, Vorannahme von „Guten Gründen“',
				'Augehöhe und Herzhöhe',
				'Fortwährende Feedbackschleifen',
				'Transparenz über eigene Wirklichkeitskonstruktionen, Hypothesen und therapeutische Interventionen',
				'Wertschätzende, forschende Haltung',
				'Austausch von subjektiven Wirklichkeiten und Wahrgebungen',
				'Klienten als Experten für eigene Prozesse',
			)
		),
		stt_m_ueberschrift( '3. Hypno- und systemische Aspekte', 3 ),
		stt_m_liste(
			array(
				'Auswirkungs- und Kontextbewusstsein',
				'Arbeit mit inneren Anteilen',
				'Etablierung einer steuernden Beobachterposition',
				'Kongruenz von Inhalt und Form',
				'Utilisationsprinzip',
				'Nutzung von Trancephänomenen',
				'Kybernetik 2. Ordnung',
				'Systematisierte anhaltende Prozessreflektion',
			)
		),
		stt_m_ueberschrift( '4. Hypno- und systemische Aspekte', 3 ),
		stt_m_liste(
			array(
				'Problemerleben als Lösungsversuche mit Preis',
				'Wertschätzung und Nutzen von unwillkürlichen Prozessen',
				'Wechselwirkung von körperlichen und geistigen Abläufen – ganzheitliche Sichtweise',
				'Kooperation von Bewusstsein und Unbewussten',
				'Räume schaffen für „bezogene Individuation“',
				'Etablierung und Stärkung einer Haltung und metatheoretische Sichtweise – keine Verdinglichung von Konzepten und Methoden',
			)
		),
	)
);
