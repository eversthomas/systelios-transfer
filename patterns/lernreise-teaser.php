<?php
/**
 * Title: Lernreise (LEBENSART)
 * Slug: stt/lernreise-teaser
 * Categories: stt-transfer
 * Description: Karte „Angebot von LEBENSART“ mit Button zur Lernreise. Das Ziel stammt aus den Transfer-Einstellungen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo stt_m_gruppe( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	"\n" . stt_m_zusammen(
		array(
			stt_m_absatz( 'Angebot von LEBENSART', 'is-style-tag' ),
			stt_m_ueberschrift( 'Lernreise', 3 ),
			stt_m_absatz( '[Kurzbeschreibung der Lernreise aus Sicht von Transfer.]' ),
			"<!-- wp:shortcode -->\n[stt_lernreise_button]\n<!-- /wp:shortcode -->",
		)
	) . "\n",
	'is-style-karte'
);
