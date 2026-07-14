<?php
defined( 'ABSPATH' ) || exit;

// ─── Defaults ─────────────────────────────────────────────────────────────────

/**
 * Returns the full array of default values for all FlexBase settings.
 *
 * @return array
 */
function whs_frame_settings_defaults() {
	return [
		// General / Colors
		'color_primary'           => '#0d9488',
		'color_secondary'         => '#0ea5e9',
		'color_background'        => '#f0fdfa',
		'color_text'              => '#134e4a',

		// General / Typography
		'font_base'               => 'inherit',
		'font_heading'            => 'inherit',

		// General / Layout
		'container_width'         => 1200,

		// Header
		'header_bg_color'              => '#f0fdfa',
		'header_text_color'            => '#134e4a',
		'header_nav_color'             => '#134e4a',
		'header_transparent_text'      => '#134e4a',
		'header_transparent_hover'     => '#0d9488',
		'header_transparent_active'    => '#0ea5e9',
		'header_nav_hover'             => '#0d9488',
		'header_nav_active'            => '#0ea5e9',
		'header_nav_text_transform'    => 'none',
		'header_nav_font_weight'       => 400,

		// Navigation / Login & Signup
		'nav_login_enable'            => true,
		'nav_login_label'             => 'Login',
		'nav_login_url'               => '',
		'nav_logout_url'              => '',
		'nav_signup_enable'           => true,
		'nav_signup_label'            => 'Sign Up',
		'nav_signup_url'              => '',
		'nav_button_style'            => 'button',

		// Navigation / Login Button Styling
		'nav_login_button_bg_color'           => '#ffffff',
		'nav_login_button_bg_transparent'     => true,
		'nav_login_button_text_color'         => '#0d9488',
		'nav_login_button_border_color'       => '#0d9488',
		'nav_login_button_border_width'       => 1,
		'nav_login_button_border_radius'      => 6,
		'nav_login_button_width'              => '120px',
		'nav_login_button_height'             => '40px',
		'nav_login_button_padding'            => '0',
		'nav_login_button_hover_bg_color'     => '#0d9488',
		'nav_login_button_hover_bg_transparent' => false,
		'nav_login_button_hover_text_color'   => '#ffffff',
		'nav_login_button_hover_border_color' => '#0d9488',

		// Navigation / Signup Button Styling
		'nav_signup_button_bg_color'          => '#0d9488',
		'nav_signup_button_bg_transparent'    => false,
		'nav_signup_button_text_color'        => '#ffffff',
		'nav_signup_button_border_color'      => '#0d9488',
		'nav_signup_button_border_width'      => 1,
		'nav_signup_button_border_radius'     => 6,
		'nav_signup_button_width'             => '120px',
		'nav_signup_button_height'            => '40px',
		'nav_signup_button_padding'           => '0',
		'nav_signup_button_hover_bg_color'    => '#0f766e',
		'nav_signup_button_hover_bg_transparent' => false,
		'nav_signup_button_hover_text_color'  => '#ffffff',
		'nav_signup_button_hover_border_color' => '#0f766e',

		// Navigation / Language Switcher
		'nav_language_switcher_enable' => false,
		'nav_language_switcher_flags'  => true,
		'nav_language_switcher_name'   => true,
		'nav_language_switcher_code'   => false,

		// Mobile Menu colors
		'mobile_menu_bg_color'         => '#ffffff',
		'mobile_menu_text_color'       => '#134e4a',
		'mobile_menu_link_hover'       => '#0d9488',
		'mobile_menu_active_bg'        => '#f0fdfa',
		'mobile_menu_active_text'      => '#0d9488',

		// Mobile Close Button
		'mobile_close_bg_color'        => '#ffffff',
		'mobile_close_icon_color'      => '#134e4a',
		'mobile_close_border_color'    => '#d1d5db',
		'mobile_close_border_width'    => 1,
		'mobile_close_border_radius'   => 8,

		// Top Bar colors
		'topbar_bg_color'         => '#0d9488',
		'topbar_text_color'       => '#ffffff',
		'topbar_link_color'       => '#ccfbf1',

		// Top Bar columns
		'topbar_left_email'       => '',
		'topbar_left_phone'       => '',
		'topbar_left_text'        => '',
		'topbar_center_email'     => '',
		'topbar_center_phone'     => '',
		'topbar_center_text'      => '',
		'topbar_right_email'      => '',
		'topbar_right_phone'      => '',
		'topbar_right_text'       => '',

		// Footer colors
		'footer_bg_color'         => '#f0fdfa',
		'footer_text_color'       => '#134e4a',
		'footer_link_color'       => '#0d9488',
		'footer_link_hover_color' => '#6366f1',
		'footer_address_color'    => '#6b7280',
		'footer_heading_color'    => '#134e4a',
		'footer_social_icon_color' => '#374151',
		'footer_social_hover_color' => '#0d9488',
		'footer_social_icon_bg_color' => 'transparent',
		'footer_social_icon_bg_hover_color' => 'transparent',
		'footer_social_icon_border_color' => '#d1d5db',
		'footer_social_icon_border_hover_color' => '#0d9488',
		'footer_social_icon_border_width' => 1,
		'footer_social_icon_border_radius' => 8,
		'footer_copyright_text_color' => '#6b7280',

		// Footer content
		'footer_address'          => '',
		'footer_email'            => '',
		'footer_phone'            => '',
		'footer_copyright'        => '',
		'footer_powered_by_text'  => '',
		'footer_powered_by_url'   => '',
		'footer_powered_by_color' => '#6b7280',

		// Footer contact icons & colors
		'footer_contact_address_map_url'       => '',
		'footer_contact_address_icon'          => 'fa-solid fa-location-dot',
		'footer_contact_address_icon_color'    => '#134e4a',
		'footer_contact_address_link_color'    => '#134e4a',
		'footer_contact_address_hover_color'   => '#0d9488',
		'footer_contact_email_1'               => '',
		'footer_contact_email_2'               => '',
		'footer_contact_email_icon_color'      => '#134e4a',
		'footer_contact_email_hover_color'     => '#0d9488',
		'footer_contact_phone_1'               => '',
		'footer_contact_phone_2'               => '',
		'footer_contact_phone_icon_color'      => '#134e4a',
		'footer_contact_phone_hover_color'     => '#0d9488',

		// Social — Top Bar URLs
		'topbar_social_facebook'  => '',
		'topbar_social_instagram' => '',
		'topbar_social_twitter'   => '',
		'topbar_social_linkedin'  => '',
		'topbar_social_youtube'   => '',
		'topbar_social_tiktok'    => '',

		// Social — Footer URLs
		'footer_social_facebook'  => '',
		'footer_social_instagram' => '',
		'footer_social_twitter'   => '',
		'footer_social_linkedin'  => '',
		'footer_social_youtube'   => '',
		'footer_social_tiktok'    => '',

		// Social — Icon classes (shared between topbar and footer)
		'social_facebook_icon'    => 'fa-brands fa-facebook-f',
		'social_instagram_icon'   => 'fa-brands fa-instagram',
		'social_twitter_icon'     => 'fa-brands fa-x-twitter',
		'social_linkedin_icon'    => 'fa-brands fa-linkedin-in',
		'social_youtube_icon'     => 'fa-brands fa-youtube',
		'social_tiktok_icon'      => 'fa-brands fa-tiktok',
	];
}

// ─── Get All Settings ─────────────────────────────────────────────────────────

/**
 * Returns all FlexBase settings merged with defaults.
 * Uses static cache so the DB is only hit once per request.
 * Pass $refresh = true to invalidate the cache and re-read from the DB.
 *
 * @param  bool $refresh Force a fresh DB read.
 * @return array
 */
function whs_frame_get_all_settings( $refresh = false ) {
	static $cache = null;

	if ( null === $cache || $refresh ) {
		$saved = get_option( 'whs_frame_settings', [] );
		$cache = array_merge( whs_frame_settings_defaults(), (array) $saved );
	}

	return $cache;
}

// ─── CSS Value Sanitization Helpers ──────────────────────────────────────────

/**
 * Validates a single CSS dimension value.
 * Allows: auto, 0, or values like 120px, 1.5rem, 50%, etc.
 *
 * @param  string $value   Raw input value.
 * @param  string $default Fallback when validation fails.
 * @return string
 */
function whs_frame_sanitize_css_dimension( $value, $default = 'auto' ) {
	$value = sanitize_text_field( $value );
	if ( preg_match( '/^(auto|0|(\d+(\.\d+)?(px|rem|em|%|vh|vw)))$/', $value ) ) {
		return $value;
	}
	return $default;
}

/**
 * Validates a CSS shorthand value (e.g. padding: "0.5rem 1rem").
 * Each whitespace-separated part must be a valid dimension or 0.
 *
 * @param  string $value   Raw input value.
 * @param  string $default Fallback when validation fails.
 * @return string
 */
function whs_frame_sanitize_css_shorthand( $value, $default = '0' ) {
	$value = sanitize_text_field( $value );
	$parts = preg_split( '/\s+/', trim( $value ) );
	foreach ( $parts as $part ) {
		if ( ! preg_match( '/^(auto|0|(\d+(\.\d+)?(px|rem|em|%)))$/', $part ) ) {
			return $default;
		}
	}
	return ! empty( $parts ) ? implode( ' ', $parts ) : $default;
}

/**
 * Reads a color setting and returns a value that is always safe and valid in CSS:
 * a sanitized hex color, the literal 'transparent', or the given default.
 * Prevents empty custom-property values (e.g. "--x:;") that sanitize_hex_color()
 * alone would produce for the allowed 'transparent' value.
 *
 * @param  string $key     Setting key.
 * @param  string $default Fallback color when the stored value is invalid.
 * @return string
 */
function whs_frame_css_color( $key, $default ) {
	$value = whs_frame_opt( $key, $default );
	if ( 'transparent' === $value ) {
		return 'transparent';
	}
	$hex = sanitize_hex_color( (string) $value );
	return $hex ? $hex : $default;
}

// ─── Sanitize Settings ────────────────────────────────────────────────────────

/**
 * Sanitizes an array of incoming settings data.
 *
 * @param  array $data Raw input array.
 * @return array       Sanitized array (only known keys retained).
 */
function whs_frame_sanitize_settings( array $data ) {
	$defaults = whs_frame_settings_defaults();
	$clean    = [];

	// Fields sanitized as hex colors
	$hex_fields = [
		'color_primary', 'color_secondary', 'color_background', 'color_text',
		'header_bg_color', 'header_text_color', 'header_nav_color',
		'header_transparent_text', 'header_transparent_hover', 'header_transparent_active',
		'header_nav_hover', 'header_nav_active',
		'topbar_bg_color', 'topbar_text_color', 'topbar_link_color',
		'footer_bg_color', 'footer_text_color', 'footer_link_color', 'footer_link_hover_color',
		'footer_address_color', 'footer_heading_color',
		'footer_social_icon_color', 'footer_social_hover_color',
		'footer_social_icon_bg_color', 'footer_social_icon_bg_hover_color',
		'footer_social_icon_border_color', 'footer_social_icon_border_hover_color',
		'footer_copyright_text_color',
		'footer_powered_by_color',
		'footer_contact_address_icon_color', 'footer_contact_address_link_color', 'footer_contact_address_hover_color',
		'footer_contact_email_icon_color', 'footer_contact_email_hover_color',
		'footer_contact_phone_icon_color', 'footer_contact_phone_hover_color',
		'nav_login_button_bg_color', 'nav_login_button_text_color', 'nav_login_button_border_color',
		'nav_login_button_hover_bg_color', 'nav_login_button_hover_text_color', 'nav_login_button_hover_border_color',
		'nav_signup_button_bg_color', 'nav_signup_button_text_color', 'nav_signup_button_border_color',
		'nav_signup_button_hover_bg_color', 'nav_signup_button_hover_text_color', 'nav_signup_button_hover_border_color',
		'mobile_menu_bg_color', 'mobile_menu_text_color', 'mobile_menu_link_hover',
		'mobile_menu_active_bg', 'mobile_menu_active_text',
		'mobile_close_bg_color', 'mobile_close_icon_color', 'mobile_close_border_color',
	];

	// Fields sanitized as URLs
	$url_fields = [
		'topbar_social_facebook', 'topbar_social_instagram', 'topbar_social_twitter',
		'topbar_social_linkedin', 'topbar_social_youtube', 'topbar_social_tiktok',
		'footer_social_facebook', 'footer_social_instagram', 'footer_social_twitter',
		'footer_social_linkedin', 'footer_social_youtube', 'footer_social_tiktok',
		'nav_login_url', 'nav_logout_url', 'nav_signup_url',
		'footer_contact_address_map_url',
		'footer_powered_by_url',
	];

	foreach ( $defaults as $key => $default_value ) {
		if ( ! array_key_exists( $key, $data ) ) {
			continue;
		}

		$value = $data[ $key ];

		if ( in_array( $key, $hex_fields, true ) ) {
			// Sanitize hex color: allow only valid hex strings (or 'transparent')
			if ( 'transparent' === $value ) {
				$value = 'transparent';
			} else {
				$value = sanitize_hex_color( $value );
				if ( null === $value ) {
					$value = $default_value;
				}
			}
		} elseif ( in_array( $key, $url_fields, true ) ) {
			$value = esc_url_raw( $value );
		} elseif ( 'container_width' === $key ) {
			$value = absint( $value );
			if ( $value < 600 || $value > 2560 ) {
				$value = 1200;
			}
		} elseif ( 'header_nav_font_weight' === $key ) {
			$value = absint( $value );
			// Allow only 100-900 in steps of 100
			if ( ! in_array( $value, [ 100, 200, 300, 400, 500, 600, 700, 800, 900 ], true ) ) {
				$value = 400;
			}
		} elseif ( 'header_nav_text_transform' === $key ) {
			$allowed = [ 'none', 'uppercase', 'lowercase', 'capitalize' ];
			if ( ! in_array( $value, $allowed, true ) ) {
				$value = 'none';
			}
		} elseif ( 'footer_email' === $key ) {
			$value = sanitize_email( $value );
		} elseif ( in_array( $key, [ 'footer_contact_email_1', 'footer_contact_email_2' ], true ) ) {
			$value = sanitize_email( $value );
		} elseif ( in_array( $key, [ 'footer_contact_phone_1', 'footer_contact_phone_2' ], true ) ) {
			$value = sanitize_text_field( $value );
		} elseif ( in_array( $key, [
			'topbar_left_text', 'topbar_center_text', 'topbar_right_text',
			'footer_address', 'footer_copyright',
		], true ) ) {
			// Rendered through wp_kses_post() — allow safe HTML and keep line breaks
			// (sanitize_text_field would strip the newlines nl2br() relies on).
			$value = wp_kses_post( $value );
		} elseif ( in_array( $key, [
			'nav_login_enable', 'nav_signup_enable',
			'nav_login_button_bg_transparent', 'nav_login_button_hover_bg_transparent',
			'nav_signup_button_bg_transparent', 'nav_signup_button_hover_bg_transparent',
			'nav_language_switcher_enable', 'nav_language_switcher_flags',
			'nav_language_switcher_name', 'nav_language_switcher_code',
		], true ) ) {
			$value = (bool) $value;
		} elseif ( 'nav_button_style' === $key ) {
			$allowed = [ 'link', 'button' ];
			if ( ! in_array( $value, $allowed, true ) ) {
				$value = 'link';
			}
		} elseif ( in_array( $key, [ 'nav_login_button_border_width', 'nav_signup_button_border_width' ], true ) ) {
			$value = absint( $value );
			if ( $value > 10 ) {
				$value = 0;
			}
		} elseif ( in_array( $key, [ 'nav_login_button_border_radius', 'nav_signup_button_border_radius' ], true ) ) {
			$value = absint( $value );
			if ( $value > 50 ) {
				$value = 6;
			}
		} elseif ( 'footer_social_icon_border_width' === $key ) {
			$value = absint( $value );
			if ( $value > 10 ) {
				$value = 0;
			}
		} elseif ( 'footer_social_icon_border_radius' === $key ) {
			$value = absint( $value );
			if ( $value > 50 ) {
				$value = 8;
			}
		} elseif ( 'mobile_close_border_width' === $key ) {
			$value = absint( $value );
			if ( $value > 10 ) {
				$value = 0;
			}
		} elseif ( 'mobile_close_border_radius' === $key ) {
			$value = absint( $value );
			if ( $value > 50 ) {
				$value = 8;
			}
		} elseif ( in_array( $key, [
			'nav_login_button_width', 'nav_login_button_height',
			'nav_signup_button_width', 'nav_signup_button_height',
		], true ) ) {
			$value = whs_frame_sanitize_css_dimension( $value, 'auto' );
		} elseif ( in_array( $key, [
			'nav_login_button_padding', 'nav_signup_button_padding',
		], true ) ) {
			$value = whs_frame_sanitize_css_shorthand( $value, '0' );
		} else {
			// Covers: fonts, phone, address, copyright, text columns, icon classes, labels
			$value = sanitize_text_field( $value );
		}

		$clean[ $key ] = $value;
	}

	return $clean;
}

// ─── Helper: Read Single Option ───────────────────────────────────────────────

/**
 * Read a single FlexBase setting by key.
 *
 * @param  string $key     Setting key.
 * @param  mixed  $default Fallback value when key does not exist.
 * @return mixed
 */
function whs_frame_opt( $key, $default = '' ) {
	$settings = whs_frame_get_all_settings();
	return array_key_exists( $key, $settings ) ? $settings[ $key ] : $default;
}

// ─── Customizer-Mirrored Settings (theme mods) ───────────────────────────────

/**
 * Structural settings that live as theme_mods (so the Customizer keeps live
 * preview) but are also exposed in the FlexBase Settings panel. Both UIs read
 * and write the same theme_mod — a single source of truth.
 * Maps the REST/JS key to its theme_mod name, value type and default.
 *
 * @return array
 */
function whs_frame_mirror_fields() {
	return [
		// Top Bar structure
		'topbar_enable'             => [ 'mod' => 'whs_frame_topbar_enable',             'type' => 'bool',     'default' => true ],
		'topbar_hide_mobile'        => [ 'mod' => 'whs_frame_topbar_hide_mobile',        'type' => 'bool',     'default' => false ],
		'topbar_dismissible'        => [ 'mod' => 'whs_frame_topbar_dismissible',        'type' => 'bool',     'default' => false ],
		'topbar_left_type'          => [ 'mod' => 'whs_frame_topbar_left_type',          'type' => 'col_type', 'default' => 'email' ],
		'topbar_center_type'        => [ 'mod' => 'whs_frame_topbar_center_type',        'type' => 'col_type', 'default' => 'none' ],
		'topbar_right_type'         => [ 'mod' => 'whs_frame_topbar_right_type',         'type' => 'col_type', 'default' => 'social_icons' ],
		// Header structure
		'header_sticky'             => [ 'mod' => 'whs_frame_header_sticky',             'type' => 'sticky',   'default' => 'none' ],
		'header_transparent'        => [ 'mod' => 'whs_frame_header_transparent',        'type' => 'bool',     'default' => false ],
		'mobile_menu_logo'          => [ 'mod' => 'whs_frame_mobile_menu_logo',          'type' => 'bool',     'default' => true ],
		'custom_logo'               => [ 'mod' => 'custom_logo',                        'type' => 'id',       'default' => 0 ],
		// Footer
		'footer_logo'               => [ 'mod' => 'whs_frame_footer_logo',               'type' => 'id',       'default' => 0 ],
	];
}

/**
 * Sanitizes one mirrored value according to its declared type.
 *
 * @param  string $type    Value type: bool | col_type | sticky | id.
 * @param  mixed  $value   Raw incoming value.
 * @param  mixed  $default Fallback when validation fails.
 * @return mixed
 */
function whs_frame_sanitize_mirror_value( $type, $value, $default ) {
	switch ( $type ) {
		case 'bool':
			return (bool) $value;

		case 'col_type':
			$allowed = [ 'none', 'email', 'phone', 'email_phone', 'social_icons', 'custom_text' ];
			return in_array( $value, $allowed, true ) ? $value : $default;

		case 'sticky':
			$allowed = [ 'none', 'always', 'scroll_up' ];
			return in_array( $value, $allowed, true ) ? $value : $default;

		case 'id':
			return absint( $value );
	}

	return $default;
}

/**
 * Returns current values of all mirrored settings, read from theme mods.
 *
 * @return array
 */
function whs_frame_get_mirror_values() {
	$values = [];
	foreach ( whs_frame_mirror_fields() as $key => $field ) {
		$values[ $key ] = get_theme_mod( $field['mod'], $field['default'] );
	}
	return $values;
}

// ─── One-Time Migration From Theme Mods ──────────────────────────────────────

/**
 * Runs once on init to migrate existing Customizer theme_mods into the new
 * whs_frame_settings option.  Sets a flag so it never runs again.
 */
function whs_frame_migrate_theme_mods() {
	if ( get_option( 'whs_frame_settings_migrated' ) ) {
		return;
	}

	// Map: old theme_mod key => new settings key
	$map = [
		// Colors
		'whs_frame_color_primary'        => 'color_primary',
		'whs_frame_color_secondary'      => 'color_secondary',
		'whs_frame_color_background'     => 'color_background',
		'whs_frame_color_text'           => 'color_text',
		// Typography
		'whs_frame_typography_base_font'    => 'font_base',
		'whs_frame_typography_heading_font' => 'font_heading',
		// Layout
		'whs_frame_layout_container_width'  => 'container_width',
		// Header
		'whs_frame_header_bg_color'         => 'header_bg_color',
		'whs_frame_header_text_color'       => 'header_text_color',
		// Top Bar colors
		'whs_frame_topbar_bg_color'         => 'topbar_bg_color',
		'whs_frame_topbar_text_color'       => 'topbar_text_color',
		'whs_frame_topbar_link_color'       => 'topbar_link_color',
		// Top Bar columns — left
		'whs_frame_topbar_left_email'       => 'topbar_left_email',
		'whs_frame_topbar_left_phone'       => 'topbar_left_phone',
		'whs_frame_topbar_left_text'        => 'topbar_left_text',
		// Top Bar columns — center
		'whs_frame_topbar_center_email'     => 'topbar_center_email',
		'whs_frame_topbar_center_phone'     => 'topbar_center_phone',
		'whs_frame_topbar_center_text'      => 'topbar_center_text',
		// Top Bar columns — right
		'whs_frame_topbar_right_email'      => 'topbar_right_email',
		'whs_frame_topbar_right_phone'      => 'topbar_right_phone',
		'whs_frame_topbar_right_text'       => 'topbar_right_text',
		// Top Bar social URLs
		'whs_frame_topbar_social_facebook'  => 'topbar_social_facebook',
		'whs_frame_topbar_social_instagram' => 'topbar_social_instagram',
		'whs_frame_topbar_social_twitter'   => 'topbar_social_twitter',
		'whs_frame_topbar_social_linkedin'  => 'topbar_social_linkedin',
		'whs_frame_topbar_social_youtube'   => 'topbar_social_youtube',
		'whs_frame_topbar_social_tiktok'    => 'topbar_social_tiktok',
		// Social icon classes (shared)
		'whs_frame_social_facebook_icon'    => 'social_facebook_icon',
		'whs_frame_social_instagram_icon'   => 'social_instagram_icon',
		'whs_frame_social_twitter_icon'     => 'social_twitter_icon',
		'whs_frame_social_linkedin_icon'    => 'social_linkedin_icon',
		'whs_frame_social_youtube_icon'     => 'social_youtube_icon',
		'whs_frame_social_tiktok_icon'      => 'social_tiktok_icon',
		// Footer colors & content
		'whs_frame_footer_bg_color'         => 'footer_bg_color',
		'whs_frame_footer_text_color'       => 'footer_text_color',
		'whs_frame_footer_link_color'       => 'footer_link_color',
		'whs_frame_footer_address'          => 'footer_address',
		'whs_frame_footer_email'            => 'footer_email',
		'whs_frame_footer_phone'            => 'footer_phone',
		'whs_frame_footer_copyright'        => 'footer_copyright',
		// Footer social URLs
		'whs_frame_footer_social_facebook'  => 'footer_social_facebook',
		'whs_frame_footer_social_instagram' => 'footer_social_instagram',
		'whs_frame_footer_social_twitter'   => 'footer_social_twitter',
		'whs_frame_footer_social_linkedin'  => 'footer_social_linkedin',
		'whs_frame_footer_social_youtube'   => 'footer_social_youtube',
		'whs_frame_footer_social_tiktok'    => 'footer_social_tiktok',
	];

	$migrated = [];

	foreach ( $map as $mod_key => $setting_key ) {
		$value = get_theme_mod( $mod_key, '' );

		// Skip empty strings and zero-ish values — don't overwrite working defaults
		if ( '' === $value || 0 === $value || false === $value ) {
			continue;
		}

		$migrated[ $setting_key ] = $value;
	}

	if ( ! empty( $migrated ) ) {
		$existing          = get_option( 'whs_frame_settings', [] );
		$sanitized_migrated = whs_frame_sanitize_settings( $migrated );
		$merged            = array_merge( (array) $existing, $sanitized_migrated );
		update_option( 'whs_frame_settings', $merged, false );
	}

	// Always mark migration as done so this never runs again
	update_option( 'whs_frame_settings_migrated', 1, false );
}
add_action( 'init', 'whs_frame_migrate_theme_mods' );

// ─── REST API ─────────────────────────────────────────────────────────────────

/**
 * Register REST routes for reading and updating FlexBase settings.
 */
function whs_frame_register_rest_routes() {
	register_rest_route(
		'flexbase/v1',
		'/settings',
		[
			// GET — return current settings
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => 'whs_frame_rest_get_settings',
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			],
			// POST — update settings
			[
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => 'whs_frame_rest_update_settings',
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			],
		]
	);
}
add_action( 'rest_api_init', 'whs_frame_register_rest_routes' );

/**
 * REST GET callback — returns all current settings, including the
 * Customizer-mirrored theme_mod values (sticky mode, topbar structure, logos…).
 *
 * @return WP_REST_Response
 */
function whs_frame_rest_get_settings() {
	return rest_ensure_response(
		array_merge( whs_frame_get_all_settings(), whs_frame_get_mirror_values() )
	);
}

/**
 * REST POST/PUT/PATCH callback — sanitizes incoming data, merges with current
 * settings, persists to DB, and returns the updated settings.
 *
 * @param  WP_REST_Request $request
 * @return WP_REST_Response
 */
function whs_frame_rest_update_settings( WP_REST_Request $request ) {
	$body = $request->get_json_params();

	if ( ! is_array( $body ) ) {
		return new WP_Error(
			'invalid_data',
			__( 'Request body must be a JSON object.', 'whs-frame' ),
			[ 'status' => 400 ]
		);
	}

	$sanitized = whs_frame_sanitize_settings( $body );
	$current   = get_option( 'whs_frame_settings', [] );
	$updated   = array_merge( (array) $current, $sanitized );

	update_option( 'whs_frame_settings', $updated, false );

	// Persist Customizer-mirrored fields as theme_mods so the Customizer and
	// frontend get_theme_mod() reads stay in sync with this panel.
	foreach ( whs_frame_mirror_fields() as $key => $field ) {
		if ( array_key_exists( $key, $body ) ) {
			set_theme_mod(
				$field['mod'],
				whs_frame_sanitize_mirror_value( $field['type'], $body[ $key ], $field['default'] )
			);
		}
	}

	// Return fresh data — pass $refresh = true to bypass the static cache.
	return rest_ensure_response(
		array_merge( whs_frame_get_all_settings( true ), whs_frame_get_mirror_values() )
	);
}

// ─── Admin Menu ───────────────────────────────────────────────────────────────

/**
 * Register the top-level "FlexBase Settings" admin menu page.
 */
function whs_frame_add_admin_menu() {
	add_menu_page(
		__( 'WHS Frame Settings', 'whs-frame' ), // Page title
		__( 'WHS Frame Settings', 'whs-frame' ), // Menu title
		'manage_options',                       // Capability
		'whs-frame-settings',                    // Menu slug
		'whs_frame_admin_page_render',           // Callback
		'dashicons-layout',                     // Icon
		59                                      // Position
	);
}
add_action( 'admin_menu', 'whs_frame_add_admin_menu' );

/**
 * Outputs the React mount point for the settings page.
 */
function whs_frame_admin_page_render() {
	echo '<div id="flexbase-settings-root"></div>';
}

// ─── Admin Asset Enqueueing ───────────────────────────────────────────────────

/**
 * Enqueue admin styles and scripts — only on the FlexBase Settings page.
 *
 * The hook name is: toplevel_page_{menu-slug} = toplevel_page_whs-frame-settings
 */
function whs_frame_enqueue_admin_assets() {
	// WordPress media library modal — used by the logo picker fields.
	wp_enqueue_media();

	// Font Awesome Free 6 — self-hosted (assets/css + assets/webfonts), no external CDN dependency.
	wp_enqueue_style(
		'font-awesome',
		WHS_FRAME_ASSETS . 'css/font-awesome.min.css',
		[],
		'6.6.0'
	);

	// Admin stylesheet
	wp_enqueue_style(
		'flexbase-admin',
		get_template_directory_uri() . '/assets/admin/admin-settings.css',
		[ 'font-awesome' ],
		WHS_FRAME_VERSION
	);

	// Admin script (React app built on wp-element)
	wp_enqueue_script(
		'flexbase-admin',
		get_template_directory_uri() . '/assets/admin/admin-settings.js',
		[ 'wp-element', 'wp-api-fetch', 'wp-i18n' ],
		WHS_FRAME_VERSION,
		true // in footer
	);

	// Current logo preview URLs for the media picker fields.
	$mirror         = whs_frame_mirror_fields();
	$media_previews = [];
	foreach ( [ 'custom_logo', 'footer_logo' ] as $media_key ) {
		$attachment_id                = absint( get_theme_mod( $mirror[ $media_key ]['mod'], 0 ) );
		$preview_url                  = $attachment_id ? wp_get_attachment_image_url( $attachment_id, 'medium' ) : '';
		$media_previews[ $media_key ] = $preview_url ? $preview_url : '';
	}

	// Pass data to the script
	wp_localize_script(
		'flexbase-admin',
		'whsFrameAdmin',
		[
			'nonce'         => wp_create_nonce( 'wp_rest' ),
			'restUrl'       => rest_url( 'flexbase/v1/settings' ),
			'fontLabels'    => whs_frame_google_fonts_list(),
			'mediaPreviews' => $media_previews,
		]
	);
}
add_action( 'toplevel_page_whs-frame-settings', 'whs_frame_enqueue_admin_assets' );
