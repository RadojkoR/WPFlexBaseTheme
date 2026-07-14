<?php
defined( 'ABSPATH' ) || exit;

/**
 * Bricks Builder compatibility for WHS Frame.
 *
 * Handles:
 *  1. Theme support declaration
 *  2. Registering header/footer locations with Bricks Theme Locations
 *  3. Rendering header/footer via the location API (priority 8)
 *  4. Body class when Bricks is active
 *
 * Each callback guards internally with whs_frame_is_bricks_active() because
 * Bricks loads after functions.php — checking at file-load time would always return false.
 */

// ─── Helper ───────────────────────────────────────────────────────────────────

function whs_frame_is_bricks_active() {
	return defined( 'BRICKS_VERSION' ) && class_exists( '\Bricks\Theme_Locations' );
}

// ─── 1. Theme Support ─────────────────────────────────────────────────────────

function whs_frame_bricks_theme_support() {
	add_theme_support( 'bricks' );
}
add_action( 'after_setup_theme', 'whs_frame_bricks_theme_support' );

// ─── 2. Register Bricks Theme Locations ───────────────────────────────────────

/**
 * Register header and footer as named locations with Bricks Theme Builder.
 * Ties each location to our own action hooks so Bricks knows where to inject.
 */
function whs_frame_register_bricks_locations( $locations ) {
	if ( ! whs_frame_is_bricks_active() ) {
		return;
	}

	$locations->register_location( 'header', [
		'label'         => __( 'Header', 'whs-frame' ),
		'hook_name'     => 'whs_frame_header',
		'hook_priority' => 10,
	] );

	$locations->register_location( 'footer', [
		'label'         => __( 'Footer', 'whs-frame' ),
		'hook_name'     => 'whs_frame_footer',
		'hook_priority' => 10,
	] );
}
add_action( 'bricks/theme_locations/register', 'whs_frame_register_bricks_locations' );

// ─── 3. Header Location Rendering ─────────────────────────────────────────────

/**
 * Fires at priority 8 on 'whs_frame_header', after Elementor (priority 5) and
 * before the default render (priority 10).
 *
 * Captures render_location('header') output. If Bricks has a template assigned
 * it renders it wrapped in #whs-frame-header-wrap so sticky.js and
 * transparent-header logic still function. If nothing is rendered, returns early
 * and lets whs_frame_header_render run normally.
 */
function whs_frame_bricks_render_header() {
	if ( ! whs_frame_is_bricks_active() ) {
		return;
	}

	ob_start();
	$rendered = \Bricks\Theme_Locations::render_location( 'header' );
	$content  = ob_get_clean();

	if ( ! $rendered || ! $content ) {
		return;
	}

	// Mirror the wrapper logic from whs_frame_header_render so sticky/transparent still work.
	$sticky_mode = sanitize_key( get_theme_mod( 'whs_frame_header_sticky', 'none' ) );
	$transparent = (bool) get_theme_mod( 'whs_frame_header_transparent', false );

	if ( ! in_array( $sticky_mode, [ 'none', 'always', 'scroll_up' ], true ) ) {
		$sticky_mode = 'none';
	}

	$classes = [ 'whs-frame-header-wrap', 'whs-frame-header-wrap--bricks-location' ];
	if ( 'none' !== $sticky_mode ) {
		$classes[] = 'whs-frame-header-wrap--sticky';
	}
	if ( $transparent ) {
		$classes[] = 'whs-frame-header-wrap--transparent';
	}

	printf(
		'<div id="whs-frame-header-wrap" class="%s" data-sticky="%s"%s>%s</div>',
		esc_attr( implode( ' ', $classes ) ),
		esc_attr( $sticky_mode ),
		$transparent ? ' data-transparent="true"' : '',
		$content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — sanitised by Bricks
	);

	// Bricks rendered the header — remove the default render to prevent duplicate output.
	remove_action( 'whs_frame_header', 'whs_frame_header_render', 10 );
}
add_action( 'whs_frame_header', 'whs_frame_bricks_render_header', 8 );

// ─── 4. Footer Location Rendering ─────────────────────────────────────────────

/**
 * Same pattern as the header location but for the footer.
 * Fires at priority 8 on 'whs_frame_footer' before the default footer render.
 */
function whs_frame_bricks_render_footer() {
	if ( ! whs_frame_is_bricks_active() ) {
		return;
	}

	ob_start();
	$rendered = \Bricks\Theme_Locations::render_location( 'footer' );
	$content  = ob_get_clean();

	if ( ! $rendered || ! $content ) {
		return;
	}

	printf(
		'<div class="whs-frame-footer-wrap whs-frame-footer-wrap--bricks-location">%s</div>',
		$content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — sanitised by Bricks
	);

	remove_action( 'whs_frame_footer', 'whs_frame_default_footer_render', 10 );
}
add_action( 'whs_frame_footer', 'whs_frame_bricks_render_footer', 8 );

// ─── 5. Body Class ────────────────────────────────────────────────────────────

function whs_frame_bricks_body_classes( $classes ) {
	if ( ! whs_frame_is_bricks_active() ) {
		return $classes;
	}

	$classes[] = 'whs-frame-bricks-active';

	return $classes;
}
add_filter( 'body_class', 'whs_frame_bricks_body_classes' );
