<?php
/**
 * sysTelios Transfer – Theme-Einstieg. Enthält nur die Einbindung der Dateien in inc/.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STT_VERSION', '0.7.0' );
define( 'STT_DIR', get_template_directory() );
define( 'STT_URI', get_template_directory_uri() );

require_once STT_DIR . '/inc/setup.php';
require_once STT_DIR . '/inc/assets.php';
require_once STT_DIR . '/inc/vorlage.php';
require_once STT_DIR . '/inc/editor.php';
require_once STT_DIR . '/inc/bloecke.php';
require_once STT_DIR . '/inc/config.php';
require_once STT_DIR . '/inc/muster.php';
require_once STT_DIR . '/inc/inhalte.php';
require_once STT_DIR . '/inc/familie.php';
require_once STT_DIR . '/inc/shortcodes.php';
require_once STT_DIR . '/inc/plugin-bseasy.php';
require_once STT_DIR . '/inc/seo.php';

if ( is_admin() ) {
	require_once STT_DIR . '/inc/admin/inhalte.php';
	require_once STT_DIR . '/inc/admin/einstellungen.php';
	require_once STT_DIR . '/inc/admin/hilfe.php';
}
