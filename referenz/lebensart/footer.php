<?php
/** Fuß: Newsletter (in Vorbereitung), Adresse/Konto aus la_org(), Spendenband. */

if ( la_spendenband_zeigen() ) {
	get_template_part( 'teile/spendenband' );
}

$nav         = la_nav_eintraege();
$email       = la_org( 'org_email' );
$telefon     = la_org( 'org_telefon' );
$tel_href    = la_telefon_href( $telefon );
$strasse     = la_org( 'org_strasse' );
$plz         = la_org( 'org_plz' );
$ort         = la_org( 'org_ort' );
$konto       = la_org( 'org_kontoinhaber' );
$iban        = la_org( 'org_iban' );
$bic         = la_org( 'org_bic' );
$bank        = la_org( 'org_bank' );
$linkedin    = la_org( 'org_linkedin' );
$nl_title    = la_org( 'org_newsletter_ueberschrift' );
$nl_text     = la_org( 'org_newsletter_text' );
$logo_weiss  = LA_THEME_URI . '/assets/img/logo-weiss.svg';
$impressum   = la_seite_url( 'impressum' );
$datenschutz = la_seite_url( 'datenschutz' );
$agb         = la_seite_url( 'agb' );
$ueber       = la_seite_url( 'ueber-uns' );
?>
</main>

<footer class="site-footer">
	<section class="news" aria-labelledby="h-news">
		<div class="wrap">
			<div>
				<h2 id="h-news"><?php echo esc_html( $nl_title ? $nl_title : 'Bleib auf dem Laufenden' ); ?></h2>
				<?php if ( $nl_text ) : ?>
					<p><?php echo esc_html( $nl_text ); ?></p>
				<?php endif; ?>
			</div>
			<form class="form" novalidate>
				<div class="field">
					<label for="n-mail">E-Mail-Adresse</label>
					<div class="row">
						<div style="display:grid;gap:0.4rem">
							<input class="input" id="n-mail" name="mail" type="email" autocomplete="email" disabled aria-describedby="n-mail-h">
						</div>
						<button class="btn" type="button" disabled>Newsletter abonnieren</button>
					</div>
					<p class="help" id="n-mail-h">Newsletter-Anmeldung in Vorbereitung.</p>
				</div>
			</form>
		</div>
	</section>
	<div class="wrap foot">
		<div>
			<img class="logo-foot" src="<?php echo esc_url( $logo_weiss ); ?>" width="192" height="88" alt="sysTelios LEBENSART">
			<address>
				<?php if ( $strasse ) : ?>
					<?php echo esc_html( $strasse ); ?><br>
				<?php endif; ?>
				<?php if ( $plz || $ort ) : ?>
					<?php echo esc_html( trim( $plz . ' ' . $ort ) ); ?><br>
				<?php endif; ?>
				<?php if ( $email ) : ?>
					<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a><br>
				<?php endif; ?>
				<?php if ( $telefon && $tel_href ) : ?>
					<a href="<?php echo esc_url( $tel_href ); ?>"><?php echo esc_html( $telefon ); ?></a>
				<?php endif; ?>
			</address>
		</div>
		<div>
			<h3>Seiten</h3>
			<ul>
				<?php foreach ( $nav as $item ) : ?>
					<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php if ( $konto || $iban || $bic || $bank ) : ?>
			<div>
				<h3>Spendenkonto</h3>
				<dl>
					<?php if ( $konto ) : ?>
						<dt>Kontoinhaber</dt><dd><?php echo esc_html( $konto ); ?></dd>
					<?php endif; ?>
					<?php if ( $iban ) : ?>
						<dt>IBAN</dt><dd><?php echo esc_html( $iban ); ?></dd>
					<?php endif; ?>
					<?php if ( $bic ) : ?>
						<dt>BIC</dt><dd><?php echo esc_html( $bic ); ?></dd>
					<?php endif; ?>
					<?php if ( $bank ) : ?>
						<dt>Bank</dt><dd><?php echo esc_html( $bank ); ?></dd>
					<?php endif; ?>
				</dl>
			</div>
		<?php endif; ?>
		<div>
			<h3>Rechtliches</h3>
			<ul>
				<?php if ( $impressum ) : ?>
					<li><a href="<?php echo esc_url( $impressum ); ?>">Impressum</a></li>
				<?php endif; ?>
				<?php if ( $datenschutz ) : ?>
					<li><a href="<?php echo esc_url( $datenschutz ); ?>">Datenschutz</a></li>
				<?php endif; ?>
				<?php if ( $agb ) : ?>
					<li><a href="<?php echo esc_url( $agb ); ?>">AGB</a></li>
				<?php endif; ?>
				<?php if ( $linkedin ) : ?>
					<li><a href="<?php echo esc_url( $linkedin ); ?>" rel="noopener">LinkedIn</a></li>
				<?php endif; ?>
			</ul>
			<p class="small" style="margin-top:1rem;opacity:0.9">Gemeinnützig anerkannt, Finanzamt Bensheim</p>
			<?php if ( $ueber ) : ?>
				<p class="small" style="margin-top:0.5rem"><a href="<?php echo esc_url( $ueber ); ?>#wirkungsfamilie">Teil der sysTelios Wirkungsfamilie</a></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="wrap legal">
		<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( $konto ? $konto : 'sysTelios LEBENSART' ); ?></span>
		<span></span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
