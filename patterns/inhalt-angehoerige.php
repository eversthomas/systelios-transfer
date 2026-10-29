<?php
/**
 * Title: Fallback – Für Angehörige
 * Slug: stt/inhalt-angehoerige
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Für Angehörige“ (Stand 29.10.2026). Die Liste wird von Hand gepflegt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bereiche = array(
	'plz-3'     => array(
		'titel'     => 'PLZ-Bereich 3',
		'eintraege' => array(
			array( 'text' => 'Braunschweig - Iris Jahns', 'upload' => '2026/01/sysTelios_Transfer_Angebote_fuer_Angehoerige_Jahns.pdf' ),
		),
	),
	'plz-4'     => array(
		'titel'     => 'PLZ-Bereich 4',
		'eintraege' => array(
			array( 'text' => 'Essen - Carolin Wolf', 'upload' => '2026/01/sysTelios_Transfer_Angebote_fuer_Angehoerige_Wolf.pdf' ),
		),
	),
	'plz-6'     => array(
		'titel'     => 'PLZ-Bereich 6',
		'eintraege' => array(
			array( 'text' => 'Darmstadt - Marcus Ackermann', 'upload' => '2026/01/sysTelios_Transfer_Angebote_fuer_Angehoerige_Ackermann.pdf' ),
		),
	),
	'plz-7'     => array(
		'titel'     => 'PLZ-Bereich 7',
		'eintraege' => array(
			array( 'text' => 'Karlsruhe/Bruchsal - Hans-Jörg Betz, Claudia Lehel-Slepica', 'upload' => '2026/01/sysTelios_Transfer_Angebote_fuer_Angehoerige_Betz_Lehel-Slepica.pdf' ),
		),
	),
	'plz-01258' => array(
		'titel'     => 'PLZ-Bereiche 0, 1, 2, 5, 8, 9',
		'eintraege' => array(
			array( 'text' => 'Zur Zeit leider keine Angebote für Angehörige - nutzen Sie gerne z.B. das online-Angebot' ),
		),
	),
	'online'    => array(
		'titel'     => 'Online',
		'eintraege' => array(
			array( 'text' => 'Hilke Prager, Christiane Broßonn-Bentz (Info + Anmeldung)', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdxe_mvxZXkBmB0lIe9osQcZiR6VvpxLvcJovWSwiNc4JPxUA/viewform' ),
		),
	),
);

$punkte = array();
foreach ( $bereiche as $anker => $bereich ) {
	$punkte[ $anker ] = $bereich['titel'];
}

$bild = stt_bild_block( stt_anhang_nach_name( 'Bild-Angehoerige' ), false, 'large', 'Angebot für Angehörige' );

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_absatz( 'Sie können sysTelios-Transfer auch vor Ort erleben. Es gibt zwei zwei Angebotsformate, die Transfer erleben lassen: Hier die Gruppen für Angehörige von Klient*innen sowie ' . stt_m_link( 'Gruppen für ehemalige Klienten und Klientinnen.', stt_seiten_url( 'gruppen-vor-ort' ) ) ),
		stt_m_absatz( 'Beide Formate werden von erfahrenen Netzwerkmitgliedern angeboten. Schauen Sie unten einmal nach, ob in Ihrer Region zur Zeit Angebote stattfinden.' ),
		stt_m_spalten(
			array_filter(
				array(
					'' !== $bild ? array( 'breite' => '40%', 'inhalt' => $bild ) : array(),
					array(
						'breite' => '' !== $bild ? '60%' : '',
						'inhalt' => stt_m_zusammen(
							array(
								stt_m_knopf( 'Informationen zu den Angeboten für Angehörige', stt_upload_url( '2026/01/sysTelios_Transfer_Angebote_fuer_Angehoerige_Flyer.pdf' ), 'umriss' ),
								stt_m_absatz( 'Ein stationärer Aufenthalt eines Angehörigen hat oft auch Auswirkungen auf das heimatliche Familiensystem. Dabei tauchen Fragen auf oder es entsteht der Bedarf nach Austausch mit anderen Menschen in der ähnlichen Situation. Hierfür gibt es Gruppen, die sich an Angehörige von Klienten und Klientinnen richten.' ),
							)
						),
					),
				)
			)
		),
		stt_m_absatz( 'In der nachfolgenden Übersicht finden Sie Angebote in verschiedenen Regionen mit einem Link zu weiteren Informationen und Anmeldemöglichkeiten. Die Kontaktdaten der jeweiligen Anbieter finden Sie in der ' . stt_m_link( 'Übersicht der Berater und Beraterinnen.', stt_seiten_url( 'therapeuten-und-coaches' ) ) ),
		stt_m_sprungleiste( $punkte ),
		stt_m_regionen( $bereiche ),
	)
);
