<?php
/**
 * Title: Fallback – Transferabend online
 * Slug: stt/inhalt-transferabend-online
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Transferabend online“ (Stand 29.10.2026). Die Termine kommen per Shortcode aus BSEasy Sync.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shortcodes = stt_shortcodes();

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_absatz( 'Monatlicher Transferabend online: Hier finden Sie regelmäßig (jeden ersten Dienstag im Monat) stattfindende Online-Veranstaltungen von unseren Netzwerkmitgliedern. Zu unterschiedlichen Themen erhalten Sie hier Impulse, können an hypnosystemischer Kultur des Miteinanders andocken, den Kontakt dazu aufrecht erhalten und mit anderen Menschen in den Dialog kommen.' ),
		stt_m_absatz( 'Die Angebote sind für Sie kostenfrei. Die Anmeldung können Sie direkt hier vornehmen oder – sofern separat angegeben – auch über die Webseite des jeweiligen Netzwerkmitglieds.' ),
		stt_m_absatz( '<strong>An wen richten sich die Abende:</strong> Insbesondere an ehemalige Klienten und Klientinnen der sysTelios Klinik und auch an Menschen, die sich generell für die Haltung und Wirkzeuge (das ist kein Tippfehler ;-)) der Hypnosystemik interessieren. Der Fokus liegt dabei auf Selbsterfahrung und der Einladung, sich auch mit eigenen Anliegen auf Augenhöhe einzubringen und zu begegnen.' ),
		stt_m_absatz( 'Natürlich schließen wir auch interessierte therapeutisch oder coachend tätige Kolleg*innen nicht aus. Hier haben wir die Bitte, sich in den Dialogräumen der Treffen im kollegialen Respekt und der achtsamen Wahrung des Raumes für die Menschen mit Anliegen, hinsichtlich eigener Interventionsangebote enthaltsam zu zeigen.' ),
		stt_m_ueberschrift( 'Transfer-Online' ),
		"<!-- wp:shortcode -->\n" . $shortcodes['termine_transferabend'] . "\n<!-- /wp:shortcode -->",
	)
);
