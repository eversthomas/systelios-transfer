<?php
/**
 * Title: Fallback – Gruppen vor Ort
 * Slug: stt/inhalt-gruppen-vor-ort
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Gruppen vor Ort“ (Stand 29.10.2026). Die Liste wird von Hand gepflegt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bereiche = array(
	'plz-3'      => array(
		'titel'     => 'PLZ-Bereich 3',
		'eintraege' => array(
			array( 'text' => 'Braunschweig - Iris Jahns, Marina Wille', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Braunschweig_Jahns_Wille.pdf' ),
			array( 'text' => 'Göttingen - Andreas Klatt', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Goettingen_Klatt.pdf' ),
		),
	),
	'plz-4'      => array(
		'titel'     => 'PLZ-Bereich 4',
		'eintraege' => array(
			array( 'text' => 'Essen - Carolin Wolf', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Essen_Wolf.pdf' ),
		),
	),
	'plz-5'      => array(
		'titel'     => 'PLZ-Bereich 5',
		'eintraege' => array(
			array( 'text' => 'Mainz/Worms - Karin Dölla-Höhfeld, Günther Höhfeld', 'upload' => '2026/01/systelios_Transfer_Gruppe_Mainz-Worms_Doella-Hoehfeld.pdf' ),
		),
	),
	'plz-6'      => array(
		'titel'     => 'PLZ-Bereich 6',
		'eintraege' => array(
			array( 'text' => 'Darmstadt - Marcus Ackermann', 'upload' => '2026/01/sysTelios_Transfer_offene_Gruppe_Darmstadt_Ackermann.pdf' ),
			array( 'text' => 'Darmstadt - Patricia Gill-Schultz', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Darmstadt_Gill-Schultz_2019.pdf' ),
			array( 'text' => 'Heidelberg - Daniel Konermann', 'url' => 'https://www.daniel-konermann.de/angebot/ambulante-gruppe/' ),
			array( 'text' => 'Heidelberg - Katja Dienemann (Natur-Coaching-Gruppe)', 'upload' => '2026/01/sysTelios-TRANSFER_Natur-Coaching-Gruppe_Heidelberg_2024.pdf' ),
			array( 'text' => 'Hemsbach - Dr. Alexandra Schichtel (tiergestützte Coaching-Gruppe)', 'url' => 'https://www.eselsbruecke.eu/auszeit-wanderungen/tiergestuetzte-therapie-in-kooperation-mit-systelios-transfer' ),
			array( 'text' => 'Mannheim - Ulrike Gutzeit (körperorientierte Musiktherapie)', 'upload' => '2026/03/Musiktherapie-Gruppen-vor-Ort.pdf' ),
			array( 'text' => 'Pfalz - Dieter Probst', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Pfalz_Probst_2019.pdf' ),
			array( 'text' => 'Speyer - Anita Gallitzendörfer', 'url' => 'https://www.scola-bildungsakademie.de/systelios-transfer' ),
			array( 'text' => 'Weinheim - Katharina von Maltzahn', 'upload' => '2026/07/systelios_transfer_gruppe-Weinheim.pdf' ),
		),
	),
	'plz-7'      => array(
		'titel'     => 'PLZ-Bereich 7',
		'eintraege' => array(
			array( 'text' => 'Bruchsal/Karlsruhe - Hans-Jörg Betz, Claudia Lehel-Slepica', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Bruchsal-Karlsruhe_Betz_Lehel-Slepica.pdf' ),
			array( 'text' => 'Esslingen am Neckar - Martina Janosch', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Esslingen_Janosch_2019.pdf' ),
			array( 'text' => 'Freiburg im Breisgau - Clemens Michalak', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Freiburg_Michalek.pdf' ),
		),
	),
	'plz-8'      => array(
		'titel'     => 'PLZ-Bereich 8',
		'eintraege' => array(
			array( 'text' => 'München - Dr. Tom Latka, Beatrice von Mallinckrodt', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Muenchen_Latka_von_Mallinckrodt_2019.pdf' ),
		),
	),
	'plz-0129'   => array(
		'titel'     => 'PLZ-Bereiche 0, 1, 2, 9',
		'eintraege' => array(
			array( 'text' => 'Zur Zeit leider keine Angebote, nutzen Sie gerne z.B. das Online-Angebot' ),
		),
	),
	'oesterreich' => array(
		'titel'     => 'Österreich',
		'eintraege' => array(
			array( 'text' => 'Salzburg - Beatrice von Mallinckrodt (inhalltich identisch zu dem Münchener Angebot)', 'upload' => '2026/01/sysTelios_Transfer_Gruppe_Muenchen_Latka_von_Mallinckrodt_2019.pdf' ),
		),
	),
	'online'     => array(
		'titel'     => 'Online',
		'eintraege' => array(
			array( 'text' => 'Oliver Kiss (online)', 'upload' => '2026/09/sysTelios-Trasfer-Gruppe-online_Kiss_2026.pdf' ),
		),
	),
);

$punkte = array();
foreach ( $bereiche as $anker => $bereich ) {
	$punkte[ $anker ] = $bereich['titel'];
}

$bild = stt_bild_block( stt_anhang_nach_name( 'Bild-vor-Ort' ), false, 'large', 'Informationen für die Gruppen vor Ort' );

$kopf = array(
	'knopf' => stt_m_knopf( 'Informationen zu den Klient*innen-Gruppen vor Ort', stt_upload_url( '2026/01/sysTelios_Transfer_Gruppen_vor_Ort_Flyer.pdf' ), 'umriss' ),
);

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_absatz( 'Sie können sysTelios-Transfer auch in den Gruppen vor Ort erleben. Es gibt zwei zwei Angebotsformate, die Transfer erleben lassen: Gruppen für ehemalige Klienten und Klientinnen sowie Gruppen ' . stt_m_link( 'für Angehörige', stt_seiten_url( 'angehoerige' ) ) . ' von Klient*innen.<br>Beide Formate werden von erfahrenen Netzwerkmitgliedern angeboten. Schauen Sie unten einmal nach, ob in Ihrer Region zur Zeit Angebote stattfinden.' ),
		stt_m_spalten(
			array_filter(
				array(
					'' !== $bild ? array( 'breite' => '40%', 'inhalt' => $bild ) : array(),
					array(
						'breite' => '' !== $bild ? '60%' : '',
						'inhalt' => stt_m_zusammen(
							array(
								$kopf['knopf'],
								stt_m_absatz( 'In den Gruppen vor Ort können ehemalige Klientinnen und Klienten an Ihre Erfahrungen und Prozesse in der sysTelios Klinik andocken und in der Gruppe – von erfahrenen Kolleginnen und Kollegen begleitet – weitere Unterstützung erfahren.' ),
								stt_m_absatz( 'Einige Kolleginnen und Kollegen bieten auch Menschen, die sich für einen Aufenthalt in der Klinik interessieren, die Möglichkeit, vorab mit Ihrem Anliegen in eine Gruppe zu kommen.' ),
							)
						),
					),
				)
			)
		),
		stt_m_absatz( 'In der nachfolgenden Übersicht finden Sie Angebote in verschiedenen Regionen mit einem Link zu weiteren Informationen und Anmeldemöglichkeiten. Die Kontaktdaten der jeweiligen Anbieter finden Sie auch in der ' . stt_m_link( 'Übersicht der Berater und Beraterinnen', stt_seiten_url( 'therapeuten-und-coaches' ) ) . '.' ),
		stt_m_sprungleiste( $punkte ),
		stt_m_regionen( $bereiche ),
	)
);
