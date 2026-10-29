<?php
/**
 * Title: Hinweis aus der Familie
 * Slug: stt/familienhinweis
 * Categories: stt-transfer
 * Description: Karte in der Farbe des Hauses, auf das verwiesen wird (z. B. LEBENSART), mit Text und Button.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo stt_m_familienhinweis( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	'lebensart',
	'[Überschrift des Hinweises]',
	'[Kurzer Text, was Besucher*innen bei dem anderen Haus erwartet.]',
	array(
		'text' => 'Mehr erfahren',
		'url'  => ( stt_familie_haus( 'lebensart' )['link'] ?? home_url( '/' ) ),
	)
);
