<?php
//namespace DevHub;

add_action( 'init', function() {
	add_shortcode( 'wporg_reference', 'wporg_reference_shortcode_content' );
} );
/**
 * wporg_reference_shortcode_content
 *
 * @param  mixed $atts
 * @return void
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
				get_parsed_post_types(),
				array(
					'header_text' => __( 'Contents', 'wporg' )
				)
			);
			$content = '<div class="content-toc">' . $toc->add_toc( $content ) . '</div>';
		}
		$html .= $content;
	}
	return $html;
}
