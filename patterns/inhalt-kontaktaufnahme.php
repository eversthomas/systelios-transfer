<?php
/**
 * Title: Fallback – Kontaktaufnahme
 * Slug: stt/inhalt-kontaktaufnahme
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Kontaktaufnahme“ (Stand 29.10.2026). Das Formular kommt per Shortcode [stt_kontakt] (Entscheidung D3).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ENTSCHEIDUNG D3: Das Elementor-Formular wird nicht nachgebaut, sondern per Shortcode [stt_kontakt] eingebunden.
echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		"<!-- wp:shortcode -->\n[stt_kontakt]\n<!-- /wp:shortcode -->",
		stt_m_ueberschrift( 'Weitere Wege zu uns' ),
		stt_m_absatz( 'Per E-Mail<br>' . stt_m_link( 'transfer@sysTelios.de', 'mailto:transfer@systelios.de' ) ),
		stt_m_absatz( 'Sie suchen eine Begleitung?<br>Die Kontaktdaten der Mitglieder finden Sie direkt im Verzeichnis.' ),
		stt_m_knopf( 'Begleiter*innen', stt_seiten_url( 'therapeuten-und-coaches' ) ),
		stt_m_familie_abschnitt(),
	)
);
