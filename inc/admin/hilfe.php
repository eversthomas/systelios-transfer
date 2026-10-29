<?php
/**
 * Backend: „So pflegen Sie Transfer“ – kurze Hilfe für Redakteur*innen (statisch, keine Datenbank).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Menüpunkt unter „Dashboard“.
 */
function stt_hilfe_menue() {
	add_submenu_page(
		'index.php',
		__( 'So pflegen Sie Transfer', 'systelios-transfer' ),
		__( 'So pflegen Sie Transfer', 'systelios-transfer' ),
		'edit_pages',
		'stt-hilfe',
		'stt_hilfe_seite'
	);
}
add_action( 'admin_menu', 'stt_hilfe_menue' );

/**
 * Hilfeseite.
 */
function stt_hilfe_seite() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( esc_html__( 'Sie dürfen diese Seite nicht aufrufen.', 'systelios-transfer' ), '', array( 'response' => 403 ) );
	}
	$inhalte_url = function_exists( 'stt_inhalte_url' ) ? stt_inhalte_url() : admin_url( 'themes.php?page=stt-inhalte' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'So pflegen Sie Transfer', 'systelios-transfer' ); ?></h1>
		<p><?php esc_html_e( 'Kurz und bündig: Wo Sie was ändern, und was das Theme für Sie übernimmt.', 'systelios-transfer' ); ?></p>

		<h2><?php esc_html_e( 'Was Sie pflegen', 'systelios-transfer' ); ?></h2>
		<ul class="ul-disc">
			<li><strong><?php esc_html_e( 'Titel', 'systelios-transfer' ); ?></strong> – <?php esc_html_e( 'ist zugleich die große Überschrift (H1) der Seite. Im Text selbst beginnen Überschriften deshalb bei Ebene 2.', 'systelios-transfer' ); ?></li>
			<li><strong><?php esc_html_e( 'Einleitung (Seitenkopf)', 'systelios-transfer' ); ?></strong> – <?php esc_html_e( 'im Editor rechts unter „Textauszug“. Sie erscheint als Einleitungstext unter dem Titel.', 'systelios-transfer' ); ?></li>
			<li><strong><?php esc_html_e( 'Beitragsbild', 'systelios-transfer' ); ?></strong> – <?php esc_html_e( 'erscheint als Bildband im Seitenkopf. Ohne Bild gibt es kein Band.', 'systelios-transfer' ); ?></li>
			<li><strong><?php esc_html_e( 'Inhalt', 'systelios-transfer' ); ?></strong> – <?php esc_html_e( 'im Block-Editor. Nutzen Sie die Muster aus der Kategorie „Transfer“ (Plus-Zeichen → Muster) und die Stile in der rechten Leiste.', 'systelios-transfer' ); ?></li>
			<li><strong><?php esc_html_e( 'Startseite', 'systelios-transfer' ); ?></strong> – <?php esc_html_e( 'nur Texte und Bilder ändern; die Abschnitte sind fest.', 'systelios-transfer' ); ?></li>
			<li><strong><?php esc_html_e( 'Menüs', 'systelios-transfer' ); ?></strong> – <?php esc_html_e( 'unter Design → Menüs (Hauptmenü und Fußmenü).', 'systelios-transfer' ); ?></li>
		</ul>

		<h2><?php esc_html_e( 'Einmal ändern, überall wirksam', 'systelios-transfer' ); ?></h2>
		<p><?php esc_html_e( 'Die Kontaktfläche „Ins Gespräch kommen“ und der Hinweis zur Heilkunde sind synchronisierte Muster: Wenn Sie sie an einer Stelle ändern, ändern sie sich überall. Sie finden sie im Editor unter Muster → Synchronisiert.', 'systelios-transfer' ); ?></p>

		<h2><?php esc_html_e( 'Begleiter*innen und Termine', 'systelios-transfer' ); ?></h2>
		<p><?php esc_html_e( 'Das Verzeichnis der Begleiter*innen und die Termine des Transferabends kommen automatisch aus easyVerein (BSEasy Sync). Sie ändern sie dort, nicht hier.', 'systelios-transfer' ); ?></p>

		<h2><?php esc_html_e( 'Mitgelieferter Inhalt', 'systelios-transfer' ); ?></h2>
		<p>
			<?php esc_html_e( 'Manche Seiten zeigen zunächst den mitgelieferten Inhalt des Themes. Um sie zu bearbeiten, übernehmen Sie den Inhalt in den Editor:', 'systelios-transfer' ); ?>
			<a href="<?php echo esc_url( $inhalte_url ); ?>"><?php esc_html_e( 'Design → Transfer-Inhalte', 'systelios-transfer' ); ?></a>.
		</p>

		<h2><?php esc_html_e( 'Wenn etwas schiefgeht', 'systelios-transfer' ); ?></h2>
		<p><?php esc_html_e( 'Jede Änderung wird als Revision gespeichert. Im Editor rechts unter „Revisionen“ können Sie frühere Stände ansehen und wiederherstellen.', 'systelios-transfer' ); ?></p>
	</div>
	<?php
}
