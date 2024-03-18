<?php

add_action(
	'init',
	function () {
		add_shortcode( 'breadcrumb_trail', 'breadcrumb_trail_shortcode_content' );
	}
);
/**
 * breadcrumb_trail_shortcode_content
 *
 * @param  array $atts
 * @return string
 */
function breadcrumb_trail_shortcode_content( $atts ) {
	// Capture the breadcrumbs in a string.
	ob_start();
	breadcrumb_trail();
	return str_replace( array( "\t", "\n" ), '', ob_get_clean() );
}
