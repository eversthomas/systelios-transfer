<?php
/**
 * Title: Startseite (gesamt)
 * Slug: stt/startseite
 * Categories: stt-transfer
 * Inserter: no
 * Description: Gesamtmuster der Startseite. Nur Inhalte sind veränderbar, die Abschnitte sind gesperrt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Links über den Slug der Seite, egal wo sie im Seitenbaum steht.
$u = static function ( $pfad ) {
	return esc_url( stt_seiten_url( trim( $pfad, '/' ) ) );
};
$lebensart = stt_familie_haus( 'lebensart' );
$hinweis   = stt_m_familienhinweis(
	'lebensart',
	'Hypnosystemik fördern',
	'[Kurzer Text, wie Besucher*innen die Arbeit von LEBENSART unterstützen können.]',
	array(
		'text' => 'Zu sysTelios LEBENSART',
		'url'  => $lebensart && ! empty( $lebensart['link'] ) ? $lebensart['link'] : home_url( '/' ),
	)
);

$kontakt_ref = stt_sync_muster_id( 'kontaktflaeche' );
$heil_ref    = stt_sync_muster_id( 'heilkunde' );

$bild_einstieg = stt_bild_block( stt_anhang_nach_name( 'systeliosBackground' ), false, 'large' );
$bild_band     = stt_bild_block( stt_anhang_nach_name( 'kulptur' ), false, 'large' );

// ENTSCHEIDUNG D5: Statt einer Filtersuche nur ein Knopf zum Verzeichnis (das Plugin kennt keine URL-Parameter für Filter).
// ENTSCHEIDUNG D11: Text der Lernreise-Karte ist ein Platzhalter.
?>
<!-- wp:group {"align":"full","templateLock":"contentOnly","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:group {"align":"full","className":"stt-sektion","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull stt-sektion"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:paragraph {"className":"is-style-augenbraue"} -->
<p class="is-style-augenbraue">Netzwerk für Hypnosystemik</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Hypnosystemik in Therapie, Coaching, Beratung und Arbeitswelt</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Hypnosystemische Haltung gemeinsam leben und weitertragen. Wir sind ein Netzwerk von über 200 Menschen, die Würdigung, Stimmigkeit und Augenhöhe in Alltag, Therapie, Coaching und Organisationen tragen. Wir haben uns dem Transfer der Hypnosystemik verschrieben.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo $u( '/therapeuten-und-coaches/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Begleiter*in finden →</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-umriss"} -->
<div class="wp-block-button is-style-umriss"><a class="wp-block-button__link wp-element-button" href="<?php echo $u( '/unsere-angebote/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Angebote ansehen</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><?php echo $bild_einstieg; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"stt-sektion","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull stt-sektion"><!-- wp:group {"align":"wide","className":"is-style-warm stt-klein","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide is-style-warm stt-klein"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Begleitung in Ihrer Nähe oder online finden</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Im Verzeichnis finden Sie Therapeut*innen, Coaches und Berater*innen aus dem Netzwerk – nach Ort, Angebot oder online.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-dunkel"} -->
<div class="wp-block-button is-style-dunkel"><a class="wp-block-button__link wp-element-button" href="<?php echo $u( '/therapeuten-und-coaches/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Zum Verzeichnis</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"stt-sektion","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull stt-sektion"><!-- wp:columns {"align":"wide","className":"stt-raster"} -->
<div class="wp-block-columns alignwide stt-raster"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte hat-punkt hat-punkt--gross","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte hat-punkt hat-punkt--gross"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Begleiter*innen</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lernen Sie die Menschen im Netzwerk kennen: Therapeut*innen, Coaches und Berater*innen mit hypnosystemischer Haltung.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/therapeuten-und-coaches/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Zum Verzeichnis →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte hat-punkt hat-punkt--gross","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte hat-punkt hat-punkt--gross"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Angebote</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Hypnosystemische Begleitung und offene Treffen, auch online – für ehemalige Klient*innen, Angehörige und Interessierte.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/unsere-angebote/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Angebote ansehen →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte hat-punkt hat-punkt--gross","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte hat-punkt hat-punkt--gross"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Was ist Hypnosystemik?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Erfahren Sie mehr über die Haltung, die unser Arbeiten prägt: Probleme würdigen, Ressourcen entdecken, Stimmigkeit leben.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/was-ist-hypnosystemik/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Mehr erfahren →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-warm","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-warm"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><?php if ( '' !== $bild_band ) : ?><!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%"><?php echo $bild_band; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
<!-- /wp:column -->

<?php endif; ?><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Was Transfer für uns bedeutet</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Die Konzepte der Hypnosystemik wurden erstmals sowohl therapeutisch als auch für das Zusammenarbeiten in Organisationen vollumfänglich im Kontext einer psychosomatischen Klinik im Odenwald, der sysTelios KLINIK, erlebbar.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Transfer bedeutet für uns, dass wir uns der Idee verpflichtet fühlen, die Konzepte aus ihrem ursprünglichen Kontext heraus für die unterschiedlichsten Kontexte in der Gesellschaft wirksam werden zu lassen: Für Therapie, Coaching, Beratung von Menschen und Unternehmen und letztlich auch gesamtgesellschaftlich für Würde und Menschlichkeit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>So vervielfältigt sich der Geist der Konzepte von Gunther Schmidt und Mechthild Reinhard – lebendig, offen, selbstorganisiert und vielfältig. Hypnosystemik in Therapie, Coaching, Beratung und in der Arbeitswelt.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"stt-sektion","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull stt-sektion"><!-- wp:heading {"level":2,"anchor":"angebote"} -->
<h2 class="wp-block-heading" id="angebote">Angebote – online und vor Ort</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide","className":"stt-raster"} -->
<div class="wp-block-columns alignwide stt-raster"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte"><!-- wp:paragraph {"className":"is-style-tag"} -->
<p class="is-style-tag">Online · monatlich</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Transferabend online</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ein Abend im Monat mit wechselndem Thema, gestaltet von Mitgliedern des Netzwerks. Niedrigschwellig, von zu Hause aus.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Nächster Termin:</strong> [Datum, Uhrzeit]<br><strong>Thema:</strong> [Thema des Abends]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/transferabend-online/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Zum Transferabend →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte"><!-- wp:paragraph {"className":"is-style-tag"} -->
<p class="is-style-tag">Regional</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Gruppen vor Ort</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Regionale Gruppen, in denen ehemalige Klient*innen der sysTelios KLINIK ihre Erfahrungen im Alltag weiterführen – begleitet von erfahrenen Netzwerkmitgliedern.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Gruppen:</strong> [Anzahl] Orte<br><strong>Inhalte:</strong> Austausch, Achtsamkeit, Anliegenarbeit</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/gruppen-vor-ort/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Gruppe in der Nähe finden →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte"><!-- wp:paragraph {"className":"is-style-tag"} -->
<p class="is-style-tag">Regional und online</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Für Angehörige</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Raum für Fragen, veränderte Rollen in der Familie und Austausch mit Menschen in ähnlicher Situation – wertschätzend und auf Augenhöhe.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Ansprechperson:</strong> [Name]<br><strong>Format:</strong> Gruppe, regional oder online</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/angehoerige/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Angebote für Angehörige →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-karte","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-karte"><!-- wp:paragraph {"className":"is-style-tag"} -->
<p class="is-style-tag">Angebot von LEBENSART</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Lernreise</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Kurzbeschreibung der Lernreise aus Sicht von Transfer.]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $u( '/lernreise/' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>">Zur Lernreise →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<?php if ( $heil_ref > 0 ) : ?>

<!-- wp:block {"ref":<?php echo (int) $heil_ref; ?>} /-->
<?php endif; ?></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"stt-sektion","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull stt-sektion"><!-- wp:quote {"align":"wide","className":"is-style-punkte"} -->
<blockquote class="wp-block-quote alignwide is-style-punkte"><!-- wp:paragraph -->
<p>Manchmal fühlen sich Erfahrungen an wie lose Teile, die nicht zusammenpassen wollen. In hypnosystemischer Haltung sind das keine Fehler, sondern wertvolle Puzzlestücke. Im gemeinsamen Schauen entsteht ein neues Bild – eins, das stimmiger und lebendiger wirkt.</p>
<!-- /wp:paragraph --></blockquote>
<!-- /wp:quote -->

<?php echo $hinweis; // phpcs:ignore WordPress.Security.EscapeOutput ?>
<?php if ( $kontakt_ref > 0 ) : ?>

<!-- wp:block {"ref":<?php echo (int) $kontakt_ref; ?>} /-->
<?php endif; ?></div>
<!-- /wp:group -->

<?php echo stt_m_familie_abschnitt(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
<!-- /wp:group -->
