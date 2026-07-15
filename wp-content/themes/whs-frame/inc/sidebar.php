<?php
defined( 'ABSPATH' ) || exit;

/**
 * Blog sidebar: widget area + site-wide default (Customizer) + per-post
 * override (WHS Frame Settings panel, see inc/post-settings.php).
 */

// ─── Register Widget Area ────────────────────────────────────────────────────

function whs_frame_register_sidebar() {
	register_sidebar( [
		'name'          => __( 'Blog Sidebar', 'whs-frame' ),
		'id'            => 'whs-frame-blog-sidebar',
		'description'   => __( 'Shown next to single posts and pages when a sidebar layout is selected.', 'whs-frame' ),
		'before_widget' => '<div id="%1$s" class="whs-frame-sidebar__widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="whs-frame-sidebar__widget-title">',
		'after_title'   => '</h4>',
	] );
}
add_action( 'widgets_init', 'whs_frame_register_sidebar' );

// ─── Effective Position Helper ───────────────────────────────────────────────

/**
 * Effective sidebar position for the current request: a per-post override
 * wins over the Customizer default when set to something other than
 * "Customizer Setting".
 *
 * @return string 'none' | 'left' | 'right'
 */
function whs_frame_get_sidebar_position() {
	$default = sanitize_key( get_theme_mod( 'whs_frame_sidebar_position', 'none' ) );
	if ( ! in_array( $default, [ 'none', 'left', 'right' ], true ) ) {
		$default = 'none';
	}

	if ( is_singular() ) {
		$override = get_post_meta( get_queried_object_id(), '_whs_frame_sidebar', true );
		if ( in_array( $override, [ 'none', 'left', 'right' ], true ) ) {
			return $override;
		}
	}

	return $default;
}
