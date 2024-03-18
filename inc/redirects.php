<?php
/**
 * Code Reference redirects.
 *
 * @package wporg-developer
 */

/**
 * Class to handle redirects.
 */
class DevHub_Redirects {

	/**
	 * Initializer
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'do_init' ) );
	}

	/**
	 * Handles adding/removing hooks to perform redirects as needed.
	 */
	public static function do_init() {
		add_action( 'template_redirect', array( __CLASS__, 'redirect_single_search_match' ) );
		add_action( 'template_redirect', array( __CLASS__, 'redirect_handbook' ) );
		add_action( 'template_redirect', array( __CLASS__, 'redirect_pluralized_reference_post_types' ), 1 );
		add_action( 'template_redirect', array( __CLASS__, 'paginated_home_page_404' ) );
	}

	/**
	 * Redirects a search query with only one result directly to that result.
	 *
	 * @globals \WP_Query $wp_query Global WP_Query instance.
	 */
	public static function redirect_single_search_match() {
		global $wp_query;

		if ( is_search() && ! $wp_query->is_handbook && 1 == $wp_query->found_posts ) {
			wp_redirect( get_permalink( get_post() ) );
			exit();
		}
	}

	/**
	 * Redirects a naked handbook request to home.
	 */
	public static function redirect_handbook() {
		if (
			// Naked /handbook/ request
			( 'handbook' == get_query_var( 'name' ) && ! get_query_var( 'post_type' ) )
		) {
			wp_redirect( home_url() );
			exit();
		}
	}

	/**
	 * Redirects requests for the pluralized slugs of the code reference parsed
	 * post types.
	 *
	 * Note: this is a convenience redirect and not a fix for any officially
	 * deployed links.
	 */
	public static function redirect_pluralized_reference_post_types() {
		$path = trailingslashit( $_SERVER['REQUEST_URI'] );

		$post_types = array(
			'class'    => 'classes',
			'function' => 'functions',
			'hook'     => 'hooks',
			'method'   => 'methods',
		);

		// '/reference/$singular(/*)?' => '/reference/$plural(/*)?'
		foreach ( $post_types as $post_type_slug_singular => $post_type_slug_plural ) {
			if ( 0 === stripos( $path, "/reference/{$post_type_slug_singular}/" ) ) {
				$path = "docs/reference/{$post_type_slug_plural}/" . substr( $path, strlen( "/reference/{$post_type_slug_singular}/" ) );
				wp_redirect( $path, 301 );
				exit();
			}
		}
	}

	/**
	 * Returns 404 response to requests for non-first pages of the front page.
	 */
	public static function paginated_home_page_404() {
		// Paginated front page.
		if ( is_front_page() && is_paged() ) {
			include get_stylesheet_directory() . '/404.php';
			exit;
		}
	}
} // DevHub_Redirects

DevHub_Redirects::init();
