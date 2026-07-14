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
}
add_action( 'init', 'whs_frame_register_post_meta' );

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

// ─── Editor Panel Assets ─────────────────────────────────────────────────────

function whs_frame_enqueue_post_settings_assets() {
	wp_enqueue_script(
		'whs-frame-post-settings',
		WHS_FRAME_ASSETS . 'admin/post-settings.js',
		[ 'wp-plugins', 'wp-editor', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n' ],
		WHS_FRAME_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'whs_frame_enqueue_post_settings_assets' );
