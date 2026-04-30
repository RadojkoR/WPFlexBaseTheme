<?php
defined( 'ABSPATH' ) || exit;

// ─── Customizer ───────────────────────────────────────────────────────────────

function flexbase_sanitize_checkbox( $value ) {
	return (bool) $value;
}

function flexbase_topbar_customizer( $wp_customize ) {

	$wp_customize->add_panel( 'flexbase_topbar_panel', [
		'title'    => __( 'Top Bar', 'flexbase' ),
		'priority' => 30,
	] );

	// ── General ──────────────────────────────────────────────────────────────
	$wp_customize->add_section( 'flexbase_topbar_general', [
		'title' => __( 'General', 'flexbase' ),
		'panel' => 'flexbase_topbar_panel',
	] );

	$wp_customize->add_setting( 'flexbase_topbar_enable', [
		'default'           => true,
		'sanitize_callback' => 'flexbase_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'flexbase_topbar_enable', [
		'label'   => __( 'Enable Top Bar', 'flexbase' ),
		'section' => 'flexbase_topbar_general',
		'type'    => 'checkbox',
	] );

	$wp_customize->add_setting( 'flexbase_topbar_bg_color', [
		'default'           => '#1e1e2e',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'flexbase_topbar_bg_color', [
		'label'   => __( 'Background Color', 'flexbase' ),
		'section' => 'flexbase_topbar_general',
	] ) );

	$wp_customize->add_setting( 'flexbase_topbar_text_color', [
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'flexbase_topbar_text_color', [
		'label'   => __( 'Text Color', 'flexbase' ),
		'section' => 'flexbase_topbar_general',
	] ) );

	$wp_customize->add_setting( 'flexbase_topbar_link_color', [
		'default'           => '#a5b4fc',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'flexbase_topbar_link_color', [
		'label'   => __( 'Link / Icon Color', 'flexbase' ),
		'section' => 'flexbase_topbar_general',
	] ) );

	$wp_customize->add_setting( 'flexbase_topbar_hide_mobile', [
		'default'           => false,
		'sanitize_callback' => 'flexbase_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'flexbase_topbar_hide_mobile', [
		'label'   => __( 'Hide on Mobile', 'flexbase' ),
		'section' => 'flexbase_topbar_general',
		'type'    => 'checkbox',
	] );

	$wp_customize->add_setting( 'flexbase_topbar_dismissible', [
		'default'           => false,
		'sanitize_callback' => 'flexbase_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'flexbase_topbar_dismissible', [
		'label'       => __( 'Dismissible (show close button)', 'flexbase' ),
		'description' => __( 'User can close the top bar. State is saved in localStorage.', 'flexbase' ),
		'section'     => 'flexbase_topbar_general',
		'type'        => 'checkbox',
	] );

	// ── Columns ───────────────────────────────────────────────────────────────
	$content_types = [
		'none'         => __( 'None', 'flexbase' ),
		'email'        => __( 'Email', 'flexbase' ),
		'phone'        => __( 'Phone', 'flexbase' ),
		'social_icons' => __( 'Social Icons', 'flexbase' ),
		'custom_text'  => __( 'Custom Text', 'flexbase' ),
	];

	$columns = [
		'left'   => [ 'label' => __( 'Left Column', 'flexbase' ),   'default_type' => 'email' ],
		'center' => [ 'label' => __( 'Center Column', 'flexbase' ), 'default_type' => 'none' ],
		'right'  => [ 'label' => __( 'Right Column', 'flexbase' ),  'default_type' => 'social_icons' ],
	];

	foreach ( $columns as $col => $col_args ) {
		$section = 'flexbase_topbar_' . $col;

		$wp_customize->add_section( $section, [
			'title' => $col_args['label'],
			'panel' => 'flexbase_topbar_panel',
		] );

		// Content type selector.
		$wp_customize->add_setting( 'flexbase_topbar_' . $col . '_type', [
			'default'           => $col_args['default_type'],
			'sanitize_callback' => 'sanitize_key',
		] );
		$wp_customize->add_control( 'flexbase_topbar_' . $col . '_type', [
			'label'   => __( 'Content Type', 'flexbase' ),
			'section' => $section,
			'type'    => 'select',
			'choices' => $content_types,
		] );

		// Email.
		$wp_customize->add_setting( 'flexbase_topbar_' . $col . '_email', [
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		] );
		$wp_customize->add_control( 'flexbase_topbar_' . $col . '_email', [
			'label'   => __( 'Email Address', 'flexbase' ),
			'section' => $section,
			'type'    => 'email',
		] );

		// Phone.
		$wp_customize->add_setting( 'flexbase_topbar_' . $col . '_phone', [
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		] );
		$wp_customize->add_control( 'flexbase_topbar_' . $col . '_phone', [
			'label'   => __( 'Phone Number', 'flexbase' ),
			'section' => $section,
			'type'    => 'text',
		] );

		// Custom text.
		$wp_customize->add_setting( 'flexbase_topbar_' . $col . '_text', [
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		] );
		$wp_customize->add_control( 'flexbase_topbar_' . $col . '_text', [
			'label'   => __( 'Custom Text', 'flexbase' ),
			'section' => $section,
			'type'    => 'textarea',
		] );
	}

	// ── Social Icons ──────────────────────────────────────────────────────────
	$wp_customize->add_section( 'flexbase_topbar_social', [
		'title' => __( 'Social Icons', 'flexbase' ),
		'panel' => 'flexbase_topbar_panel',
	] );

	$social_networks = [
		'facebook'  => __( 'Facebook URL', 'flexbase' ),
		'instagram' => __( 'Instagram URL', 'flexbase' ),
		'twitter'   => __( 'Twitter / X URL', 'flexbase' ),
		'linkedin'  => __( 'LinkedIn URL', 'flexbase' ),
		'youtube'   => __( 'YouTube URL', 'flexbase' ),
		'tiktok'    => __( 'TikTok URL', 'flexbase' ),
	];

	foreach ( $social_networks as $network => $label ) {
		$wp_customize->add_setting( 'flexbase_topbar_social_' . $network, [
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		] );
		$wp_customize->add_control( 'flexbase_topbar_social_' . $network, [
			'label'   => $label,
			'section' => 'flexbase_topbar_social',
			'type'    => 'url',
		] );
	}
}
add_action( 'customize_register', 'flexbase_topbar_customizer' );

// ─── SVG Helpers ──────────────────────────────────────────────────────────────

function flexbase_topbar_icon( $type ) {
	$icons = [
		'email' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
		'phone' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
	];
	return $icons[ $type ] ?? '';
}

function flexbase_topbar_social_svg( $network ) {
	$icons = [
		'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
		'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
		'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
		'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>',
		'tiktok'    => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V9.17a8.16 8.16 0 0 0 4.77 1.52V7.24a4.85 4.85 0 0 1-1-.55z"/></svg>',
	];
	return $icons[ $network ] ?? '';
}

// ─── Render Helpers ───────────────────────────────────────────────────────────

function flexbase_topbar_render_social() {
	$networks = [
		'facebook'  => __( 'Facebook', 'flexbase' ),
		'instagram' => __( 'Instagram', 'flexbase' ),
		'twitter'   => __( 'Twitter / X', 'flexbase' ),
		'linkedin'  => __( 'LinkedIn', 'flexbase' ),
		'youtube'   => __( 'YouTube', 'flexbase' ),
		'tiktok'    => __( 'TikTok', 'flexbase' ),
	];

	$items = '';
	foreach ( $networks as $network => $label ) {
		$url = get_theme_mod( 'flexbase_topbar_social_' . $network, '' );
		if ( ! $url ) {
			continue;
		}
		$items .= sprintf(
			'<li><a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a></li>',
			esc_url( $url ),
			esc_attr( $label ),
			flexbase_topbar_social_svg( $network )
		);
	}

	if ( $items ) {
		echo '<ul class="flexbase-topbar__social">' . $items . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

function flexbase_topbar_render_col( $col ) {
	$type = get_theme_mod( 'flexbase_topbar_' . $col . '_type', 'none' );

	switch ( $type ) {
		case 'email':
			$email = sanitize_email( get_theme_mod( 'flexbase_topbar_' . $col . '_email', '' ) );
			if ( $email ) {
				printf(
					'<a href="mailto:%1$s" class="flexbase-topbar__link">%2$s<span>%1$s</span></a>',
					esc_attr( $email ),
					flexbase_topbar_icon( 'email' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			break;

		case 'phone':
			$phone = sanitize_text_field( get_theme_mod( 'flexbase_topbar_' . $col . '_phone', '' ) );
			if ( $phone ) {
				$tel = preg_replace( '/[^\d+]/', '', $phone );
				printf(
					'<a href="tel:%s" class="flexbase-topbar__link">%s<span>%s</span></a>',
					esc_attr( $tel ),
					flexbase_topbar_icon( 'phone' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html( $phone )
				);
			}
			break;

		case 'social_icons':
			flexbase_topbar_render_social();
			break;

		case 'custom_text':
			$text = get_theme_mod( 'flexbase_topbar_' . $col . '_text', '' );
			if ( $text ) {
				echo '<span class="flexbase-topbar__text">' . wp_kses_post( $text ) . '</span>';
			}
			break;
	}
}

// ─── Main Render ──────────────────────────────────────────────────────────────

function flexbase_topbar_render() {
	if ( ! get_theme_mod( 'flexbase_topbar_enable', true ) ) {
		return;
	}

	$bg_color    = get_theme_mod( 'flexbase_topbar_bg_color',    '#1e1e2e' );
	$text_color  = get_theme_mod( 'flexbase_topbar_text_color',  '#ffffff' );
	$link_color  = get_theme_mod( 'flexbase_topbar_link_color',  '#a5b4fc' );
	$hide_mobile = get_theme_mod( 'flexbase_topbar_hide_mobile', false );
	$dismissible = get_theme_mod( 'flexbase_topbar_dismissible', false );

	$classes = [ 'flexbase-topbar' ];
	if ( $hide_mobile ) {
		$classes[] = 'flexbase-topbar--hide-mobile';
	}
	if ( $dismissible ) {
		$classes[] = 'flexbase-topbar--dismissible';
	}

	$inline_style = sprintf(
		'background-color:%s;color:%s;--topbar-link-color:%s;',
		esc_attr( sanitize_hex_color( $bg_color ) ),
		esc_attr( sanitize_hex_color( $text_color ) ),
		esc_attr( sanitize_hex_color( $link_color ) )
	);
	?>
	<div id="flexbase-topbar"
		class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
		style="<?php echo esc_attr( $inline_style ); ?>"
		<?php echo $dismissible ? 'data-dismissible="true"' : ''; ?>>

		<div class="flexbase-topbar__inner">

			<div class="flexbase-topbar__col flexbase-topbar__col--left">
				<?php flexbase_topbar_render_col( 'left' ); ?>
			</div>

			<div class="flexbase-topbar__col flexbase-topbar__col--center">
				<?php flexbase_topbar_render_col( 'center' ); ?>
			</div>

			<div class="flexbase-topbar__col flexbase-topbar__col--right">
				<?php flexbase_topbar_render_col( 'right' ); ?>
			</div>

			<?php if ( $dismissible ) : ?>
			<button class="flexbase-topbar__close" aria-label="<?php esc_attr_e( 'Close top bar', 'flexbase' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
			<?php endif; ?>

		</div>
	</div>
	<?php
}
add_action( 'flexbase_topbar', 'flexbase_topbar_render' );
