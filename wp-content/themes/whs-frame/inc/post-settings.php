<?php
defined( 'ABSPATH' ) || exit;

/**
 * Per-post "WHS Frame Settings" panel (block editor sidebar) — lets a post or
 * page override site-wide header/footer/title/featured-image display, similar
 * to Astra's per-post settings panel.
 */

// ─── Register Post Meta ─────────────────────────────────────────────────────

function whs_frame_register_post_meta() {
	$bool_fields = [
		'_whs_frame_disable_title',
		'_whs_frame_disable_featured_image',
		'_whs_frame_disable_header',
		'_whs_frame_disable_footer',
	];

	foreach ( $bool_fields as $key ) {
		register_post_meta( '', $key, [
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'default'       => false,
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		] );
	}

	register_post_meta( '', '_whs_frame_transparent_header', [
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'default'           => '',
		'sanitize_callback' => function ( $value ) {
			return in_array( $value, [ 'enable', 'disable' ], true ) ? $value : '';
		},
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	] );

	register_post_meta( '', '_whs_frame_content_layout', [
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'default'           => '',
		'sanitize_callback' => 'whs_frame_sanitize_content_layout',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	] );

	register_post_meta( '', '_whs_frame_content_custom_width', [
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'number',
		'default'           => 80,
		'sanitize_callback' => function ( $value ) {
			return max( 20, min( 100, absint( $value ) ) );
		},
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	] );

	register_post_meta( '', '_whs_frame_sidebar', [
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'default'           => '',
		'sanitize_callback' => function ( $value ) {
			return in_array( $value, [ 'none', 'left', 'right' ], true ) ? $value : '';
		},
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	] );
}
add_action( 'init', 'whs_frame_register_post_meta' );

/**
 * Allowed values for the per-post Content Layout override.
 *
 * @param  string $value Raw value.
 * @return string
 */
function whs_frame_sanitize_content_layout( $value ) {
	$allowed = [ 'boxed', 'content-boxed', 'full-width-contained', 'full-width-stretched', 'custom' ];
	return in_array( $value, $allowed, true ) ? $value : '';
}

// ─── Read Helpers ────────────────────────────────────────────────────────────

/**
 * Whether a boolean per-post override is enabled for the currently queried post.
 *
 * @param  string $key Post meta key (one of the _whs_frame_disable_* fields).
 * @return bool
 */
function whs_frame_post_disabled( $key ) {
	if ( ! is_singular() ) {
		return false;
	}
	return (bool) get_post_meta( get_queried_object_id(), $key, true );
}

/**
 * Effective transparent-header value for the current request: a per-post
 * override (Enable/Disable) wins over the Customizer default when set.
 *
 * @param  bool $default Customizer's whs_frame_header_transparent value.
 * @return bool
 */
function whs_frame_get_transparent_header( $default ) {
	if ( is_singular() ) {
		$override = get_post_meta( get_queried_object_id(), '_whs_frame_transparent_header', true );
		if ( 'enable' === $override ) {
			return true;
		}
		if ( 'disable' === $override ) {
			return false;
		}
	}
	return $default;
}

// ─── Content Layout Body Class ───────────────────────────────────────────────

/**
 * Adds a `whs-frame-layout--{mode}` body class when the current singular
 * post/page has a Content Layout override set. No class is added for the
 * default "Customizer Setting" (empty) value.
 *
 * @param  string[] $classes Existing body classes.
 * @return string[]
 */
function whs_frame_content_layout_body_class( $classes ) {
	if ( ! is_singular() ) {
		return $classes;
	}

	$layout = get_post_meta( get_queried_object_id(), '_whs_frame_content_layout', true );
	if ( $layout ) {
		$classes[] = 'whs-frame-layout--' . $layout;
	}

	return $classes;
}
add_filter( 'body_class', 'whs_frame_content_layout_body_class' );

/**
 * Outputs the inline CSS for the "Custom" Content Layout width — the exact
 * percentage is user-entered so it can't be pre-defined as a static class.
 * Always paired with auto margins so the content stays centered.
 */
function whs_frame_content_custom_width_style() {
	if ( ! is_singular() ) {
		return;
	}

	$post_id = get_queried_object_id();
	$layout  = get_post_meta( $post_id, '_whs_frame_content_layout', true );

	if ( 'custom' !== $layout ) {
		return;
	}

	$width = (int) get_post_meta( $post_id, '_whs_frame_content_custom_width', true );
	if ( $width < 20 || $width > 100 ) {
		$width = 80;
	}

	printf(
		'<style id="whs-frame-content-custom-width">body.whs-frame-layout--custom .whs-frame-post{max-width:%1$d%%;margin-left:auto;margin-right:auto;}</style>',
		absint( $width )
	);
}
add_action( 'wp_head', 'whs_frame_content_custom_width_style' );

// ─── Editor Panel Assets ─────────────────────────────────────────────────────

function whs_frame_enqueue_post_settings_assets() {
	wp_enqueue_script(
		'whs-frame-post-settings',
		WHS_FRAME_ASSETS . 'admin/post-settings.js',
		[ 'wp-plugins', 'wp-editor', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n' ],
		WHS_FRAME_VERSION,
		true
	);

	wp_enqueue_style(
		'whs-frame-post-settings',
		WHS_FRAME_ASSETS . 'admin/post-settings.css',
		[],
		WHS_FRAME_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'whs_frame_enqueue_post_settings_assets' );
