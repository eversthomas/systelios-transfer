<?php
/**
 * Title: Fallback – Impressum
 * Slug: stt/inhalt-impressum
 * Inserter: no
 * Description: Mitgelieferter Inhalt der Seite „Impressum“ (Ist-Zustand von systelios-transfer.de, Stand 29.10.2026). Rechtlich verbindlicher Text: vor der Live-Schaltung mit der Seite im Live-System abgleichen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo stt_m_zusammen( // phpcs:ignore WordPress.Security.EscapeOutput -- Markup aus stt_m_*().
	array(
		stt_m_ueberschrift( 'Anbieter dieser Website' ),
		stt_m_absatz( 'Angaben gemäß § 5 Digitale-Dienste-Gesetz (DDG)' ),
		stt_m_absatz( 'sysTelios Gesundheitszentrum Siedelsbrunn GmbH &amp; Co. KG<br>Am Tannenberg 17<br>69483 Wald-Michelbach<br>Deutschland' ),
		stt_m_absatz( 'Telefon: +49 6207 9249-0<br>Telefax: +49 6207 9249-295<br>E-Mail: ' . stt_m_link( 'transfer@sysTelios.de', 'mailto:transfer@systelios.de' ) ),
		stt_m_ueberschrift( 'Vertretungsberechtigt', 3 ),
		stt_m_absatz( 'Dr. Alexander Herr, Geschäftsführer<br>Andreas Reinhard, Geschäftsführer<br>Julia Schmidt, Geschäftsführerin' ),
		stt_m_ueberschrift( 'Gründungsgesellschafter', 3 ),
		stt_m_absatz( 'Mechthild Reinhard<br>Dr. med. Gunther Schmidt' ),
		stt_m_ueberschrift( 'Handelsregistereintrag', 3 ),
		stt_m_absatz( 'HRA 83349 Amtsgericht Darmstadt<br>Umsatzsteuer-Identifikationsnummer: DE249700546' ),
		stt_m_absatz( 'Persönlich haftende Gesellschafterin der GmbH &amp; Co. KG:<br>sysTelios Gesundheitszentrum Siedelsbrunn GmbH, Wald-Michelbach<br>HRB 85882 Amtsgericht Darmstadt<br>vertreten durch die Geschäftsführung:<br>Dr. Alexander Herr, Andreas Reinhard, Julia Schmidt' ),
		stt_m_ueberschrift( 'Verantwortlich für den Inhalt dieser Website im Sinne § 18 Absatz 2 Medienstaatsvertrag (MStV)', 3 ),
		stt_m_absatz( 'Dr. Alexander Herr, Andreas Reinhard, Julia Schmidt<br>– Anschrift und Kontaktdaten siehe oben –' ),
		stt_m_ueberschrift( 'Datenschutzbeauftragte', 3 ),
		stt_m_absatz( 'Bettina Konrad | externe Datenschutzbeauftragte<br>TÜV SÜD Akademie GmbH<br>Westendstraße 160<br>80339 München<br>Deutschland' ),
		stt_m_absatz( 'Telefon: +49 172 7388251<br>E-Mail: ' . stt_m_link( 'bettina.konrad@partner.tuvsud.com', 'mailto:bettina.konrad@partner.tuvsud.com' ) ),
		stt_m_absatz( 'Hier finden Sie ausführliche Informationen zum Datenschutz: ' . stt_m_link( 'Datenschutzerklärung', stt_seiten_url( 'datenschutzerklaerung' ) ) ),
		stt_m_ueberschrift( 'Aufsichtsbehörde gemäß § 5 Absatz 1 Nr. 3 DDG', 3 ),
		stt_m_absatz( 'Regierungspräsidium Darmstadt<br>Luisenplatz 2<br>64283 Darmstadt<br>Deutschland' ),
		stt_m_absatz( 'Telefon: +49 6151 12-0<br>Telefax: +49 6151 12-6347<br>E-Mail: ' . stt_m_link( 'poststelle@rpda.hessen.de', 'mailto:poststelle@rpda.hessen.de' ) ),
		stt_m_absatz( 'sysTelios TRANSFER ist ein Netzwerk von externen Kolleginnen und Kollegen, die wirtschaftlich unabhängig von der sysTelios Gesundheitszentrum GmbH &amp; Co. KG auf Basis hypnosystemischer Konzepte eigenverantwortlich tätig sind.' ),
		stt_m_ueberschrift( 'Hinweise zur Website' ),
		stt_m_absatz( 'Die Website www.sysTelios-Transfer.de ist ein Online-Angebot der sysTelios Gesundheitszentrum Siedelsbrunn GmbH &amp; Co. KG, Wald-Michelbach. Die Inhalte dieser Website dienen ausschließlich der Information der Besucherinnen und Besucher dieses Online-Angebots. Alle Inhalte wurden mit größtmöglicher Sorgfalt erstellt und werden regelmäßig aktualisiert. Dennoch können wir keine Gewähr für die jederzeitige Aktualität, Richtigkeit und Vollständigkeit der Informationen auf dieser Website übernehmen sowie auch nicht den jederzeitigen störungsfreien Zugang zur Website garantieren. Im Übrigen ist die Haftung auf Vorsatz und grobe Fahrlässigkeit beschränkt.' ),
		stt_m_absatz( 'Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte von Webseiten Dritter, auf die wir durch Hyperlink verweisen. Für den Inhalt der verlinkten Seiten sind ausschließlich ihre Betreiber verantwortlich. Mit dem Besuch einer verlinkten Webseite verlassen Sie das Online-Angebot von www.sysTelios-Transfer.de. Für die Angebote Dritter können daher abweichende Regeln gelten, insbesondere hinsichtlich des Datenschutzes.' ),
		stt_m_absatz( 'Zur besseren Lesbarkeit des Textes verwenden wir gelegentlich die generisch männliche Form „Berater, Coach, Therapeut“ und ähnliche Bezeichnungen. Auch mit dieser Schreibweise möchten wir stets alle Menschen ansprechen.' ),
		stt_m_ueberschrift( 'Fotos', 3 ),
		stt_m_absatz( 'Phil Dera, Thorsten Franz' ),
		stt_m_ueberschrift( 'Markenschutz', 3 ),
		stt_m_absatz( 'Die Wortmarke sysTelios und die Wort-Bild-Marke (Logo) sysTelios Transfer sind zugunsten der sysTelios Gesundheitszentrum Siedelsbrunn GmbH &amp; Co. KG, Wald-Michelbach, markenrechtlich geschützt.' ),
		stt_m_ueberschrift( 'Widerspruch gegen Werbe-Mails', 3 ),
		stt_m_absatz( 'Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit widersprochen. Die Betreiber der Website behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-E-Mails, vor.' ),
		stt_m_ueberschrift( 'Danksagungen' ),
		stt_m_absatz( 'Ein Dank geht an unser Netzwerkmitglied Marcus Rosik, der über Jahre auf seiner Webseite ' . stt_m_link( 'hypno-systemik.de', 'https://hypno-systemik.de/', true ) . ' Inhalte des Transfer-Netzwerks gepflegt hat, bevor es diese eigene Seite von sysTelios TRANSFER gab.' ),
		stt_m_absatz( 'Ebenso geht unser Dank natürlich an ' . stt_m_link( 'Dr. Gunther Schmidt', 'https://gunther-schmidt.net/', true ) . ' und an Mechthild Reinhard, ohne die es die Inhalte gar nicht gäbe, um deren Transfer sich das Netzwerk bemüht.' ),
		stt_m_absatz( '© sysTelios 2026. Alle Rechte vorbehalten.' ),
	)
);
