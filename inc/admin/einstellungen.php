<?php
/**
 * Backend: Design → Transfer-Einstellungen (nur Administrator*innen).
 * Newsletter-Hinweis, Lernreise-Adresse, Kontakt-E-Mail, Wirkungsfamilie (8 Zeilen), JSON-LD-Schalter.
 * Siehe docs/05-familie-newsletter-lernreise-seo.md. Settings API, Sanitisierung Pflicht.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Menüpunkt unter „Design“.
 */
function stt_einstellungen_menue() {
	add_theme_page(
		__( 'Transfer-Einstellungen', 'systelios-transfer' ),
		__( 'Transfer-Einstellungen', 'systelios-transfer' ),
		'manage_options',
		'stt-einstellungen',
		'stt_einstellungen_seite'
	);
}
add_action( 'admin_menu', 'stt_einstellungen_menue' );

/**
 * Hex-Farbe prüfen, sonst Ersatzwert.
 *
 * @param mixed  $wert    Eingabe.
 * @param string $ersatz  Ersatz.
 * @return string
 */
function stt_hex_oder( $wert, $ersatz ) {
	$hex = sanitize_hex_color( is_string( $wert ) ? trim( $wert ) : '' );
	return $hex ? $hex : $ersatz;
}

/**
 * Familie bereinigen: höchstens 8 Zeilen, leere Zeilen entfallen, genau ein Haus darf „wir“ sein.
 *
 * @param mixed $roh Eingabe.
 * @return array
 */
function stt_familie_bereinigen( $roh ) {
	if ( ! is_array( $roh ) ) {
		return array();
	}
	$wir_index = isset( $roh['wir'] ) ? absint( $roh['wir'] ) : -1;
	unset( $roh['wir'] );

	// Die Werte kommen bereits von options.php ohne Schrägstriche (wp_unslash).
	$ergebnis = array();
	foreach ( array_slice( array_values( $roh ), 0, 8 ) as $index => $zeile ) {
		if ( ! is_array( $zeile ) ) {
			continue;
		}
		$rolle = isset( $zeile['rolle'] ) ? sanitize_text_field( $zeile['rolle'] ) : '';
		if ( '' === $rolle ) {
			continue;
		}
		$ergebnis[] = array(
			'kennung'      => isset( $zeile['kennung'] ) ? sanitize_key( $zeile['kennung'] ) : '',
			'rolle'        => $rolle,
			'zuschreibung' => isset( $zeile['zuschreibung'] ) ? sanitize_text_field( $zeile['zuschreibung'] ) : '',
			'hex'          => stt_hex_oder( isset( $zeile['hex'] ) ? $zeile['hex'] : '', '#6F6E6E' ),
			'textfarbe'    => stt_hex_oder( isset( $zeile['textfarbe'] ) ? $zeile['textfarbe'] : '', '#FFFFFF' ),
			'link'         => isset( $zeile['link'] ) ? esc_url_raw( $zeile['link'] ) : '',
			'logo'         => isset( $zeile['logo'] ) ? absint( $zeile['logo'] ) : 0,
			'wir'          => $index === $wir_index,
		);
	}
	return $ergebnis;
}

/**
 * Einstellungen anmelden (jede Option mit sanitize_callback).
 */
function stt_einstellungen_anmelden() {
	register_setting( 'stt_einstellungen', 'stt_newsletter_ueberschrift', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field', 'default' => '' ) );
	register_setting( 'stt_einstellungen', 'stt_newsletter_text', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => '' ) );
	register_setting( 'stt_einstellungen', 'stt_newsletter_url', array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw', 'default' => '' ) );
	register_setting( 'stt_einstellungen', 'stt_lernreise_url', array( 'type' => 'string', 'sanitize_callback' => 'esc_url_raw', 'default' => '' ) );
	register_setting( 'stt_einstellungen', 'stt_kontakt_email', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_email', 'default' => '' ) );
	register_setting( 'stt_einstellungen', 'stt_familie', array( 'type' => 'array', 'sanitize_callback' => 'stt_familie_bereinigen', 'default' => array() ) );
	register_setting(
		'stt_einstellungen',
		'stt_jsonld_familie',
		array(
			'type'              => 'boolean',
			'sanitize_callback' => static function ( $wert ) {
				return (bool) $wert;
			},
			'default'           => false,
		)
	);
}
add_action( 'admin_init', 'stt_einstellungen_anmelden' );

/**
 * Admin-Seite „Transfer-Einstellungen“.
 */
function stt_einstellungen_seite() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Sie dürfen diese Seite nicht aufrufen.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}
	$zeilen = get_option( 'stt_familie' );
	$zeilen = is_array( $zeilen ) && $zeilen ? $zeilen : stt_familie_standard();
	$zeilen = array_pad( array_values( $zeilen ), 8, array() );
	$zeilen = array_slice( $zeilen, 0, 8 );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Transfer-Einstellungen', 'systelios-transfer' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'stt_einstellungen' ); ?>

			<h2><?php esc_html_e( 'Newsletter-Hinweis (Fußzeile)', 'systelios-transfer' ); ?></h2>
			<p><?php esc_html_e( 'Der Newsletter gehört LEBENSART. Hier erscheint nur ein Hinweis mit Link, kein Formular. Ohne Adresse wird nichts angezeigt.', 'systelios-transfer' ); ?></p>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="stt_newsletter_url"><?php esc_html_e( 'Adresse der Anmeldung', 'systelios-transfer' ); ?></label></th>
					<td><input type="url" id="stt_newsletter_url" name="stt_newsletter_url" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'stt_newsletter_url', '' ) ); ?>" placeholder="https://"></td>
				</tr>
				<tr>
					<th scope="row"><label for="stt_newsletter_ueberschrift"><?php esc_html_e( 'Überschrift', 'systelios-transfer' ); ?></label></th>
					<td><input type="text" id="stt_newsletter_ueberschrift" name="stt_newsletter_ueberschrift" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'stt_newsletter_ueberschrift', '' ) ); ?>" placeholder="<?php esc_attr_e( 'Newsletter von sysTelios LEBENSART', 'systelios-transfer' ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="stt_newsletter_text"><?php esc_html_e( 'Kurzer Text (optional)', 'systelios-transfer' ); ?></label></th>
					<td><textarea id="stt_newsletter_text" name="stt_newsletter_text" class="large-text" rows="3"><?php echo esc_textarea( (string) get_option( 'stt_newsletter_text', '' ) ); ?></textarea></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Lernreise', 'systelios-transfer' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="stt_lernreise_url"><?php esc_html_e( 'Adresse der Lernreise bei LEBENSART', 'systelios-transfer' ); ?></label></th>
					<td>
						<input type="url" id="stt_lernreise_url" name="stt_lernreise_url" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'stt_lernreise_url', '' ) ); ?>" placeholder="https://">
						<p class="description"><?php esc_html_e( 'Alle Lernreise-Buttons auf der Website führen hierhin.', 'systelios-transfer' ); ?></p>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Kontakt', 'systelios-transfer' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="stt_kontakt_email"><?php esc_html_e( 'E-Mail für das Kontaktformular', 'systelios-transfer' ); ?></label></th>
					<td>
						<input type="email" id="stt_kontakt_email" name="stt_kontakt_email" class="regular-text" value="<?php echo esc_attr( (string) get_option( 'stt_kontakt_email', '' ) ); ?>" placeholder="transfer@systelios.de">
						<p class="description"><?php esc_html_e( 'Hierhin gehen Nachrichten aus dem Formular (Plugin stt-kontakt).', 'systelios-transfer' ); ?></p>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Wirkungsfamilie', 'systelios-transfer' ); ?></h2>
			<p><?php esc_html_e( 'Namen, Reihenfolge und Farben wie bei LEBENSART. Leere Zeilen werden ignoriert. Ohne Adresse wird der Name ohne Link angezeigt. Genau ein Haus ist „Wir“ (hier: Transfer).', 'systelios-transfer' ); ?></p>
			<table class="widefat striped" style="max-width:1100px">
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Kennung', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Name', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Zusatz (optional)', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Hausfarbe', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Textfarbe', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Adresse (optional)', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Logo-ID', 'systelios-transfer' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Wir', 'systelios-transfer' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $zeilen as $i => $z ) : ?>
					<?php
					$z = wp_parse_args(
						$z,
						array(
							'kennung'      => '',
							'rolle'        => '',
							'zuschreibung' => '',
							'hex'          => '',
							'textfarbe'    => '',
							'link'         => '',
							'logo'         => 0,
							'wir'          => false,
						)
					);
					?>
					<tr>
						<td><input type="text" class="small-text" name="stt_familie[<?php echo (int) $i; ?>][kennung]" value="<?php echo esc_attr( $z['kennung'] ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Kennung, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="text" name="stt_familie[<?php echo (int) $i; ?>][rolle]" value="<?php echo esc_attr( $z['rolle'] ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Name, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="text" name="stt_familie[<?php echo (int) $i; ?>][zuschreibung]" value="<?php echo esc_attr( $z['zuschreibung'] ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Zusatz, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="text" class="small-text" name="stt_familie[<?php echo (int) $i; ?>][hex]" value="<?php echo esc_attr( $z['hex'] ); ?>" placeholder="#6F6E6E" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Hausfarbe, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="text" class="small-text" name="stt_familie[<?php echo (int) $i; ?>][textfarbe]" value="<?php echo esc_attr( $z['textfarbe'] ); ?>" placeholder="#FFFFFF" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Textfarbe, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="url" name="stt_familie[<?php echo (int) $i; ?>][link]" value="<?php echo esc_attr( $z['link'] ); ?>" placeholder="https://" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Adresse, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="number" class="small-text" min="0" name="stt_familie[<?php echo (int) $i; ?>][logo]" value="<?php echo esc_attr( (string) (int) $z['logo'] ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Logo-ID, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
						<td><input type="radio" name="stt_familie[wir]" value="<?php echo (int) $i; ?>" <?php checked( ! empty( $z['wir'] ) ); ?> aria-label="<?php echo esc_attr( sprintf( /* translators: %d: Zeile */ __( 'Dieses Haus ist „Wir“, Zeile %d', 'systelios-transfer' ), $i + 1 ) ); ?>"></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="description"><?php esc_html_e( 'Die Hausfarbe erscheint als Punkt vor dem Namen. Nutzen Sie Farben, die auf Weiß gut sichtbar sind.', 'systelios-transfer' ); ?></p>

			<h2><?php esc_html_e( 'Suchmaschinen', 'systelios-transfer' ); ?></h2>
			<?php $seo_plugin = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Strukturierte Daten', 'systelios-transfer' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="stt_jsonld_familie" value="1" <?php checked( (bool) get_option( 'stt_jsonld_familie', false ) ); ?>>
							<?php esc_html_e( 'Organisation (mit Verweis auf die Familie) als JSON-LD ausgeben', 'systelios-transfer' ); ?>
						</label>
						<p class="description">
							<?php
							echo esc_html(
								$seo_plugin
									? __( 'Ein SEO-Plugin (Yoast oder Rank Math) ist aktiv und bleibt zuständig. Das Theme gibt dann nichts aus, um Doppelungen zu vermeiden.', 'systelios-transfer' )
									: __( 'Standardmäßig aus. Nur einschalten, wenn kein SEO-Plugin strukturierte Daten liefert.', 'systelios-transfer' )
							);
							?>
						</p>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
