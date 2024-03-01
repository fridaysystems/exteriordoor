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
