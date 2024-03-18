<?php

add_action(
	'init',
	function () {
		add_shortcode( 'wporg_file', 'wporg_file_shortcode_content' );
	}
);

/**
 * wporg_file_shortcode_content
 *
 * @param  array $atts
 * @return string
 */
function wporg_file_shortcode_content( $atts ) {
	$terms = wp_get_object_terms( get_the_ID(), 'wp-parser-source-file' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}
	return sprintf(
		'<a href="%s"><code>%s</code></a>',
		site_url( 'docs/reference/files/' . $terms[0]->name . '/' ),
		esc_html( $terms[0]->name )
	);
}
