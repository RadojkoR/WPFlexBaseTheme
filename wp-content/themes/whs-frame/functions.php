<?php
defined( 'ABSPATH' ) || exit;

// ─── Constants ────────────────────────────────────────────────────────────────
define( 'WHS_FRAME_VERSION', '1.5.0' );
define( 'WHS_FRAME_DIR',     get_template_directory() );
define( 'WHS_FRAME_URI',     get_template_directory_uri() );
define( 'WHS_FRAME_INC',     WHS_FRAME_DIR . '/inc/' );
define( 'WHS_FRAME_ASSETS',  WHS_FRAME_URI . '/assets/' );

// ─── Theme Setup ──────────────────────────────────────────────────────────────
function whs_frame_setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'whs-frame', WHS_FRAME_DIR . '/languages' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails.
	add_theme_support( 'post-thumbnails' );

	// HTML5 markup for core features.
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	] );

	// Custom logo.
	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 250,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// Custom background.
	add_theme_support( 'custom-background' );

	// Custom header.
	add_theme_support( 'custom-header' );

	// Automatic feed links.
	add_theme_support( 'automatic-feed-links' );

	// Wide and full alignment support for the block editor.
	add_theme_support( 'align-wide' );

	// Responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Editor styles.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );

	// Register nav menus.
	register_nav_menus( [
		'primary'   => __( 'Primary Menu',   'whs-frame' ),
		'secondary' => __( 'Secondary Menu', 'whs-frame' ),
		'topbar'    => __( 'Top Bar Menu',   'whs-frame' ),
		'footer'    => __( 'Footer Menu',    'whs-frame' ),
	] );
}
add_action( 'after_setup_theme', 'whs_frame_setup' );

// ─── Content Width ────────────────────────────────────────────────────────────
function whs_frame_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'whs_frame_content_width', 1200 );
}
add_action( 'after_setup_theme', 'whs_frame_content_width', 0 );

// ─── Sample Menu on Activation ───────────────────────────────────────────────
function whs_frame_create_sample_menu() {
	$menu_name     = __( 'Primary Menu', 'whs-frame' );
	$menu_location = 'primary';

	// Do nothing if a menu is already assigned to the primary location.
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations[ $menu_location ] ) ) {
		return;
	}

	// Use existing menu or create a new one.
	$menu = wp_get_nav_menu_object( $menu_name );
	if ( $menu ) {
		$menu_id = $menu->term_id;
	} else {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( is_wp_error( $menu_id ) ) {
			return;
		}
	}

	// Populate only if the menu has no items yet.
	if ( empty( wp_get_nav_menu_items( $menu_id ) ) ) {
		$items = [
			__( 'Home',     'whs-frame' ) => home_url( '/' ),
			__( 'About',    'whs-frame' ) => home_url( '/about/' ),
			__( 'Services', 'whs-frame' ) => home_url( '/services/' ),
			__( 'Contact',  'whs-frame' ) => home_url( '/contact/' ),
		];
		foreach ( $items as $title => $url ) {
			wp_update_nav_menu_item( $menu_id, 0, [
				'menu-item-title'  => $title,
				'menu-item-url'    => $url,
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			] );
		}
	}

	// Assign the menu to the primary location.
	$locations[ $menu_location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
add_action( 'after_switch_theme', 'whs_frame_create_sample_menu' );

// ─── Include /inc/ files ──────────────────────────────────────────────────────
require_once WHS_FRAME_INC . 'admin-settings.php';
require_once WHS_FRAME_INC . 'enqueue.php';
require_once WHS_FRAME_INC . 'css-vars.php';
require_once WHS_FRAME_INC . 'fonts.php';
require_once WHS_FRAME_INC . 'customizer.php';
require_once WHS_FRAME_INC . 'post-settings.php';
require_once WHS_FRAME_INC . 'topbar.php';
require_once WHS_FRAME_INC . 'header-builder.php';
require_once WHS_FRAME_INC . 'elementor-compatibility.php';
require_once WHS_FRAME_INC . 'bricks-compatibility.php';
