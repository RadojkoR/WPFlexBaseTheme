<?php
/**
 * Comments template.
 *
 * Used by comments_template() in page templates and the main loop.
 */

defined( 'ABSPATH' ) || exit;

// Do not load comments for password-protected posts.
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="whs-frame-comments">

	<?php if ( have_comments() ) : ?>

		<h2 class="whs-frame-comments__title">
			<?php
			$whs_frame_comment_count = get_comments_number();
			printf(
				/* translators: %s: number of comments. */
				esc_html( _n( '%s Comment', '%s Comments', $whs_frame_comment_count, 'whs-frame' ) ),
				esc_html( number_format_i18n( $whs_frame_comment_count ) )
			);
			?>
		</h2>

		<ol class="whs-frame-comments__list">
			<?php
			wp_list_comments( [
				'style'      => 'ol',
				'short_ping' => true,
			] );
			?>
		</ol>

		<?php
		the_comments_navigation( [
			'prev_text' => __( '&larr; Older comments', 'whs-frame' ),
			'next_text' => __( 'Newer comments &rarr;', 'whs-frame' ),
		] );
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="whs-frame-comments__closed"><?php esc_html_e( 'Comments are closed.', 'whs-frame' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>
