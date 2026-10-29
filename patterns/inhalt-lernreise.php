<?php
/**
 * Title: Fallback – Lernreise
 * Slug: stt/inhalt-lernreise
 * Inserter: no
 * Description: Platzhalter-Inhalt der Seite „Lernreise“. Die Texte schreibt das Team aus Transfer-Sicht (Entscheidung D11); nichts von LEBENSART kopieren.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ENTSCHEIDUNG D11: Platzhaltertexte in eckigen Klammern.
echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_ueberschrift( '[Für wen aus dem Netzwerk]' ),
		stt_m_absatz( '[Text: Für welche Menschen aus dem Netzwerk die Lernreise gedacht ist.]' ),
		stt_m_ueberschrift( '[Wie die Lernreise zu Transferabend und Gruppen passt]' ),
		stt_m_absatz( '[Text: Wie sich die Lernreise zu Transferabend und Gruppen vor Ort verhält.]' ),
		stt_m_familienhinweis(
			'lebensart',
			'[Überschrift]',
			'[Kurzer Text zur Lernreise bei LEBENSART.]',
			array( 'lernreise' => 'Zur Lernreise bei LEBENSART' )
		),
	)
);
