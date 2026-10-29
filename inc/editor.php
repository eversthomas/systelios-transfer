<?php
/**
 * Block-Editor-Leitplanken: erlaubte Blöcke, Überschriftenebenen, Abschalten von
 * Block-Verzeichnis, Remote-Mustern und Code-Editor. Siehe docs/03-pflegekonzept.md.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Erlaubte Blöcke – für alle Rollen gleich, damit alle dasselbe sehen.
 *
 * @param bool|string[] $erlaubt Bisher erlaubte Blöcke.
 * @return string[]
 */
function stt_erlaubte_bloecke( $erlaubt ) {
	unset( $erlaubt );
	return array(
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'core/image',
		'core/quote',
		'core/buttons',
		'core/button',
		'core/separator',
		'core/group',
		'core/columns',
		'core/column',
		'core/media-text',
		'core/details',
		'core/file',
		'core/shortcode',
		'core/block',
		'core/pattern',
	);
}
add_filter( 'allowed_block_types_all', 'stt_erlaubte_bloecke' );

/**
 * Überschriften nur als H2–H4. Die H1 kommt immer aus dem Seitentitel.
 *
 * @param array  $args Block-Argumente.
 * @param string $name Blockname.
 * @return array
 */
function stt_ueberschrift_ebenen( $args, $name ) {
	if ( 'core/heading' === $name ) {
		if ( ! isset( $args['attributes'] ) || ! is_array( $args['attributes'] ) ) {
			$args['attributes'] = array();
		}
		$args['attributes']['levelOptions'] = array(
			'type'    => 'array',
			'default' => array( 2, 3, 4 ),
		);
	}
	return $args;
}
add_filter( 'register_block_type_args', 'stt_ueberschrift_ebenen', 10, 2 );

/**
 * Block-Verzeichnis, Remote-Muster und Core-Muster abschalten.
 */
function stt_editor_abschalten() {
	remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'init', 'stt_editor_abschalten' );
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Editor-Einstellungen: kein Code-Editor (Roh-HTML), keine Openverse-Suche.
 *
 * @param array $einstellungen Editor-Einstellungen.
 * @return array
 */
function stt_editor_einstellungen( $einstellungen ) {
	$einstellungen['codeEditingEnabled']          = false;
	$einstellungen['enableOpenverseMediaCategory'] = false;
	return $einstellungen;
}
add_filter( 'block_editor_settings_all', 'stt_editor_einstellungen' );

/**
 * Editor-Skript: benennt den Textauszug um und entfernt doppelte Block-Stile.
 */
function stt_editor_skript() {
	wp_enqueue_script(
		'stt-editor',
		STT_URI . '/assets/js/editor.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-i18n', 'wp-edit-post' ),
		stt_asset_version( 'assets/js/editor.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'stt_editor_skript' );
