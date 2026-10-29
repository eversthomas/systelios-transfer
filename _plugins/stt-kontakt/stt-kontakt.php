<?php
/**
 * Plugin Name: sysTelios Transfer – Kontaktformular
 * Description: Schlankes Kontaktformular für sysTelios TRANSFER ([stt_kontakt]). Sendet per E-Mail, speichert nichts. Honeypot, Mindest-Ausfüllzeit und Ratenbegrenzung gegen Spam.
 * Version: 0.1.0
 * Requires at least: 6.6
 * Requires PHP: 8.1
 * Text Domain: stt-kontakt
 *
 * Gehört zu Entscheidung D3 (docs/08-entscheidungen.md). Liegt bewusst außerhalb des Themes.
 * Die Empfängeradresse stammt aus der Theme-Einstellung „stt_kontakt_email“ (Design → Transfer-Einstellungen).
 *
 * @package stt-kontakt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STT_KONTAKT_VERSION', '0.1.0' );
define( 'STT_KONTAKT_URL', plugin_dir_url( __FILE__ ) );

/** Mindestzeit zwischen Anzeige und Absenden in Sekunden (Bots füllen sofort aus). */
const STT_KONTAKT_MIN_ZEIT = 4;
/** Höchstens so viele Nachrichten je Stunde und Absender. */
const STT_KONTAKT_MAX_PRO_STUNDE = 5;

/**
 * Zustand des letzten Absendeversuchs (für die Ausgabe im Shortcode).
 *
 * @param array|null $neu Neuer Zustand oder null zum Lesen.
 * @return array
 */
function stt_kontakt_zustand( $neu = null ) {
	static $zustand = array(
		'fehler' => array(),
		'werte'  => array(),
	);
	if ( is_array( $neu ) ) {
		$zustand = $neu;
	}
	return $zustand;
}

/**
 * Felder aus der Anfrage lesen und säubern.
 *
 * @param array $roh $_POST (ungesäubert).
 * @return array
 */
function stt_kontakt_lesen( $roh ) {
	$text = static function ( $schluessel ) use ( $roh ) {
		return isset( $roh[ $schluessel ] ) && is_string( $roh[ $schluessel ] ) ? sanitize_text_field( wp_unslash( $roh[ $schluessel ] ) ) : '';
	};
	return array(
		'vorname'   => $text( 'vorname' ),
		'nachname'  => $text( 'nachname' ),
		'email'     => isset( $roh['email'] ) && is_string( $roh['email'] ) ? sanitize_email( wp_unslash( $roh['email'] ) ) : '',
		'telefon'   => $text( 'telefon' ),
		'nachricht' => isset( $roh['nachricht'] ) && is_string( $roh['nachricht'] ) ? sanitize_textarea_field( wp_unslash( $roh['nachricht'] ) ) : '',
	);
}

/**
 * Pflichtfelder und Formate prüfen.
 *
 * @param array $werte Gesäuberte Werte.
 * @return array Fehlermeldungen je Feld.
 */
function stt_kontakt_pruefen( $werte ) {
	$fehler = array();
	if ( '' === $werte['vorname'] ) {
		$fehler['vorname'] = __( 'Bitte geben Sie Ihren Vornamen an.', 'stt-kontakt' );
	}
	if ( '' === $werte['nachname'] ) {
		$fehler['nachname'] = __( 'Bitte geben Sie Ihren Nachnamen an.', 'stt-kontakt' );
	}
	if ( '' === $werte['email'] || ! is_email( $werte['email'] ) ) {
		$fehler['email'] = __( 'Bitte geben Sie eine gültige E-Mail-Adresse an.', 'stt-kontakt' );
	}
	if ( '' === $werte['nachricht'] ) {
		$fehler['nachricht'] = __( 'Bitte schreiben Sie uns eine Nachricht.', 'stt-kontakt' );
	} elseif ( mb_strlen( $werte['nachricht'] ) > 5000 ) {
		$fehler['nachricht'] = __( 'Ihre Nachricht ist zu lang (höchstens 5000 Zeichen).', 'stt-kontakt' );
	}
	if ( mb_strlen( $werte['telefon'] ) > 40 ) {
		$fehler['telefon'] = __( 'Bitte prüfen Sie die Telefonnummer.', 'stt-kontakt' );
	}
	return $fehler;
}

/**
 * Zeitmarke für das Formular: Zeit plus Signatur, damit sie nicht frei erfunden werden kann.
 *
 * @param int $zeit Unix-Zeit.
 * @return string
 */
function stt_kontakt_zeitmarke( $zeit ) {
	return $zeit . '.' . hash_hmac( 'sha256', (string) $zeit, wp_salt( 'nonce' ) );
}

/**
 * Ist die Zeitmarke echt und nicht zu frisch (Bot) oder zu alt?
 *
 * @param string $marke Zeitmarke aus dem Formular.
 * @return bool
 */
function stt_kontakt_zeit_ok( $marke ) {
	$teile = explode( '.', $marke, 2 );
	if ( 2 !== count( $teile ) || ! ctype_digit( $teile[0] ) ) {
		return false;
	}
	if ( ! hash_equals( hash_hmac( 'sha256', $teile[0], wp_salt( 'nonce' ) ), $teile[1] ) ) {
		return false;
	}
	$alter = time() - (int) $teile[0];
	return $alter >= STT_KONTAKT_MIN_ZEIT && $alter <= DAY_IN_SECONDS;
}

/**
 * Ratenbegrenzung: je Absender (gehashte IP) höchstens N Nachrichten pro Stunde.
 *
 * @param bool $zaehlen true = Versuch mitzählen.
 * @return bool true = erlaubt.
 */
function stt_kontakt_rate_ok( $zaehlen = false ) {
	$ip     = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$schl   = 'stt_kontakt_' . hash_hmac( 'sha256', $ip, wp_salt( 'auth' ) );
	$anzahl = (int) get_transient( $schl );
	if ( $zaehlen ) {
		set_transient( $schl, $anzahl + 1, HOUR_IN_SECONDS );
	}
	return $anzahl < STT_KONTAKT_MAX_PRO_STUNDE;
}

/**
 * Empfängeradresse: Einstellung des Themes, sonst Standard.
 *
 * @return string
 */
function stt_kontakt_empfaenger() {
	$mail = (string) get_option( 'stt_kontakt_email', '' );
	return is_email( $mail ) ? $mail : 'transfer@systelios.de';
}

/**
 * Nachricht verschicken (nichts wird gespeichert).
 *
 * @param array $werte Gesäuberte Werte.
 * @return bool
 */
function stt_kontakt_senden( $werte ) {
	$betreff = sprintf(
		/* translators: %s: Name */
		__( 'Kontaktformular sysTelios TRANSFER: %s', 'stt-kontakt' ),
		trim( $werte['vorname'] . ' ' . $werte['nachname'] )
	);
	$text  = sprintf( "Name: %s %s\nE-Mail: %s\nTelefon: %s\n\n%s\n", $werte['vorname'], $werte['nachname'], $werte['email'], '' !== $werte['telefon'] ? $werte['telefon'] : '–', $werte['nachricht'] );
	$kopf  = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $werte['vorname'] . ' ' . $werte['nachname'] . ' <' . $werte['email'] . '>',
	);
	return wp_mail( stt_kontakt_empfaenger(), $betreff, $text, $kopf );
}

/**
 * Absenden verarbeiten, bevor die Seite ausgegeben wird (Post/Redirect/Get bei Erfolg).
 */
function stt_kontakt_verarbeiten() {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || empty( $_POST['stt_kontakt_senden'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$nonce = isset( $_POST['stt_kontakt_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['stt_kontakt_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'stt_kontakt' ) ) {
		stt_kontakt_zustand( array( 'fehler' => array( '_allgemein' => __( 'Die Sitzung ist abgelaufen. Bitte versuchen Sie es noch einmal.', 'stt-kontakt' ) ), 'werte' => stt_kontakt_lesen( $_POST ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}

	// Honeypot: Menschen sehen das Feld nicht. Bei Treffer so tun, als wäre alles gut.
	$honig = isset( $_POST['webseite'] ) ? (string) wp_unslash( $_POST['webseite'] ) : '';
	$marke = isset( $_POST['stt_zeit'] ) ? sanitize_text_field( wp_unslash( $_POST['stt_zeit'] ) ) : '';
	if ( '' !== $honig || ! stt_kontakt_zeit_ok( $marke ) ) {
		stt_kontakt_umleiten();
	}

	$werte  = stt_kontakt_lesen( $_POST ); // phpcs:ignore WordPress.Security.NonceVerification
	$fehler = stt_kontakt_pruefen( $werte );
	if ( ! $fehler && ! stt_kontakt_rate_ok( true ) ) {
		$fehler['_allgemein'] = __( 'Sie haben in kurzer Zeit sehr viele Nachrichten gesendet. Bitte versuchen Sie es später noch einmal.', 'stt-kontakt' );
	}
	if ( ! $fehler && ! stt_kontakt_senden( $werte ) ) {
		$fehler['_allgemein'] = __( 'Die Nachricht konnte leider nicht gesendet werden. Bitte versuchen Sie es später noch einmal oder schreiben Sie uns direkt per E-Mail.', 'stt-kontakt' );
	}
	if ( $fehler ) {
		stt_kontakt_zustand( array( 'fehler' => $fehler, 'werte' => $werte ) );
		return;
	}
	stt_kontakt_umleiten();
}
add_action( 'template_redirect', 'stt_kontakt_verarbeiten' );

/**
 * Nach dem Absenden zurück auf die Seite mit Erfolgsmeldung.
 */
function stt_kontakt_umleiten() {
	wp_safe_redirect( add_query_arg( 'stt_kontakt', 'gesendet', remove_query_arg( 'stt_kontakt' ) ) . '#stt-kontakt' );
	exit;
}

/**
 * Shortcode [stt_kontakt].
 *
 * @return string
 */
function stt_kontakt_shortcode() {
	$zustand = stt_kontakt_zustand();
	$fehler  = $zustand['fehler'];
	$werte   = wp_parse_args( $zustand['werte'], array( 'vorname' => '', 'nachname' => '', 'email' => '', 'telefon' => '', 'nachricht' => '' ) );

	wp_enqueue_style( 'stt-kontakt', STT_KONTAKT_URL . 'assets/kontakt.css', array(), STT_KONTAKT_VERSION );

	if ( isset( $_GET['stt_kontakt'] ) && 'gesendet' === $_GET['stt_kontakt'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		return '<div class="stt-kontakt stt-kontakt--erfolg" id="stt-kontakt"><p role="status" tabindex="-1">' . esc_html__( 'Vielen Dank! Ihre Nachricht ist bei uns angekommen. Wir melden uns bei Ihnen.', 'stt-kontakt' ) . '</p></div>';
	}

	if ( $fehler ) {
		wp_enqueue_script( 'stt-kontakt', STT_KONTAKT_URL . 'assets/kontakt.js', array(), STT_KONTAKT_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	}

	$felder = array(
		'vorname'  => array( __( 'Vorname', 'stt-kontakt' ), 'text', true, 'given-name' ),
		'nachname' => array( __( 'Nachname', 'stt-kontakt' ), 'text', true, 'family-name' ),
		'email'    => array( __( 'E-Mail', 'stt-kontakt' ), 'email', true, 'email' ),
		'telefon'  => array( __( 'Telefonnummer (optional)', 'stt-kontakt' ), 'tel', false, 'tel' ),
	);

	$datenschutz = get_posts( array( 'post_type' => 'page', 'name' => 'datenschutzerklaerung', 'posts_per_page' => 1, 'fields' => 'ids' ) );

	ob_start();
	?>
	<form class="stt-kontakt" id="stt-kontakt" method="post" action="<?php echo esc_url( remove_query_arg( 'stt_kontakt' ) . '#stt-kontakt' ); ?>" novalidate>
		<?php if ( $fehler ) : ?>
			<div class="stt-kontakt__fehler" id="stt-kontakt-fehler" role="alert" tabindex="-1">
				<p><strong><?php esc_html_e( 'Bitte prüfen Sie Ihre Angaben:', 'stt-kontakt' ); ?></strong></p>
				<ul>
					<?php foreach ( $fehler as $schluessel => $meldung ) : ?>
						<li><?php echo '_allgemein' === $schluessel ? esc_html( $meldung ) : '<a href="#stt-' . esc_attr( $schluessel ) . '">' . esc_html( $meldung ) . '</a>'; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php foreach ( $felder as $name => $feld ) : ?>
			<div class="stt-kontakt__feld">
				<label for="stt-<?php echo esc_attr( $name ); ?>">
					<?php echo esc_html( $feld[0] ); ?>
					<?php if ( $feld[2] ) : ?><span class="stt-kontakt__pflicht"> <?php esc_html_e( '(Pflichtfeld)', 'stt-kontakt' ); ?></span><?php endif; ?>
				</label>
				<input type="<?php echo esc_attr( $feld[1] ); ?>" id="stt-<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $werte[ $name ] ); ?>" autocomplete="<?php echo esc_attr( $feld[3] ); ?>"<?php echo $feld[2] ? ' required' : ''; ?><?php echo isset( $fehler[ $name ] ) ? ' aria-invalid="true" aria-describedby="stt-' . esc_attr( $name ) . '-fehler"' : ''; ?>>
				<?php if ( isset( $fehler[ $name ] ) ) : ?>
					<p class="stt-kontakt__feldfehler" id="stt-<?php echo esc_attr( $name ); ?>-fehler"><?php echo esc_html( $fehler[ $name ] ); ?></p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<div class="stt-kontakt__feld">
			<label for="stt-nachricht"><?php esc_html_e( 'Ihre Nachricht', 'stt-kontakt' ); ?><span class="stt-kontakt__pflicht"> <?php esc_html_e( '(Pflichtfeld)', 'stt-kontakt' ); ?></span></label>
			<textarea id="stt-nachricht" name="nachricht" rows="7" required<?php echo isset( $fehler['nachricht'] ) ? ' aria-invalid="true" aria-describedby="stt-nachricht-fehler"' : ''; ?>><?php echo esc_textarea( $werte['nachricht'] ); ?></textarea>
			<?php if ( isset( $fehler['nachricht'] ) ) : ?>
				<p class="stt-kontakt__feldfehler" id="stt-nachricht-fehler"><?php echo esc_html( $fehler['nachricht'] ); ?></p>
			<?php endif; ?>
		</div>

		<div class="stt-kontakt__honig" aria-hidden="true">
			<label for="stt-webseite"><?php esc_html_e( 'Bitte leer lassen', 'stt-kontakt' ); ?></label>
			<input type="text" id="stt-webseite" name="webseite" value="" tabindex="-1" autocomplete="off">
		</div>
		<input type="hidden" name="stt_zeit" value="<?php echo esc_attr( stt_kontakt_zeitmarke( time() ) ); ?>">
		<input type="hidden" name="stt_kontakt_nonce" value="<?php echo esc_attr( wp_create_nonce( 'stt_kontakt' ) ); ?>">

		<p class="stt-kontakt__datenschutz">
			<?php esc_html_e( 'Mit dem Absenden der Nachricht willige ich ein, dass sysTelios TRANSFER meine Daten zur Bearbeitung meiner Anfrage speichern und verarbeiten darf. Dies ist keine Einwilligung zu einer weitergehenden Nutzung, etwa für Marketing- oder Werbezwecke.', 'stt-kontakt' ); ?>
			<?php if ( $datenschutz ) : ?>
				<a href="<?php echo esc_url( (string) get_permalink( $datenschutz[0] ) ); ?>"><?php esc_html_e( 'Datenschutzerklärung', 'stt-kontakt' ); ?></a>
			<?php endif; ?>
		</p>

		<button type="submit" name="stt_kontakt_senden" value="1" class="stt-kontakt__knopf wp-element-button"><?php esc_html_e( 'Nachricht senden', 'stt-kontakt' ); ?></button>
	</form>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'stt_kontakt', 'stt_kontakt_shortcode' );
