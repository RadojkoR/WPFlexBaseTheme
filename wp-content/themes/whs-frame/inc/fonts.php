<?php
defined( 'ABSPATH' ) || exit;

// ─── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Returns font family names that are serif (used to pick the correct generic fallback).
 */
function whs_frame_serif_fonts() {
	return [ 'Playfair Display', 'Merriweather', 'Lora', 'PT Serif', 'Cormorant Garamond', 'Crimson Text', 'DM Serif Display' ];
}

/**
 * Returns a complete font-family stack for a given Google Font name.
 * Appends a suitable generic family so the browser always has a fallback.
 */
function whs_frame_font_stack( $font ) {
	if ( in_array( $font, whs_frame_serif_fonts(), true ) ) {
		return '"' . $font . '", Georgia, "Times New Roman", serif';
	}
	return '"' . $font . '", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
}

/**
 * Builds a Google Fonts CSS2 API URL for the currently selected base and heading fonts.
 * Returns an empty string when both settings are 'inherit' (no external font needed).
 *
 * Single request for up to 2 families: fonts.googleapis.com/css2?family=A&family=B&display=swap
 */
function whs_frame_google_fonts_url() {
	$base    = whs_frame_opt( 'font_base',    'inherit' );
	$heading = whs_frame_opt( 'font_heading', 'inherit' );

	// Collect unique font names that are not the system font.
	$fonts = [];
	if ( 'inherit' !== $base ) {
		$fonts[] = $base;
	}
	if ( 'inherit' !== $heading && ! in_array( $heading, $fonts, true ) ) {
		$fonts[] = $heading;
	}

	if ( empty( $fonts ) ) {
		return '';
	}

	// Build family params: spaces → +, request weights 300–700.
	$families = array_map( function ( $font ) {
		return 'family=' . str_replace( ' ', '+', $font ) . ':wght@300;400;500;600;700';
	}, $fonts );

	return 'https://fonts.googleapis.com/css2?' . implode( '&', $families ) . '&display=swap';
}

// ─── Enqueue ──────────────────────────────────────────────────────────────────

/**
 * Enqueues the Google Fonts stylesheet and injects a small inline style that
 * applies the chosen fonts to body text and headings.
 *
 * Runs at priority 20 (after whs_frame_enqueue_assets at priority 10) so that
 * wp_add_inline_style can attach to the already-registered flexbase-main handle.
 */
function whs_frame_enqueue_google_fonts() {
	$base    = whs_frame_opt( 'font_base',    'inherit' );
	$heading = whs_frame_opt( 'font_heading', 'inherit' );

	$url = whs_frame_google_fonts_url();
	if ( $url ) {
		// null version prevents WordPress from appending ?ver= to the Google Fonts URL.
		wp_enqueue_style( 'flexbase-google-fonts', $url, [ 'flexbase-main' ], null );
	}

	// Build and attach the CSS that wires up the font-family values.
	$css = '';
	if ( 'inherit' !== $base ) {
		$css .= 'body { font-family: ' . whs_frame_font_stack( $base ) . '; }' . "\n";
	}
	if ( 'inherit' !== $heading ) {
		$css .= 'h1, h2, h3, h4, h5, h6 { font-family: ' . whs_frame_font_stack( $heading ) . '; }' . "\n";
	}
	if ( $css ) {
		wp_add_inline_style( 'flexbase-main', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'whs_frame_enqueue_google_fonts', 20 );

// ─── Preconnect hints ─────────────────────────────────────────────────────────

/**
 * Adds preconnect resource hints for the Google Fonts domains.
 * This opens the TCP/TLS connections early, reducing perceived latency
 * for the Google Fonts stylesheet and the actual font files.
 */
function whs_frame_google_fonts_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' !== $relation_type || ! whs_frame_google_fonts_url() ) {
		return $hints;
	}

	$hints[] = [ 'href' => 'https://fonts.googleapis.com' ];
	$hints[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' ];

	return $hints;
}
add_filter( 'wp_resource_hints', 'whs_frame_google_fonts_resource_hints', 10, 2 );
