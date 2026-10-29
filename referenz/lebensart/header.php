<?php
/** Kopf: Logo, Navigation, mobiles Menü – Adressen über la_seite_url(). */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light dark">
<link rel="icon" href="<?php echo esc_url( LA_THEME_URI . '/assets/img/logo.svg' ); ?>" type="image/svg+xml">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="top-sentinel" aria-hidden="true" style="position:absolute;top:0;left:0;width:1px;height:24px;pointer-events:none"></div>
<a class="skip" href="#main">Zum Inhalt springen</a>
<?php
$start_url   = la_seite_url( 'start' );
$spenden_url = la_seite_url( 'spenden' );
$nav         = la_nav_eintraege();
$email       = la_org( 'org_email' );
$telefon     = la_org( 'org_telefon' );
$tel_href    = la_telefon_href( $telefon );
$logo        = LA_THEME_URI . '/assets/img/logo.svg';
$logo_weiss  = LA_THEME_URI . '/assets/img/logo-weiss.svg';
?>
<header class="site-header">
	<div class="wrap bar">
		<a class="brand" href="<?php echo esc_url( $start_url ? $start_url : home_url( '/' ) ); ?>" aria-label="sysTelios LEBENSART, zur Startseite">
			<img class="logo-light" src="<?php echo esc_url( $logo ); ?>" width="192" height="88" alt="">
			<img class="logo-dark" src="<?php echo esc_url( $logo_weiss ); ?>" width="192" height="88" alt="">
		</a>
		<button class="menu-btn" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-haspopup="dialog">
			<svg class="ballons" viewBox="0 0 48 72" width="22" height="33" aria-hidden="true" focusable="false">
				<circle class="b b-klein" cx="10" cy="10" r="7" />
				<circle class="b b-mittel" cx="14" cy="36" r="9.3" />
				<circle class="b b-gross" cx="33" cy="58" r="12.3" />
			</svg>
			<span class="menu-btn__wort" aria-hidden="true">Menü</span>
			<span class="sr">Menü öffnen</span>
		</button>
		<nav class="site-nav" id="nav" aria-label="Hauptnavigation">
			<ul>
				<?php foreach ( $nav as $item ) : ?>
					<li><a href="<?php echo esc_url( $item['url'] ); ?>"<?php echo $item['aktuell'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php if ( $spenden_url ) : ?>
			<a class="btn btn-donate" href="<?php echo esc_url( $spenden_url ); ?>">Jetzt spenden</a>
		<?php endif; ?>
	</div>
</header>

<div class="mobile-menu" id="mobile-menu" role="dialog" aria-label="Menü" hidden>
	<div class="mm-top">
		<img src="<?php echo esc_url( $logo_weiss ); ?>" width="192" height="88" alt="sysTelios LEBENSART">
		<button class="mm-close" type="button" aria-label="Menü schließen"><i class="ph ph-x" aria-hidden="true"></i></button>
	</div>
	<nav class="mm-nav" aria-label="Hauptnavigation">
		<ul>
			<li style="--k:0"><a href="<?php echo esc_url( $start_url ? $start_url : home_url( '/' ) ); ?>"<?php echo ( 'start' === la_aktuelle_seite_schluessel() ) ? ' aria-current="page"' : ''; ?>>Start</a></li>
			<?php
			$k = 1;
			foreach ( $nav as $item ) :
				?>
				<li style="--k:<?php echo esc_attr( (string) $k ); ?>"><a href="<?php echo esc_url( $item['url'] ); ?>"<?php echo $item['aktuell'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php
				++$k;
			endforeach;
			?>
		</ul>
	</nav>
	<div class="mm-foot" style="--k:<?php echo esc_attr( (string) $k ); ?>">
		<?php if ( $spenden_url ) : ?>
			<a class="btn btn-donate" href="<?php echo esc_url( $spenden_url ); ?>">Jetzt spenden</a>
		<?php endif; ?>
		<p>
			<?php if ( $email ) : ?>
				<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
			<?php endif; ?>
			<?php if ( $email && $telefon ) : ?><br><?php endif; ?>
			<?php if ( $telefon && $tel_href ) : ?>
				<a href="<?php echo esc_url( $tel_href ); ?>"><?php echo esc_html( $telefon ); ?></a>
			<?php endif; ?>
		</p>
	</div>
	<span class="mm-dots" aria-hidden="true"></span>
</div>

<main id="main" tabindex="-1">
