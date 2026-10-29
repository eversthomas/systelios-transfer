<?php
/**
 * Backend: Design → Transfer-Inhalte. Seiten aus dem mitgelieferten Fallback in den Editor übernehmen
 * oder auf den Fallback zurückstellen. Siehe docs/04-inhalte-und-fallback.md, Abschnitt 5.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Menüpunkt unter „Design“.
 */
function stt_inhalte_menue() {
	add_theme_page(
		__( 'Transfer-Inhalte', 'systelios-transfer' ),
		__( 'Transfer-Inhalte', 'systelios-transfer' ),
		'edit_pages',
		'stt-inhalte',
		'stt_inhalte_seite'
	);
}
add_action( 'admin_menu', 'stt_inhalte_menue' );

/**
 * Adresse der Admin-Seite.
 *
 * @param array $args Zusätzliche Abfrage-Argumente.
 * @return string
 */
function stt_inhalte_url( $args = array() ) {
	return add_query_arg( array_merge( array( 'page' => 'stt-inhalte' ), $args ), admin_url( 'themes.php' ) );
}

/**
 * Adresse einer Aktion (admin-post.php) mit Nonce, z. B. für Knöpfe im Editor.
 *
 * @param string $aktion   stt_uebernehmen | stt_zurueckstellen.
 * @param int    $seite_id Seiten-ID.
 * @return string
 */
function stt_aktion_url( $aktion, $seite_id ) {
	return wp_nonce_url(
		add_query_arg(
			array(
				'action' => $aktion,
				'seite'  => (int) $seite_id,
			),
			admin_url( 'admin-post.php' )
		),
		$aktion . '_' . (int) $seite_id
	);
}

/**
 * Zurück zur Admin-Seite mit Meldung.
 *
 * @param string $meldung Kennung der Meldung.
 * @param int    $anzahl  Anzahl betroffener Seiten.
 */
function stt_inhalte_zurueck( $meldung, $anzahl = 0 ) {
	wp_safe_redirect( stt_inhalte_url( array( 'stt_meldung' => $meldung, 'stt_anzahl' => (int) $anzahl ) ) );
	exit;
}

/**
 * Aktion: eine Seite übernehmen. Nonce und Berechtigung werden geprüft.
 * `from=editor` führt danach direkt in den Block-Editor der Seite.
 */
function stt_aktion_uebernehmen() {
	$id = isset( $_REQUEST['seite'] ) ? absint( wp_unslash( $_REQUEST['seite'] ) ) : 0;
	check_admin_referer( 'stt_uebernehmen_' . $id );
	if ( ! $id || ! current_user_can( 'edit_page', $id ) ) {
		wp_die( esc_html__( 'Sie dürfen diese Seite nicht bearbeiten.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}
	if ( ! stt_seite_uebernehmen( $id ) ) {
		stt_inhalte_zurueck( 'fehler' );
	}
	if ( isset( $_REQUEST['von'] ) && 'editor' === $_REQUEST['von'] ) {
		wp_safe_redirect( get_edit_post_link( $id, 'raw' ) );
		exit;
	}
	stt_inhalte_zurueck( 'uebernommen', 1 );
}
add_action( 'admin_post_stt_uebernehmen', 'stt_aktion_uebernehmen' );

/**
 * Aktion: eine Seite auf Fallback zurückstellen.
 */
function stt_aktion_zurueckstellen() {
	$id = isset( $_REQUEST['seite'] ) ? absint( wp_unslash( $_REQUEST['seite'] ) ) : 0;
	check_admin_referer( 'stt_zurueckstellen_' . $id );
	if ( ! $id || ! current_user_can( 'edit_page', $id ) ) {
		wp_die( esc_html__( 'Sie dürfen diese Seite nicht bearbeiten.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}
	stt_inhalte_zurueck( stt_seite_zurueckstellen( $id ) ? 'zurueckgestellt' : 'fehler', 1 );
}
add_action( 'admin_post_stt_zurueckstellen', 'stt_aktion_zurueckstellen' );

/**
 * Aktion: alle Seiten im Zustand „Fallback automatisch“ übernehmen (nach Bestätigungsseite).
 */
function stt_aktion_alle_uebernehmen() {
	check_admin_referer( 'stt_alle_uebernehmen' );
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( esc_html__( 'Sie dürfen Seiten nicht bearbeiten.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}
	$anzahl = 0;
	foreach ( stt_seiten_liste() as $seite ) {
		if ( 'fallback_auto' === stt_inhalt_zustand( $seite ) && current_user_can( 'edit_page', $seite->ID ) && stt_seite_uebernehmen( $seite->ID ) ) {
			++$anzahl;
		}
	}
	stt_inhalte_zurueck( 'alle_uebernommen', $anzahl );
}
add_action( 'admin_post_stt_alle_uebernehmen', 'stt_aktion_alle_uebernehmen' );

/**
 * Aktion: fehlende synchronisierte Muster anlegen.
 */
function stt_aktion_muster_anlegen() {
	check_admin_referer( 'stt_muster_anlegen' );
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( esc_html__( 'Sie dürfen das nicht.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}
	stt_inhalte_zurueck( 'muster_angelegt', stt_sync_muster_anlegen() );
}
add_action( 'admin_post_stt_muster_anlegen', 'stt_aktion_muster_anlegen' );

/**
 * Alle Seiten, sortiert wie im Menü.
 *
 * @return WP_Post[]
 */
function stt_seiten_liste() {
	return get_pages(
		array(
			'post_status' => array( 'publish', 'draft', 'pending', 'private' ),
			'sort_column' => 'menu_order,post_title',
		)
	);
}

/**
 * Meldungen nach Aktionen.
 */
function stt_inhalte_meldung() {
	if ( ! isset( $_GET['stt_meldung'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- nur Anzeige.
		return;
	}
	$meldung = sanitize_key( wp_unslash( $_GET['stt_meldung'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
	$anzahl  = isset( $_GET['stt_anzahl'] ) ? absint( wp_unslash( $_GET['stt_anzahl'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
	$texte   = array(
		'uebernommen'     => array( 'success', __( 'Die Seite wurde in den Editor übernommen. Sie können sie jetzt wie jede andere Seite bearbeiten; der frühere Stand bleibt als Revision erhalten.', 'systelios-transfer' ) ),
		/* translators: %d: Anzahl Seiten */
		'alle_uebernommen' => array( 'success', sprintf( _n( '%d Seite wurde übernommen.', '%d Seiten wurden übernommen.', $anzahl, 'systelios-transfer' ), $anzahl ) ),
		'zurueckgestellt' => array( 'success', __( 'Die Seite zeigt wieder den mitgelieferten Inhalt. Ihr bisheriger Inhalt bleibt gespeichert.', 'systelios-transfer' ) ),
		/* translators: %d: Anzahl Muster */
		'muster_angelegt' => array( 'success', sprintf( _n( '%d fehlendes Muster wurde angelegt.', '%d fehlende Muster wurden angelegt.', $anzahl, 'systelios-transfer' ), $anzahl ) ),
		'fehler'          => array( 'error', __( 'Das hat nicht geklappt. Für diese Seite gibt es keinen mitgelieferten Inhalt.', 'systelios-transfer' ) ),
	);
	if ( ! isset( $texte[ $meldung ] ) ) {
		return;
	}
	printf(
		'<div class="notice notice-%1$s is-dismissible"><p>%2$s</p></div>',
		esc_attr( $texte[ $meldung ][0] ),
		esc_html( $texte[ $meldung ][1] )
	);
}

/**
 * Admin-Seite „Transfer-Inhalte“.
 */
function stt_inhalte_seite() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( esc_html__( 'Sie dürfen diese Seite nicht aufrufen.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}

	// Bestätigungsschritt für „Alle übernehmen“ (kein JavaScript-confirm()).
	if ( isset( $_GET['aktion'] ) && 'alle-bestaetigen' === $_GET['aktion'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		stt_inhalte_bestaetigen();
		return;
	}

	$seiten  = stt_seiten_liste();
	$auto    = 0;
	$zustand = array();
	foreach ( $seiten as $seite ) {
		$zustand[ $seite->ID ] = stt_inhalt_zustand( $seite );
		if ( 'fallback_auto' === $zustand[ $seite->ID ] ) {
			++$auto;
		}
	}
	$namen = array(
		'fallback_auto' => __( 'Fallback automatisch', 'systelios-transfer' ),
		'fallback'      => __( 'Fallback erzwungen', 'systelios-transfer' ),
		'eigen'         => __( 'Eigener Inhalt', 'systelios-transfer' ),
		'ohne'          => __( 'Ohne Fallback', 'systelios-transfer' ),
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Transfer-Inhalte', 'systelios-transfer' ); ?></h1>
		<?php stt_inhalte_meldung(); ?>

		<p><?php esc_html_e( 'Seiten mit „Fallback“ zeigen auf der Website den mitgelieferten Inhalt des Themes. Mit „In den Editor übernehmen“ wird dieser Inhalt zum normalen Seiteninhalt, den Sie im Block-Editor bearbeiten. Der frühere Stand bleibt als Revision erhalten. Alte Elementor-Daten bleiben unangetastet.', 'systelios-transfer' ); ?></p>

		<?php if ( defined( 'ELEMENTOR_VERSION' ) ) : ?>
			<div class="notice notice-warning inline"><p><?php esc_html_e( 'Elementor ist noch aktiv. Das Theme geht davon aus, dass Elementor deaktiviert ist. Bitte deaktivieren (nicht löschen), bevor Sie Seiten übernehmen.', 'systelios-transfer' ); ?></p></div>
		<?php endif; ?>

		<table class="widefat striped">
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Seite', 'systelios-transfer' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Zustand', 'systelios-transfer' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Aktionen', 'systelios-transfer' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ( $seiten as $seite ) : ?>
				<?php
				$z     = $zustand[ $seite->ID ];
				$tiefe = count( get_post_ancestors( $seite ) );
				?>
				<tr>
					<td>
						<?php echo esc_html( str_repeat( '— ', $tiefe ) ); ?>
						<a href="<?php echo esc_url( (string) get_edit_post_link( $seite->ID ) ); ?>"><?php echo esc_html( get_the_title( $seite ) ); ?></a>
						<?php if ( 'publish' !== $seite->post_status ) : ?>
							<span class="description">(<?php echo esc_html( get_post_status_object( $seite->post_status )->label ); ?>)</span>
						<?php endif; ?>
					</td>
					<td>
						<?php echo esc_html( $namen[ $z ] ); ?>
						<?php if ( 'eigen' === $z && get_post_meta( $seite->ID, '_stt_uebernommen', true ) ) : ?>
							<br><span class="description">
							<?php
							/* translators: %s: Datum und Uhrzeit */
							echo esc_html( sprintf( __( 'übernommen am %s', 'systelios-transfer' ), mysql2date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), get_post_meta( $seite->ID, '_stt_uebernommen', true ) ) ) );
							?>
							</span>
						<?php endif; ?>
						<?php if ( 'ohne' === $z && stt_ist_elementor_seite( $seite->ID ) ) : ?>
							<br><strong><?php esc_html_e( 'Achtung: frühere Elementor-Seite ohne mitgelieferten Inhalt – wird im neuen Theme voraussichtlich leer angezeigt.', 'systelios-transfer' ); ?></strong>
						<?php endif; ?>
					</td>
					<td>
						<?php if ( in_array( $z, array( 'fallback_auto', 'fallback' ), true ) && current_user_can( 'edit_page', $seite->ID ) ) : ?>
							<a class="button button-primary" href="<?php echo esc_url( stt_aktion_url( 'stt_uebernehmen', $seite->ID ) ); ?>"><?php esc_html_e( 'In den Editor übernehmen', 'systelios-transfer' ); ?></a>
							<a class="button" href="<?php echo esc_url( (string) get_permalink( $seite ) ); ?>"><?php esc_html_e( 'Ansehen', 'systelios-transfer' ); ?></a>
						<?php elseif ( 'eigen' === $z && null !== stt_fallback_eintrag( $seite ) && current_user_can( 'edit_page', $seite->ID ) ) : ?>
							<a class="button" href="<?php echo esc_url( stt_aktion_url( 'stt_zurueckstellen', $seite->ID ) ); ?>"><?php esc_html_e( 'Auf Fallback zurückstellen', 'systelios-transfer' ); ?></a>
						<?php else : ?>
							&ndash;
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<?php if ( $auto > 0 ) : ?>
			<p>
				<a class="button" href="<?php echo esc_url( stt_inhalte_url( array( 'aktion' => 'alle-bestaetigen' ) ) ); ?>">
					<?php
					/* translators: %d: Anzahl Seiten */
					echo esc_html( sprintf( _n( 'Alle übernehmen (%d Seite)', 'Alle übernehmen (%d Seiten)', $auto, 'systelios-transfer' ), $auto ) );
					?>
				</a>
			</p>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Synchronisierte Muster', 'systelios-transfer' ); ?></h2>
		<p><?php esc_html_e( 'Diese Muster wirken, einmal geändert, überall, wo sie eingesetzt sind.', 'systelios-transfer' ); ?></p>
		<ul>
			<?php foreach ( stt_sync_muster_definitionen() as $kennung => $muster ) : ?>
				<?php $muster_id = stt_sync_muster_id( $kennung ); ?>
				<li>
					<?php echo esc_html( $muster['titel'] ); ?> –
					<?php if ( $muster_id ) : ?>
						<a href="<?php echo esc_url( (string) get_edit_post_link( $muster_id ) ); ?>"><?php esc_html_e( 'vorhanden, bearbeiten', 'systelios-transfer' ); ?></a>
					<?php else : ?>
						<strong><?php esc_html_e( 'fehlt', 'systelios-transfer' ); ?></strong>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="stt_muster_anlegen">
			<?php wp_nonce_field( 'stt_muster_anlegen' ); ?>
			<?php submit_button( __( 'Fehlende Muster anlegen', 'systelios-transfer' ), 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

/**
 * Bestätigungsseite „Alle übernehmen“.
 */
function stt_inhalte_bestaetigen() {
	$liste = array();
	foreach ( stt_seiten_liste() as $seite ) {
		if ( 'fallback_auto' === stt_inhalt_zustand( $seite ) ) {
			$liste[] = $seite;
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Alle übernehmen?', 'systelios-transfer' ); ?></h1>
		<?php if ( ! $liste ) : ?>
			<p><?php esc_html_e( 'Es gibt keine Seiten im Zustand „Fallback automatisch“.', 'systelios-transfer' ); ?></p>
			<p><a class="button" href="<?php echo esc_url( stt_inhalte_url() ); ?>"><?php esc_html_e( 'Zurück', 'systelios-transfer' ); ?></a></p>
		<?php else : ?>
			<p><?php esc_html_e( 'Der mitgelieferte Inhalt dieser Seiten wird zum normalen Seiteninhalt. Der frühere Stand bleibt als Revision erhalten.', 'systelios-transfer' ); ?></p>
			<ul class="ul-disc">
				<?php foreach ( $liste as $seite ) : ?>
					<li><?php echo esc_html( get_the_title( $seite ) ); ?></li>
				<?php endforeach; ?>
			</ul>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="stt_alle_uebernehmen">
				<?php wp_nonce_field( 'stt_alle_uebernehmen' ); ?>
				<?php submit_button( __( 'Ja, alle übernehmen', 'systelios-transfer' ), 'primary', 'submit', false ); ?>
				<a class="button" href="<?php echo esc_url( stt_inhalte_url() ); ?>"><?php esc_html_e( 'Abbrechen', 'systelios-transfer' ); ?></a>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Block-Editor: bei Seiten im Zustand „Fallback automatisch“ ein Hinweis mit Knopf „Inhalt übernehmen“.
 */
function stt_editor_hinweis() {
	$beitrag = get_post();
	if ( ! $beitrag || 'page' !== $beitrag->post_type || 'fallback_auto' !== stt_inhalt_zustand( $beitrag ) ) {
		return;
	}
	wp_enqueue_script(
		'stt-editor-hinweis',
		STT_URI . '/assets/js/editor-hinweis.js',
		array( 'wp-data', 'wp-notices', 'wp-dom-ready' ),
		stt_asset_version( 'assets/js/editor-hinweis.js' ),
		true
	);
	wp_localize_script(
		'stt-editor-hinweis',
		'sttHinweis',
		array(
			'text'  => __( 'Diese Seite zeigt auf der Website derzeit den mitgelieferten Inhalt des Themes. Damit Sie ihn bearbeiten können, übernehmen Sie ihn zuerst.', 'systelios-transfer' ),
			'knopf' => __( 'Inhalt übernehmen', 'systelios-transfer' ),
			'url'   => add_query_arg( 'von', 'editor', stt_aktion_url( 'stt_uebernehmen', $beitrag->ID ) ),
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'stt_editor_hinweis' );
