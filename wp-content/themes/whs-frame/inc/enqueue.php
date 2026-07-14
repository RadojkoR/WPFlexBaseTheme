<?php
defined( 'ABSPATH' ) || exit;


function whs_frame_enqueue_assets() {
	$css = WHS_FRAME_ASSETS . 'css/';
	$js  = WHS_FRAME_ASSETS . 'js/';
	$ver = WHS_FRAME_VERSION;

	// Font Awesome Free 6 — self-hosted (assets/css + assets/webfonts), no external CDN dependency.
	wp_enqueue_style( 'flexbase-fa', $css . 'font-awesome.min.css', [], '6.6.0' );

	// Styles.
	wp_enqueue_style( 'flexbase-main',   $css . 'main.css',   [], $ver );
	wp_enqueue_style( 'flexbase-header', $css . 'header.css', [], $ver );
	wp_enqueue_style( 'flexbase-topbar', $css . 'topbar.css', [], $ver );
	wp_enqueue_style( 'flexbase-sticky', $css . 'sticky.css', [], $ver );
	wp_enqueue_style( 'flexbase-footer', $css . 'footer.css', [], $ver );

	// Scripts (vanilla JS, no jQuery dependency).
	wp_enqueue_script( 'flexbase-main',   $js . 'main.js',   [], $ver, true );
	wp_enqueue_script( 'flexbase-sticky', $js . 'sticky.js', [], $ver, true );
	wp_enqueue_script( 'flexbase-topbar', $js . 'topbar.js', [], $ver, true );
}
add_action( 'wp_enqueue_scripts', 'whs_frame_enqueue_assets', 20 );
