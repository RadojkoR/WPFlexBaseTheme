<?php
defined( 'ABSPATH' ) || exit;

function flexbase_enqueue_assets() {
	$css = FLEXBASE_ASSETS . 'css/';
	$js  = FLEXBASE_ASSETS . 'js/';
	$ver = FLEXBASE_VERSION;

	// Styles.
	wp_enqueue_style( 'flexbase-main',   $css . 'main.css',   [], $ver );
	wp_enqueue_style( 'flexbase-header', $css . 'header.css', [], $ver );
	wp_enqueue_style( 'flexbase-topbar', $css . 'topbar.css', [], $ver );
	wp_enqueue_style( 'flexbase-sticky', $css . 'sticky.css', [], $ver );

	// Scripts (vanilla JS, no jQuery dependency).
	wp_enqueue_script( 'flexbase-main',   $js . 'main.js',   [], $ver, true );
	wp_enqueue_script( 'flexbase-sticky', $js . 'sticky.js', [], $ver, true );
	wp_enqueue_script( 'flexbase-topbar', $js . 'topbar.js', [], $ver, true );
}
add_action( 'wp_enqueue_scripts', 'flexbase_enqueue_assets' );
