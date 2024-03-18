<?php

add_action(
	'init',
	function () {
		add_shortcode( 'wporg_reference', 'wporg_reference_shortcode_content' );
	}
);

add_filter( 'the_content', 'wporg_reference_content' );
function wporg_reference_content( $content ) {
	if ( ! in_array( get_post_type(), \DevHub\get_parsed_post_types(), true ) ) {
		return $content;
	}
	remove_filter( 'the_content', 'wporg_reference_content' );
	return apply_shortcodes( '[wporg_reference]' );
}
/**
 * wporg_reference_shortcode_content
 *
 * @param  array $atts
 * @return string
 */
function wporg_reference_shortcode_content( $atts ) {
	$html = get_deprecated()
		. get_private_access_message()
		. '<h1>' . get_signature() . '</h1>'
		. '<section class="summary">' . get_summary() . '</section>';
	if ( is_single() ) {
		$content = get_reference_template_parts();

		// If the Handbook TOC is available, use it.
		if ( class_exists( 'WPorg_Handbook_TOC' ) ) {
			$toc     = new \WPorg_Handbook_TOC(
				\DevHub\get_parsed_post_types(),
				array(
					'header_text' => __( 'On This Page', 'wporg' ),
				)
			);
			$content = '<div class="content-toc">' . $toc->add_toc( $content ) . '</div>';
		}
		$html .= $content;
	}
	return $html;
}
