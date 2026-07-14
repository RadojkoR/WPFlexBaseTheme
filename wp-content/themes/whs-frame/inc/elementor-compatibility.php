<?php
defined( 'ABSPATH' ) || exit;

/**
 * Elementor compatibility for WHS Frame.
 *
 * Handles:
 *  1. Theme support declaration
 *  2. Registering header/footer locations with Elementor Theme Builder
 *  3. Rendering header/footer via the location API (wraps output for sticky/transparent support)
 *  4. whs_frame_elementor_get_location_templates filter for fallback template overrides
 *  5. Disabling conflicting default renders from Elementor Pro
 *  6. CSS classes on body and header/footer wrappers
 *  7. Inline style normalization for Elementor inside our wrappers
 *
 * Each callback guards internally with whs_frame_is_elementor_active() because
 * Elementor loads after functions.php — checking at file-load time would always return false.
 * whs_frame_is_elementor_active() is defined in inc/header-builder.php (loaded before this file).
 */

// ─── 1. Theme Support ─────────────────────────────────────────────────────────

/**
 * Declare theme support for Elementor's native Theme Builder locations and the
 * 'Header Footer Elementor' plugin, both of which check for this support flag.
 */
function whs_frame_elementor_theme_support() {
	add_theme_support( 'header-footer-elementor' );
}
add_action( 'after_setup_theme', 'whs_frame_elementor_theme_support' );

// ─── 2. Register Elementor Theme Locations ────────────────────────────────────

/**
 * Register header and footer as named locations with Elementor Pro's Theme Builder.
 * Once registered, Elementor Pro's UI shows these locations in the "Display Conditions"
 * panel, allowing editors to assign templates without writing code.
 *
 * 'hook' ties the location to our own action hooks so Elementor knows where to inject.
 * 'default_template' is used by Elementor as the fallback when no template is assigned.
 */
function whs_frame_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location( 'header', [
		'label'            => __( 'Header', 'whs-frame' ),
		'default_template' => WHS_FRAME_DIR . '/template-parts/default-header.php',
		'hook'             => 'whs_frame_header',
		'edit_in_content'  => false,
	] );

	$elementor_theme_manager->register_location( 'footer', [
		'label'            => __( 'Footer', 'whs-frame' ),
		'default_template' => WHS_FRAME_DIR . '/template-parts/default-footer.php',
		'hook'             => 'whs_frame_footer',
		'edit_in_content'  => false,
	] );
}
add_action( 'elementor/theme/register_locations', 'whs_frame_register_elementor_locations' );

// ─── 3. Header Location Rendering ─────────────────────────────────────────────

/**
 * Fires at priority 5 on 'whs_frame_header', before whs_frame_header_render (priority 10).
 *
 * Captures elementor_theme_do_location('header') output. If Elementor has a template
 * assigned to the header location it renders it; we wrap it in #whs-frame-header-wrap
 * so sticky.js and transparent-header logic still function. If Elementor renders nothing
 * (no template assigned) we return early and let whs_frame_header_render run normally.
 */
function whs_frame_elementor_render_header_location() {
	if ( ! whs_frame_is_elementor_active() || ! function_exists( 'elementor_theme_do_location' ) ) {
		return;
	}

	ob_start();
	$rendered = elementor_theme_do_location( 'header' );
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

	$classes = [ 'whs-frame-header-wrap', 'whs-frame-header-wrap--elementor-location' ];
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
		$content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — sanitised by Elementor
	);

	// Elementor rendered the header — remove the default render to prevent duplicate output.
	remove_action( 'whs_frame_header', 'whs_frame_header_render', 10 );
}
add_action( 'whs_frame_header', 'whs_frame_elementor_render_header_location', 5 );

// ─── 4. Footer Location Rendering ─────────────────────────────────────────────

/**
 * Same pattern as the header location but for the footer.
 * Fires at priority 5 on 'whs_frame_footer' before the default footer render.
 *
 * Note: footer.php must call do_action('whs_frame_footer') for this to trigger.
 * Until that change is made, this hook is in place for when footer.php is updated.
 */
function whs_frame_elementor_render_footer_location() {
	if ( ! whs_frame_is_elementor_active() || ! function_exists( 'elementor_theme_do_location' ) ) {
		return;
	}

	ob_start();
	$rendered = elementor_theme_do_location( 'footer' );
	$content  = ob_get_clean();

	if ( ! $rendered || ! $content ) {
		return;
	}

	printf(
		'<div class="whs-frame-footer-wrap whs-frame-footer-wrap--elementor-location">%s</div>',
		$content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — sanitised by Elementor
	);

	// Remove the default footer render if it is registered.
	remove_action( 'whs_frame_footer', 'whs_frame_default_footer_render', 10 );
}
add_action( 'whs_frame_footer', 'whs_frame_elementor_render_footer_location', 5 );

// ─── 5. whs_frame_elementor_get_location_templates Filter ─────────────────────

/**
 * Returns the fallback PHP template path for a given location when Elementor
 * has no template assigned. Applies the filter 'whs_frame_elementor_get_location_templates'
 * so child themes or plugins can override the fallback per location.
 *
 * Example — override in a child theme:
 *   add_filter( 'whs_frame_elementor_get_location_templates', function( $path, $location ) {
 *       if ( 'header' === $location ) {
 *           return get_stylesheet_directory() . '/template-parts/my-header.php';
 *       }
 *       return $path;
 *   }, 10, 2 );
 *
 * @param  string $location  Location slug ('header' or 'footer').
 * @return string            Absolute path to the fallback template file.
 */
function whs_frame_elementor_get_location_template( $location ) {
	$defaults = [
		'header' => WHS_FRAME_DIR . '/template-parts/default-header.php',
		'footer' => WHS_FRAME_DIR . '/template-parts/default-footer.php',
	];

	$path = $defaults[ $location ] ?? '';

	return apply_filters( 'whs_frame_elementor_get_location_templates', $path, $location );
}

// ─── 6. Disable Conflicting Default Renders ───────────────────────────────────

/**
 * Elementor Pro's Theme Builder, when 'Full Site' display conditions are used,
 * may attempt to inject header/footer output via wp_head/wp_footer hooks directly.
 * We remove those to prevent double output since our system manages rendering
 * through whs_frame_header / whs_frame_footer action hooks.
 */
function whs_frame_disable_elementor_conflicting_renders() {
	if ( ! class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) ) {
		return;
	}

	$module = \ElementorPro\Modules\ThemeBuilder\Module::instance();
	if ( ! $module ) {
		return;
	}

	// Guard: only remove if the method actually exists to prevent fatal errors.
	if ( method_exists( $module, 'render_content' ) ) {
		remove_action( 'wp_head',   [ $module, 'render_content' ], 1 );
		remove_action( 'wp_footer', [ $module, 'render_content' ], 1 );
	}
}
add_action( 'elementor_pro/init', 'whs_frame_disable_elementor_conflicting_renders' );

// ─── 7. CSS Classes on Body and Wrappers ──────────────────────────────────────

/**
 * Add informational body classes when Elementor is active.
 * Useful for CSS targeting and debugging.
 *
 *  whs-frame-elementor-active    — Elementor plugin is active.
 *  whs-frame-elementor-locations — Elementor Pro Theme Location API is available.
 */
function whs_frame_elementor_body_classes( $classes ) {
	if ( ! whs_frame_is_elementor_active() ) {
		return $classes;
	}

	$classes[] = 'whs-frame-elementor-active';

	if ( function_exists( 'elementor_theme_do_location' ) ) {
		$classes[] = 'whs-frame-elementor-locations';
	}

	return $classes;
}
add_filter( 'body_class', 'whs_frame_elementor_body_classes' );

// ─── 8. Enqueue Elementor-Specific Styles ─────────────────────────────────────

/**
 * Normalise Elementor's section/container margins inside our header and footer
 * wrappers to prevent layout shifts. Inlined onto whs-frame-main to avoid an
 * extra HTTP request.
 */
function whs_frame_elementor_enqueue_styles() {
	if ( ! whs_frame_is_elementor_active() ) {
		return;
	}

	$inline_css = '
		#whs-frame-header-wrap .elementor-section-wrap,
		#whs-frame-header-wrap > .elementor,
		.whs-frame-footer-wrap .elementor-section-wrap,
		.whs-frame-footer-wrap > .elementor {
			width: 100%;
			margin: 0;
		}
		#whs-frame-header-wrap .elementor-section,
		.whs-frame-footer-wrap .elementor-section {
			margin-top: 0;
			margin-bottom: 0;
		}
	';

	wp_add_inline_style( 'whs-frame-main', $inline_css );
}
add_action( 'wp_enqueue_scripts', 'whs_frame_elementor_enqueue_styles', 20 );
