<?php

add_action(
	'init',
	function () {
		add_shortcode( 'wporg_post_type_or_taxonomy_description', 'wporg_description_shortcode_content' );
	}
);

/**
 * wporg_description_shortcode_content
 *
 * @param  array $atts
 * @return string
 */
function wporg_description_shortcode_content( $atts ) {
	$post_type_name = get_post_type();
	if ( ! empty( $post_type_name ) ) {
		$post_type = get_post_type_object( $post_type_name );
		if ( ! empty( $post_type ) ) {
			return $post_type->description;
		}
	}

	return '';
}
