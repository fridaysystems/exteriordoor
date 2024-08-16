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
 * Changes "View on Trac" to "View on Github".
 *
 * @param  mixed $text
 * @return void
 */
function change_view_on_trac_link( $text ) {
	return __( 'View on Github', 'exteriordoor' );
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

add_filter( 'pre_get_posts', 'invp_change_archive_per_page' );
function invp_change_archive_per_page( $wp_query ) {
	if ( empty( $wp_query->query_vars['post_type'] ) || ! in_array( $wp_query->query_vars['post_type'], \DevHub\get_parsed_post_types(), true ) ) {
		return $wp_query;
	}
	$wp_query->query_vars['posts_per_page'] = 100;
	return $wp_query;
}


/**
 * wordpress.org developer docs features
 */
require_once 'wporg-docs.php';
require_once 'shortcode-wporg-post-type-or-taxonomy-description.php';
require_once 'shortcode-wporg-file.php';
require_once 'shortcode-wporg-reference.php';
require_once 'shortcode-breadcrumb-trail.php';

// Remove a few post types.
add_filter( 'handbook_post_types', 'invp_remove_handbook_post_types', 11 );
/**
 * invp_remove_handbook_post_types
 *
 * @param  mixed $post_types
 * @return void
 */
function invp_remove_handbook_post_types( $post_types ) {
	unset( $post_types[1] );
	unset( $post_types[2] );
	return $post_types;
}

/**
 * Add a 250px spacer to the Easy Digital Downloads Software Licensing UI. This
 * affects the Purchase History page when users press View Licenses or Manage
 * Sites.
 *
 * @param string $content The post content.
 * @return string
 */
function edd_add_spacers_to_software_licensing_ui( $content ) {

	if ( empty( $_GET['action'] ) || 'manage_licenses' != $_GET['action'] ) {
		return $content;
	}

	if ( empty( $_GET['payment_id'] ) ) {
		return $content;
	}

	if ( ! in_the_loop() ) {
		return $content;
	}

	return $content . '<div style="height:250px" aria-hidden="true" class="wp-block-spacer"></div>';
}
add_filter( 'the_content', 'edd_add_spacers_to_software_licensing_ui', 10, 4 );
