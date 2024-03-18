<?php
/**
 * Exterior Door functions
 *
 * @package exteriordoor
 * @author Corey Salzano <csalzano@duck.com>
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'exteriordoor_styles' );
/**
 * Includes the theme style.css.
 *
 * @return void
 */
function exteriordoor_styles() {
	wp_enqueue_style(
		'exteriordoor',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}

/**
 * change_view_on_trac_link
 *
 * @param  mixed $text
 * @return void
 */
function change_view_on_trac_link( $text ) {
	return __( 'View on Github', 'cannyon-presser' );
}
add_filter( 'wp-parser_view_on_trac_link_text', 'change_view_on_trac_link' );

/**
 * change_source_url_base
 *
 * @param  mixed $url_base
 * @param  mixed $post_id
 * @return void
 */
function change_source_url_base( $url_base, $post_id ) {
	return 'https://github.com/fridaysystems/inventory-presser/blob/master/';
}
add_filter( 'wp-parser_source_url_base', 'change_source_url_base', 10, 2 );

/**
 * wordpress.org developer docs features
 */
require_once 'wporg-docs.php';
require_once 'shortcode-reference.php';
