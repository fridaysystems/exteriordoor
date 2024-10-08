<?php
/**
 * Reference Template: Source Information
 *
 * @package wporg-developer
 * @subpackage Reference
 */

namespace DevHub;

$source_file = get_source_file();
if ( ! empty( $source_file ) ) {
	?>
	<hr />
	<section class="source-content">
		<h2><?php _e( 'Source', 'wporg' ); ?></h2>
		<p>
			<?php
			printf(
				__( 'File: %s', 'wporg' ),
				'<a href="' . esc_url( get_source_file_archive_link( $source_file ) ) . '">' . esc_html( $source_file ) . '</a>'
			);
			?>
		</p>

		<?php

		$view_on_trac_link_text = apply_filters( 'wp-parser_view_on_trac_link_text', __( 'View on Trac', 'wporg' ) );

		if ( post_type_has_source_code() ) :
			?>
			<div class="source-code-container">
				<pre class="brush: php; toolbar: false; first-line: <?php echo esc_attr( get_post_meta( get_the_ID(), '_wp-parser_line_num', true ) ); ?>"><?php echo htmlentities( get_source_code( get_the_ID(), true ) ); ?></pre>
			</div>
			<p class="source-code-links">
				<span><a href="#source" class="show-complete-source"><?php _e( 'Expand full source code', 'wporg' ); ?></a><a href="#source" class="less-complete-source"><?php _e( 'Collapse full source code', 'wporg' ); ?></a></span><span><a href="<?php echo get_source_file_link(); ?>"><?php echo $view_on_trac_link_text; ?></a></span>
			</p>
		<?php else : ?>
			<p>
				<a href="<?php echo get_source_file_link(); ?>"><?php echo $view_on_trac_link_text; ?></a>
			</p>
		<?php endif; ?>
	</section>
	<?php
}
