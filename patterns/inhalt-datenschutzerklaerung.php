<?php
/**
 * Title: Fallback – Datenschutzerklärung
 * Slug: stt/inhalt-datenschutzerklaerung
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Datenschutzerklärung“ (Ist-Zustand von systelios-transfer.de, Stand 29.10.2026). Rechtlich verbindlicher Text: vor der Live-Schaltung mit der Seite im Live-System abgleichen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_absatz( 'Herzlich willkommen auf der Website unseres Netzwerks! Der Schutz deiner persönlichen Daten liegt uns sehr am Herzen. Nachfolgend erklären wir dir, welche Daten wir erheben, wie wir sie verwenden und welche Rechte du hast.' ),
		stt_m_ueberschrift( '1. Verantwortlicher und Kontakt' ),
		stt_m_ueberschrift( 'Verantwortlich für die Datenverarbeitung', 3 ),
		stt_m_absatz( 'Thorsten Franz<br>E-Mail: ' . stt_m_link( 'thorsten@organisationsgaertner.de', 'mailto:thorsten@organisationsgaertner.de' ) . ' (vorübergehend)' ),
		stt_m_absatz( 'Für Fragen zum Datenschutz erreichst du uns jederzeit unter der o. g. E-Mail-Adresse.' ),
		stt_m_ueberschrift( '2. Hosting und Auftragsverarbeitung' ),
		stt_m_absatz( 'Unsere Website wird gehostet bei Strato AG, Deutschland.' ),
		stt_m_absatz( 'Mit Strato besteht ein Vertrag zur Auftragsdatenverarbeitung (ADV). Daten, die beim Aufrufen unserer Website entstehen (z. B. Serverlogs), werden ausschließlich von Strato verarbeitet.' ),
		stt_m_ueberschrift( '3. Erhobene Daten und Zweck' ),
		stt_m_ueberschrift( 'Serverlogfiles', 3 ),
		stt_m_absatz( 'Beim Besuch der Website werden automatisch technische Daten erfasst, z. B.' ),
		stt_m_liste(
			array(
				'Browsertyp',
				'Betriebssystem',
				'IP-Adresse (anonymisiert)',
				'Datum und Uhrzeit des Aufrufs',
			)
		),
		stt_m_absatz( 'Diese Daten dienen allein der Sicherstellung eines störungsfreien Betriebs und der technischen Administration der Seite.' ),
		stt_m_ueberschrift( 'Mitglieder-Profile', 3 ),
		stt_m_absatz( 'In unserem Netzwerk stellen einzelne Mitglieder ihre Angebote vor. Namen, Logos und Beschreibungen dieser Mitglieder werden auf unseren Seiten veröffentlicht. Die Mitglieder sind selbst für ihre Inhalte verantwortlich.' ),
		stt_m_ueberschrift( '4. Cookies' ),
		stt_m_absatz( 'Wir setzen keine Tracking- oder Analysetools ein (z. B. Matomo, Google Analytics).' ),
		stt_m_absatz( 'WordPress-Standardcookies kommen nur für eingeloggte Administratoren zum Einsatz. Besucher ohne Login erhalten keine Cookies.' ),
		stt_m_ueberschrift( '5. Externe Ressourcen' ),
		stt_m_ueberschrift( 'Schriftarten', 3 ),
		stt_m_absatz( 'Google Web Fonts werden lokal auf unserem Server eingebunden. Es findet keine Datenübermittlung an Google-Server statt.' ),
		stt_m_ueberschrift( 'Keine Social-Media-Plugins', 3 ),
		stt_m_absatz( 'Es werden keine Plugins von Drittanbietern wie Facebook, Twitter o. Ä. eingesetzt.' ),
		stt_m_ueberschrift( 'Keine Videos, keine Kommentar-Formulare', 3 ),
		stt_m_absatz( 'Aktuell binden wir weder YouTube-Videos ein noch nutzen wir Kontakt- oder Kommentarformulare.' ),
		stt_m_ueberschrift( '6. Weitergabe von Daten' ),
		stt_m_absatz( 'Wir geben keine personenbezogenen Daten an Dritte weiter, außer' ),
		stt_m_liste(
			array(
				'zur Erfüllung gesetzlicher Pflichten oder',
				'im Rahmen der ADV mit Strato.',
			)
		),
		stt_m_ueberschrift( '7. Deine Rechte' ),
		stt_m_absatz( 'Du hast jederzeit das Recht auf' ),
		stt_m_liste(
			array(
				'Auskunft über deine gespeicherten Daten',
				'Berichtigung unrichtiger Daten',
				'Löschung oder Einschränkung der Verarbeitung',
				'Widerspruch gegen Verarbeitung',
				'Datenübertragbarkeit',
			)
		),
		stt_m_absatz( 'Zur Ausübung deiner Rechte schreib uns einfach an ' . stt_m_link( 'thorsten@organisationsgaertner.de', 'mailto:thorsten@organisationsgaertner.de' ) . '.' ),
		stt_m_ueberschrift( '8. Sicherheit' ),
		stt_m_absatz( 'Wir treffen technische und organisatorische Maßnahmen, um deine Daten zu schützen. Unsere Sicherheitsstandards werden regelmäßig überprüft und dem Stand der Technik angepasst.' ),
		stt_m_ueberschrift( '9. Änderungen der Datenschutzerklärung' ),
		stt_m_absatz( 'Diese Datenschutzerklärung kann von Zeit zu Zeit angepasst werden. Bitte sieh regelmäßig hier vorbei, um den aktuellen Stand zu erfahren.' ),
		stt_m_absatz( 'Letzte Aktualisierung: 4. Juli 2025' ),
	)
);
