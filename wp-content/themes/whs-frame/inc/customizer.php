<?php
defined( 'ABSPATH' ) || exit;

// ─── Sanitization Helpers ─────────────────────────────────────────────────────

function whs_frame_sanitize_checkbox( $value ) {
	return (bool) $value;
}

// ─── Google Fonts List ────────────────────────────────────────────────────────

function whs_frame_google_fonts_list() {
	return [
		'inherit'           => __( 'Theme Default (System)', 'whs-frame' ),
		// Sans-serif
		'Inter'             => 'Inter',
		'Poppins'           => 'Poppins',
		'Montserrat'        => 'Montserrat',
		// Serif
		'Playfair Display'  => 'Playfair Display',
		'Merriweather'      => 'Merriweather',
		'Lora'              => 'Lora',
	];
}

// ─── Customizer Registration ──────────────────────────────────────────────────

function whs_frame_main_customizer( $wp_customize ) {

	$panel = 'whs_frame_main_panel';

	$wp_customize->add_panel( $panel, [
		'title'    => __( 'WHS Frame Theme', 'whs-frame' ),
		'priority' => 20,
	] );

	// ─────────────────────────────────────────────────────────────────────────
	// 1. TOP BAR — structural controls only
	// ─────────────────────────────────────────────────────────────────────────

	$wp_customize->add_section( 'whs_frame_main_topbar', [
		'title'    => __( 'Top Bar', 'whs-frame' ),
		'panel'    => $panel,
		'priority' => 10,
	] );

	$wp_customize->add_setting( 'whs_frame_topbar_enable', [
		'default'           => true,
		'sanitize_callback' => 'whs_frame_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'whs_frame_topbar_enable', [
		'label'   => __( 'Enable Top Bar', 'whs-frame' ),
		'section' => 'whs_frame_main_topbar',
		'type'    => 'checkbox',
	] );

	$wp_customize->add_setting( 'whs_frame_topbar_hide_mobile', [
		'default'           => false,
		'sanitize_callback' => 'whs_frame_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'whs_frame_topbar_hide_mobile', [
		'label'   => __( 'Hide on Mobile', 'whs-frame' ),
		'section' => 'whs_frame_main_topbar',
		'type'    => 'checkbox',
	] );

	$wp_customize->add_setting( 'whs_frame_topbar_dismissible', [
		'default'           => false,
		'sanitize_callback' => 'whs_frame_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'whs_frame_topbar_dismissible', [
		'label'       => __( 'Dismissible', 'whs-frame' ),
		'description' => __( 'Show a close button. Dismissed state saved in localStorage.', 'whs-frame' ),
		'section'     => 'whs_frame_main_topbar',
		'type'        => 'checkbox',
	] );

	// Column type selectors (layout/structure — stay here for live preview)
	$content_types = [
		'none'         => __( 'None', 'whs-frame' ),
		'email'        => __( 'Email', 'whs-frame' ),
		'phone'        => __( 'Phone', 'whs-frame' ),
		'email_phone'  => __( 'Email + Phone', 'whs-frame' ),
		'social_icons' => __( 'Social Icons', 'whs-frame' ),
		'custom_text'  => __( 'Custom Text', 'whs-frame' ),
	];

	$columns = [
		'left'   => [ 'label' => __( 'Left Column', 'whs-frame' ),   'default' => 'email' ],
		'center' => [ 'label' => __( 'Center Column', 'whs-frame' ), 'default' => 'none' ],
		'right'  => [ 'label' => __( 'Right Column', 'whs-frame' ),  'default' => 'social_icons' ],
	];

	foreach ( $columns as $col => $col_args ) {
		$wp_customize->add_setting( "whs_frame_topbar_{$col}_type", [
			'default'           => $col_args['default'],
			'sanitize_callback' => 'sanitize_key',
		] );
		$wp_customize->add_control( "whs_frame_topbar_{$col}_type", [
			'label'   => $col_args['label'],
			'section' => 'whs_frame_main_topbar',
			'type'    => 'select',
			'choices' => $content_types,
		] );
	}

	// ─────────────────────────────────────────────────────────────────────────
	// 2. HEADER — structural + logo controls only
	// ─────────────────────────────────────────────────────────────────────────

	$wp_customize->add_section( 'whs_frame_main_header', [
		'title'    => __( 'Header', 'whs-frame' ),
		'panel'    => $panel,
		'priority' => 20,
	] );

	$wp_customize->add_setting( 'whs_frame_header_sticky', [
		'default'           => 'none',
		'sanitize_callback' => 'sanitize_key',
	] );
	$wp_customize->add_control( 'whs_frame_header_sticky', [
		'label'   => __( 'Sticky Mode', 'whs-frame' ),
		'section' => 'whs_frame_main_header',
		'type'    => 'select',
		'choices' => [
			'none'      => __( 'Not Sticky', 'whs-frame' ),
			'always'    => __( 'Always Sticky', 'whs-frame' ),
			'scroll_up' => __( 'Sticky on Scroll Up Only', 'whs-frame' ),
		],
	] );

	$wp_customize->add_setting( 'whs_frame_header_transparent', [
		'default'           => false,
		'sanitize_callback' => 'whs_frame_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'whs_frame_header_transparent', [
		'label'       => __( 'Transparent Header', 'whs-frame' ),
		'description' => __( 'Transparent at page top, solid on scroll.', 'whs-frame' ),
		'section'     => 'whs_frame_main_header',
		'type'        => 'checkbox',
	] );

	// 'custom_logo' setting is registered by core (Site Identity) — re-registering it
	// here would drop core's postMessage transport and selective refresh. This extra
	// control simply exposes the same setting inside the WHS Frame Header section.
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'whs_frame_logo', [
		'settings'    => 'custom_logo',
		'label'       => __( 'Logo', 'whs-frame' ),
		'description' => __( 'Recommended size: 250 × 80 px.', 'whs-frame' ),
		'section'     => 'whs_frame_main_header',
		'width'       => 250,
		'height'      => 80,
		'flex_width'  => true,
		'flex_height' => true,
	] ) );

	$wp_customize->add_setting( 'whs_frame_mobile_menu_logo', [
		'default'           => true,
		'sanitize_callback' => 'whs_frame_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'whs_frame_mobile_menu_logo', [
		'label'       => __( 'Show Logo in Mobile Menu', 'whs-frame' ),
		'description' => __( 'Displays the site logo at the top of the mobile menu panel.', 'whs-frame' ),
		'section'     => 'whs_frame_main_header',
		'type'        => 'checkbox',
	] );

	// ─────────────────────────────────────────────────────────────────────────
	// 3. FOOTER — logo only (all other settings moved to admin panel)
	// ─────────────────────────────────────────────────────────────────────────

	// ─────────────────────────────────────────────────────────────────────────
	// 2b. SIDEBAR
	// ─────────────────────────────────────────────────────────────────────────

	$wp_customize->add_section( 'whs_frame_main_sidebar', [
		'title'    => __( 'Sidebar', 'whs-frame' ),
		'panel'    => $panel,
		'priority' => 25,
	] );

	$wp_customize->add_setting( 'whs_frame_sidebar_position', [
		'default'           => 'none',
		'sanitize_callback' => function ( $value ) {
			return in_array( $value, [ 'none', 'left', 'right' ], true ) ? $value : 'none';
		},
	] );
	$wp_customize->add_control( 'whs_frame_sidebar_position', [
		'label'       => __( 'Sidebar Position', 'whs-frame' ),
		'description' => __( 'Applies to single posts and pages. Only shows if the Blog Sidebar widget area has widgets (Appearance → Widgets). Can be overridden per post/page.', 'whs-frame' ),
		'section'     => 'whs_frame_main_sidebar',
		'type'        => 'select',
		'choices'     => [
			'none'  => __( 'No Sidebar', 'whs-frame' ),
			'left'  => __( 'Left Sidebar', 'whs-frame' ),
			'right' => __( 'Right Sidebar', 'whs-frame' ),
		],
	] );

	$wp_customize->add_section( 'whs_frame_main_footer', [
		'title'    => __( 'Footer', 'whs-frame' ),
		'panel'    => $panel,
		'priority' => 30,
	] );

	$wp_customize->add_setting( 'whs_frame_footer_logo', [
		'default'           => 0,
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'whs_frame_footer_logo', [
		'label'       => __( 'Footer Logo', 'whs-frame' ),
		'description' => __( 'Separate logo for the footer. Falls back to the header logo.', 'whs-frame' ),
		'section'     => 'whs_frame_main_footer',
		'mime_type'   => 'image',
	] ) );
}
add_action( 'customize_register', 'whs_frame_main_customizer' );
