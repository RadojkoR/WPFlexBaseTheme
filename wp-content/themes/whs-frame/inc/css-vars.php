<?php
defined( 'ABSPATH' ) || exit;

function whs_frame_output_css_vars() {
	$primary    = sanitize_hex_color( whs_frame_opt( 'color_primary',    '#6366f1' ) ) ?: '#6366f1';
	$secondary  = sanitize_hex_color( whs_frame_opt( 'color_secondary',  '#8b5cf6' ) ) ?: '#8b5cf6';
	$background = sanitize_hex_color( whs_frame_opt( 'color_background', '#ffffff' ) ) ?: '#ffffff';
	$text       = sanitize_hex_color( whs_frame_opt( 'color_text',       '#1e1e2e' ) ) ?: '#1e1e2e';
	$width      = max( 600, min( 2560, absint( whs_frame_opt( 'container_width', 1200 ) ) ) );
	$header_bg           = sanitize_hex_color( whs_frame_opt( 'header_bg_color',           '#ffffff' ) ) ?: '#ffffff';
	$header_txt          = sanitize_hex_color( whs_frame_opt( 'header_text_color',          '#1e1e2e' ) ) ?: '#1e1e2e';
	$header_nav          = sanitize_hex_color( whs_frame_opt( 'header_nav_color',           '#1e1e2e' ) ) ?: '#1e1e2e';
	$transp_text         = sanitize_hex_color( whs_frame_opt( 'header_transparent_text',    '#ffffff' ) ) ?: '#ffffff';
	$transp_hover        = sanitize_hex_color( whs_frame_opt( 'header_transparent_hover',   '#ffffff' ) ) ?: '#ffffff';
	$transp_active       = sanitize_hex_color( whs_frame_opt( 'header_transparent_active',  '#ffffff' ) ) ?: '#ffffff';
	$nav_hover           = sanitize_hex_color( whs_frame_opt( 'header_nav_hover',           '#6366f1' ) ) ?: '#6366f1';
	$nav_active          = sanitize_hex_color( whs_frame_opt( 'header_nav_active',          '#6366f1' ) ) ?: '#6366f1';
	$nav_text_transform  = whs_frame_opt( 'header_nav_text_transform', 'none' );
	$nav_font_weight     = absint( whs_frame_opt( 'header_nav_font_weight', 400 ) );

	// Login button
	$login_bg            = sanitize_hex_color( whs_frame_opt( 'nav_login_button_bg_color',           '#6366f1' ) ) ?: '#6366f1';
	$login_transparent   = (bool) whs_frame_opt( 'nav_login_button_bg_transparent', false );
	$login_text          = sanitize_hex_color( whs_frame_opt( 'nav_login_button_text_color',         '#ffffff' ) ) ?: '#ffffff';
	$login_border        = sanitize_hex_color( whs_frame_opt( 'nav_login_button_border_color',       '#6366f1' ) ) ?: '#6366f1';
	$login_border_width  = absint( whs_frame_opt( 'nav_login_button_border_width', 0 ) );
	$login_border_radius = absint( whs_frame_opt( 'nav_login_button_border_radius', 6 ) );
	$login_width         = whs_frame_sanitize_css_dimension( whs_frame_opt( 'nav_login_button_width',   'auto' ), 'auto' );
	$login_height        = whs_frame_sanitize_css_dimension( whs_frame_opt( 'nav_login_button_height',  'auto' ), 'auto' );
	$login_padding       = whs_frame_sanitize_css_shorthand( whs_frame_opt( 'nav_login_button_padding', '0' ),    '0' );
	$login_hover_transparent = (bool) whs_frame_opt( 'nav_login_button_hover_bg_transparent', false );
	$login_hover_bg      = sanitize_hex_color( whs_frame_opt( 'nav_login_button_hover_bg_color',     '#4f46e5' ) ) ?: '#4f46e5';
	$login_hover_text    = sanitize_hex_color( whs_frame_opt( 'nav_login_button_hover_text_color',   '#ffffff' ) ) ?: '#ffffff';
	$login_hover_border  = sanitize_hex_color( whs_frame_opt( 'nav_login_button_hover_border_color', '#4f46e5' ) ) ?: '#4f46e5';

	// Signup button
	$signup_bg            = sanitize_hex_color( whs_frame_opt( 'nav_signup_button_bg_color',           '#8b5cf6' ) ) ?: '#8b5cf6';
	$signup_transparent   = (bool) whs_frame_opt( 'nav_signup_button_bg_transparent', false );
	$signup_text          = sanitize_hex_color( whs_frame_opt( 'nav_signup_button_text_color',         '#ffffff' ) ) ?: '#ffffff';
	$signup_border        = sanitize_hex_color( whs_frame_opt( 'nav_signup_button_border_color',       '#8b5cf6' ) ) ?: '#8b5cf6';
	$signup_border_width  = absint( whs_frame_opt( 'nav_signup_button_border_width', 0 ) );
	$signup_border_radius = absint( whs_frame_opt( 'nav_signup_button_border_radius', 6 ) );
	$signup_width         = whs_frame_sanitize_css_dimension( whs_frame_opt( 'nav_signup_button_width',   'auto' ), 'auto' );
	$signup_height        = whs_frame_sanitize_css_dimension( whs_frame_opt( 'nav_signup_button_height',  'auto' ), 'auto' );
	$signup_padding       = whs_frame_sanitize_css_shorthand( whs_frame_opt( 'nav_signup_button_padding', '0' ),    '0' );
	$signup_hover_transparent = (bool) whs_frame_opt( 'nav_signup_button_hover_bg_transparent', false );
	$signup_hover_bg      = sanitize_hex_color( whs_frame_opt( 'nav_signup_button_hover_bg_color',     '#7c3aed' ) ) ?: '#7c3aed';
	$signup_hover_text    = sanitize_hex_color( whs_frame_opt( 'nav_signup_button_hover_text_color',   '#ffffff' ) ) ?: '#ffffff';
	$signup_hover_border  = sanitize_hex_color( whs_frame_opt( 'nav_signup_button_hover_border_color', '#7c3aed' ) ) ?: '#7c3aed';

	$css = ":root {\n"
		. "\t--whs-frame-color-primary:        {$primary};\n"
		. "\t--whs-frame-color-secondary:      {$secondary};\n"
		. "\t--whs-frame-color-background:     {$background};\n"
		. "\t--whs-frame-color-text:           {$text};\n"
		. "\t--whs-frame-container-width:      {$width}px;\n"
		. "\t--whs-frame-header-bg:            {$header_bg};\n"
		. "\t--whs-frame-header-text:          {$header_txt};\n"
		. "\t--whs-frame-header-nav:           {$header_nav};\n"
		. "\t--whs-frame-transp-text:          {$transp_text};\n"
		. "\t--whs-frame-transp-hover:         {$transp_hover};\n"
		. "\t--whs-frame-transp-active:        {$transp_active};\n"
		. "\t--whs-frame-nav-hover:            {$nav_hover};\n"
		. "\t--whs-frame-nav-active:           {$nav_active};\n"
		. "\t--whs-frame-nav-transform:        {$nav_text_transform};\n"
		. "\t--whs-frame-nav-weight:           {$nav_font_weight};\n"
		. "\t--login-bg:                      " . ( $login_transparent ? 'transparent' : $login_bg ) . ";\n"
		. "\t--login-text:                    {$login_text};\n"
		. "\t--login-border-color:            {$login_border};\n"
		. "\t--login-bd-size:                 {$login_border_width}px;\n"
		. "\t--login-border-radius:           {$login_border_radius}px;\n"
		. "\t--login-width:                   {$login_width};\n"
		. "\t--login-height:                  {$login_height};\n"
		. "\t--login-padding:                 {$login_padding};\n"
		. "\t--login-hover-bg:                " . ( $login_hover_transparent ? 'transparent' : $login_hover_bg ) . ";\n"
		. "\t--login-hover-text:              {$login_hover_text};\n"
		. "\t--login-hover-border:            {$login_hover_border};\n"
		. "\t--signup-bg:                     " . ( $signup_transparent ? 'transparent' : $signup_bg ) . ";\n"
		. "\t--signup-text:                   {$signup_text};\n"
		. "\t--signup-border-color:           {$signup_border};\n"
		. "\t--signup-bd-size:                {$signup_border_width}px;\n"
		. "\t--signup-border-radius:          {$signup_border_radius}px;\n"
		. "\t--signup-width:                  {$signup_width};\n"
		. "\t--signup-height:                 {$signup_height};\n"
		. "\t--signup-padding:                {$signup_padding};\n"
		. "\t--signup-hover-bg:               " . ( $signup_hover_transparent ? 'transparent' : $signup_hover_bg ) . ";\n"
		. "\t--signup-hover-text:             {$signup_hover_text};\n"
		. "\t--signup-hover-border:           {$signup_hover_border};\n"
		. '}';

	wp_add_inline_style( 'whs-frame-main', $css );
}
add_action( 'wp_enqueue_scripts', 'whs_frame_output_css_vars', 25 );
