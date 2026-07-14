<?php
defined( 'ABSPATH' ) || exit;

// ─── Elementor Active Helper ───────────────────────────────────────────────────

function whs_frame_is_elementor_active() {
	return defined( 'ELEMENTOR_VERSION' ) && class_exists( '\Elementor\Plugin' );
}

// ─── Main Render ──────────────────────────────────────────────────────────────

function whs_frame_header_render() {
	$sticky_mode = sanitize_key( get_theme_mod( 'whs_frame_header_sticky', 'none' ) );
	$transparent = (bool) get_theme_mod( 'whs_frame_header_transparent', false );

	$allowed_sticky = [ 'none', 'always', 'scroll_up' ];
	if ( ! in_array( $sticky_mode, $allowed_sticky, true ) ) {
		$sticky_mode = 'none';
	}

	$classes = [ 'flexbase-header-wrap' ];
	if ( 'none' !== $sticky_mode ) {
		$classes[] = 'flexbase-header-wrap--sticky';
	}
	if ( $transparent ) {
		$classes[] = 'flexbase-header-wrap--transparent';
	}
	?>
	<div id="flexbase-header-wrap"
		class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
		data-sticky="<?php echo esc_attr( $sticky_mode ); ?>"
		<?php echo $transparent ? 'data-transparent="true"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hardcoded attribute string, no user data ?>>

		<?php get_template_part( 'template-parts/default-header' ); ?>

	</div>
	<?php
}
add_action( 'whs_frame_header', 'whs_frame_header_render' );

// ─── Default Footer Render ────────────────────────────────────────────────────

function whs_frame_default_footer_render() {
	get_template_part( 'template-parts/default-footer' );
}
add_action( 'whs_frame_footer', 'whs_frame_default_footer_render', 10 );
