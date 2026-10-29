<?php
/**
 * Grundeinstellungen: Theme-Unterstützung, Menüs, Bildgrößen, Textauszug für Seiten.
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme-Unterstützung und Menüpositionen.
 */
function stt_setup() {
	load_theme_textdomain( 'systelios-transfer', STT_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	// Textauszug dient bei Seiten als Einleitung im Seitenkopf.
	add_post_type_support( 'page', 'excerpt' );

	register_nav_menus(
		array(
			'haupt' => esc_html__( 'Hauptmenü', 'systelios-transfer' ),
			'fuss'  => esc_html__( 'Fußmenü', 'systelios-transfer' ),
		)
	);

	// Bildband im Seitenkopf (Beitragsbild).
	add_image_size( 'stt-band', 1600, 480, true );
}
add_action( 'after_setup_theme', 'stt_setup' );

/**
 * Emoji-Skripte und -Styles entfernen (keine unnötigen Requests).
 */
function stt_emoji_entfernen() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'stt_emoji_entfernen' );

/**
 * Menüeinträge: aktuelle Seite für Hilfstechnik und CSS kennzeichnen.
 *
 * @param array   $atts Link-Attribute.
 * @param WP_Post $item Menüeintrag.
 * @return array
 */
function stt_menue_link_attribute( $atts, $item ) {
	if ( ! empty( $item->current ) ) {
		$atts['aria-current'] = 'page';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'stt_menue_link_attribute', 10, 2 );

/**
 * Ersatz, solange dem Hauptmenü kein Menü zugewiesen ist: oberste Seiten.
 *
 * @param array $args Argumente von wp_nav_menu().
 */
function stt_menue_ersatz( $args ) {
	$seiten = get_pages(
		array(
			'parent'      => 0,
			'sort_column' => 'menu_order,post_title',
		)
	);
	$id = isset( $args['menu_id'] ) ? $args['menu_id'] : '';
	echo '<ul id="' . esc_attr( $id ) . '" class="' . esc_attr( $args['menu_class'] ) . '">';
	foreach ( $seiten as $seite ) {
		$aktuell = is_page( $seite->ID );
		printf(
			'<li class="menu-item%s"><a href="%s"%s>%s</a></li>',
			$aktuell ? ' current-menu-item' : '',
			esc_url( get_permalink( $seite ) ),
			$aktuell ? ' aria-current="page"' : '',
			esc_html( get_the_title( $seite ) )
		);
	}
	echo '</ul>';
}
