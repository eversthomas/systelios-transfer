<?php
/**
 * Title: Fallback – Was ist Hypnosystemik
 * Slug: stt/inhalt-was-ist-hypnosystemik
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Was ist Hypnosystemik“ (Stand 29.10.2026).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$begl   = stt_seiten_url( 'therapeuten-und-coaches' );
$bild_a = stt_bild_block( stt_anhang_nach_name( '20250510_125815125_iOS' ), false, 'large', 'Pinnwand mit vielen Notizzetteln in einem Seminarraum' );
$bild_b = stt_bild_block( stt_anhang_nach_name( 'C4F6A96E-8931' ), false, 'large', 'Gunther Schmidt', 'https://gunther-schmidt.net/' );
$bild_c = stt_bild_block( stt_anhang_nach_name( 'blake-verdoorn-cssvEZacHvQ' ), false, 'large', 'Wasserfall mit Steinbrücke in grünem Wald' );
$bild_d = stt_bild_block( stt_anhang_nach_name( '1374CF74-C59A' ), false, 'large', 'sysTelios Transfer' );

$zugang = array(
	stt_m_ueberschrift( 'Ein erster Zugang', 2, 'zugang' ),
	stt_m_absatz( 'Wenn wir im ' . stt_m_link( 'Netzwerk', $begl ) . ' auf die Frage „Was ist Hypnosystemik?“ antworten, meinen wir kein starres Verfahren, sondern eine Haltung. Sie prägt die Art und Weise, wie wir auf Menschen, auf Teams und auf ganze Organisationen schauen.' ),
	stt_m_absatz( 'Im Mittelpunkt steht die Überzeugung: Probleme sind keine Defekte, sondern sinnvolle Lösungsversuche, die zu teuer geworden sind.' ),
	stt_m_absatz( 'Diese Haltung macht Hoffnung. Denn wer ein Symptom oder eine Krise nicht als „Fehler“ verstehen muss, kann beginnen, darin eine Ressource zu erkennen. Hypnosystemische Arbeit bedeutet, genau diese Ressourcen aufzuspüren und sie in neue Bahnen zu lenken – in Richtung Stimmigkeit, Lebendigkeit und Kooperation.' ),
);

$wurzeln = array(
	stt_m_ueberschrift( 'Wurzeln der Hypnosystemik', 2, 'wurzeln' ),
	stt_m_absatz( 'Die Hypnosystemik wurde in den 1980er Jahren von ' . stt_m_link( 'Dr. Gunther Schmidt', 'https://gunther-schmidt.net/', true ) . ' entwickelt, dem Gründer der ' . stt_m_link( 'sysTelios KLINIK', 'https://www.systelios.de', true ) . ' in Siedelsbrunn und langjährigem Leiter des Milton-Erickson-Instituts Heidelberg.' ),
	stt_m_absatz( 'Sie verbindet zwei wesentliche Strömungen:' ),
	stt_m_spalten(
		array(
			array(
				'inhalt' => stt_m_gruppe(
					"\n" . stt_m_zusammen(
						array(
							stt_m_ueberschrift( 'Die Hypnotherapie nach Milton H. Erickson', 3 ),
							stt_m_absatz( 'Erickson zeigte, dass Menschen auch in alltäglichen Gesprächen in „Trancezustände“ eintreten – Phasen fokussierter Aufmerksamkeit, in denen Veränderung besonders leicht möglich wird. Sein Prinzip der Utilisation – mit allem arbeiten, was da ist – bildet ein Herzstück auch der Hypnosystemik.' ),
						)
					) . "\n",
					'is-style-karte hat-punkt'
				),
			),
			array(
				'inhalt' => stt_m_gruppe(
					"\n" . stt_m_zusammen(
						array(
							stt_m_ueberschrift( 'Systemisches Denken und systemische Familientherapie', 3 ),
							stt_m_absatz( 'Systemische Theorie betrachtet den Menschen nie isoliert, sondern immer im Beziehungsnetz: Familie, Arbeit, Kultur, Gesellschaft. Zentral ist die Annahme, dass Systeme sich selbst organisieren (Autopoiese) und dass Veränderung nicht durch direkte Steuerung, sondern durch Einladungen und Resonanz möglich ist.' ),
						)
					) . "\n",
					'is-style-karte hat-punkt'
				),
			),
		),
		'stt-raster'
	),
	stt_m_absatz( 'Gunther Schmidt hat diese beiden Strömungen nicht einfach addiert, sondern zu einem eigenständigen Ansatz verwoben: der Hypnosystemik.' ),
	$bild_b,
);

$praxis = array(
	stt_m_ueberschrift( 'Hypnosystemik in der Praxis', 2, 'praxis' ),
	stt_m_liste(
		array(
			'Hypnosystemisches Arbeiten bedeutet, Aufmerksamkeit bewusst zu lenken. Denn das, worauf wir unsere Wahrnehmung richten, bestimmt unser Erleben.',
			'In einer Problemtrance richtet sich die Aufmerksamkeit vor allem auf Defizite, Blockaden und Hindernisse.',
			'In einer Lösungstrance werden Ressourcen, Möglichkeiten und Zukunftsperspektiven erfahrbar.',
			'Die Aufgabe von Beraterinnen, Therapeutinnen oder Coaches ist es, Angebote zu machen – kleine Verschiebungen in Sprache, in Bildern, in Körperhaltungen. Gunther Schmidt spricht hier vom „Realitätenkellner“: Wir servieren Optionen. Die Klient*innen – oder auch eine Organisation – „kosten“ und entscheiden selbst, was stimmig ist.',
		),
		'haken'
	),
	stt_m_absatz( 'Erleben können Sie diese Praxis auch in unseren ' . stt_m_link( 'Angeboten', stt_seiten_url( 'unsere-angebote' ) ) . '.' ),
	stt_m_ueberschrift( 'Die Weisheit des Körpers', 3 ),
	stt_m_absatz( 'Eine Besonderheit der Hypnosystemik ist das Vertrauen in die Körperweisheit. Stimmigkeit zeigt sich nicht zuerst im Kopf, sondern im Körper. Menschen spüren, ob eine Idee „passt“ – ob sie leicht wird, ob sich der Atem vertieft, ob die innere Spannung nachlässt. In hypnosystemischer Arbeit wird dieses Stimmigkeitserleben zum Kompass: Nur wenn eine Intervention körperlich resonant ist, wird sie weiterverfolgt. Damit verschiebt sich auch die Verantwortung: Nicht die Beraterin „weiß es besser“, sondern der Klient entscheidet. Das gilt in der Einzeltherapie ebenso wie in Teams oder Organisationen, die ihre „Atmosphäre“ und Kultur als Resonanzfeld spüren lernen.' ),
	stt_m_ueberschrift( 'Ambivalenzen würdigen', 3 ),
	$bild_c,
	stt_m_absatz( 'Ein weiteres zentrales Element ist der Umgang mit Ambivalenzen. Oft erleben Menschen – und auch Organisationen – widersprüchliche Wünsche, Ziele oder Aufträge. Statt diese Spannungen aufzulösen oder vorschnell zu „beseitigen“, würdigt die Hypnosystemik sie als kostbare Energiequellen. Ambivalenzen zeigen, dass mehrere wichtige Anliegen gleichzeitig im Spiel sind. Sie können, wenn klug begleitet, zu Innovation und Entwicklung führen.' ),
);

$organisationen = array(
	stt_m_ueberschrift( 'Hypnosystemik in Organisationen', 2, 'organisationen' ),
	stt_m_absatz( 'Hypnosystemik ist nicht auf die Arbeit mit Einzelnen beschränkt. Gerade in Organisationen entfaltet sie große Kraft:' ),
	stt_m_liste(
		array(
			'<strong>Organisationen als Systeme:</strong> Sie organisieren sich selbst, indem sie Strukturen, Prozesse und Programme entwickeln. Diese sind entscheidbare Prämissen – man kann sie verändern.',
			'<strong>Kultur und Werte:</strong> Gleichzeitig leben Organisationen von unentscheidbaren Prämissen – von Fragen nach Sinn, Identität und Haltung. Diese kann man nicht „verordnen“, sondern nur würdigen und in Resonanz bringen.',
			'<strong>Organisatorische Problemtrancen:</strong> Auch Institutionen können sich auf Defizite fixieren – etwa in endlosen Krisensitzungen. Hypnosystemische Arbeit hilft, den Blick zu öffnen: Welche Ressourcen sind vorhanden? Welche neuen Möglichkeiten entstehen?',
		),
		'haken'
	),
	stt_m_absatz( 'So wird eine Organisation mehr als ein Apparat: ein lebendiges Resonanzsystem.' ),
);

$klinik = array(
	stt_m_ueberschrift( 'Von der Klinik in den Alltag', 2, 'klinik' ),
	stt_m_absatz( 'Die ' . stt_m_link( 'sysTelios KLINIK in Siedelsbrunn', 'https://www.systelios.de', true ) . ' war – mit ihrer Vorläuferin – und ist die erste Klinik, die konsequent und umfänglich hypnosystemisch arbeitet, sowohl im Innern als auch im Außen. Hier erfahren Klienten und Klientinnen, wie diese Haltung konkret im Alltag wirkt – nicht nur in Gesprächen, sondern in Architektur, Kultur und Gemeinschaft.' ),
	stt_m_absatz( 'Wenn Sie sich über den Begriff wundern: Klienten und Klientinnen werden hier bewusst die Menschen genannt, die üblicherweise als Patienten und Patientinnen bezeichnet werden. Damit wird unter anderem deutlich, dass hier ein Auftrag erteilt und auf Augenhöhe kommuniziert wird.' ),
	stt_m_absatz( 'Mit sysTelios TRANSFER wurde ein Netzwerk geschaffen, das diesen Geist auch nach der Entlassung lebendig hält. Klientinnen und Klienten finden vor Ort ' . stt_m_link( 'Beraterinnen, Coaches und Therapeut*innen', $begl ) . ', die hypnosystemisch arbeiten.' ),
	stt_m_absatz( 'Auch Gruppenangebote vor Ort und online ermöglichen Austausch und Vertiefung: für ' . stt_m_link( 'Klienten und Klientinnen', stt_seiten_url( 'gruppen-vor-ort' ) ) . ', für ' . stt_m_link( 'Angehörige', stt_seiten_url( 'angehoerige' ) ) . ' und beim monatlichen ' . stt_m_link( 'Online-Abend', stt_seiten_url( 'transferabend-online' ) ) . ' auch für Interessierte.' ),
	stt_m_absatz( 'Zugleich ist sysTelios TRANSFER offen: Wer sich mit der hypnosystemischen Haltung verbunden fühlt, kann Teil des Netzwerks werden.' ),
	stt_m_absatz( 'So bleibt die Verbindung zwischen Klinik, Alltag und Gemeinschaft bestehen – getragen von einer Haltung, die Würdigung, Stimmigkeit und Augenhöhe ins Zentrum stellt.' ),
	$bild_d,
);

$punkt = array(
	stt_m_ueberschrift( 'Hypnosystemik auf den Punkt', 2, 'punkt' ),
	stt_m_liste(
		array(
			'Probleme würdigen statt bekämpfen.',
			'Aufmerksamkeit lenken heißt Wirklichkeit und Erleben gestalten.',
			'Der Körper entscheidet über Stimmigkeit.',
			'Ambivalenzen sind Ressourcen.',
			'Organisationen sind Resonanzsysteme.',
			'Berater*innen sind Realitätenkellner – Angebote statt Vorgaben.',
		),
		'nummern-gross',
		true
	),
);

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_sprungleiste(
			array(
				'zugang'         => 'Ein erster Zugang',
				'wurzeln'        => 'Wurzeln',
				'praxis'         => 'In der Praxis',
				'organisationen' => 'In Organisationen',
				'klinik'         => 'Von der Klinik in den Alltag',
				'punkt'          => 'Auf den Punkt',
			)
		),
		stt_m_zusammen(
			'' !== $bild_a
				? array( stt_m_spalten( array( array( 'breite' => '60%', 'inhalt' => stt_m_zusammen( $zugang ) ), array( 'breite' => '40%', 'inhalt' => $bild_a ) ) ) )
				: $zugang
		),
		stt_m_band( 'warm', stt_m_zusammen( $wurzeln ) ),
		stt_m_zusammen( $praxis ),
		stt_m_zusammen( $organisationen ),
		stt_m_zusammen( $klinik ),
		stt_m_familienhinweis(
			'lebensart',
			'Hypnosystemik vertiefen',
			'[Kurzer Text zur Lernreise bei LEBENSART.]',
			array( 'lernreise' => 'Zur Lernreise bei LEBENSART' )
		),
		stt_m_band( 'dunkel', stt_m_zusammen( $punkt ) ),
	)
);
