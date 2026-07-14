<?php
defined( 'ABSPATH' ) || exit;

// ─── SVG Helpers ──────────────────────────────────────────────────────────────

function whs_frame_topbar_icon( $type ) {
	$icons = [
		'email' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
		'phone' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
	];
	return $icons[ $type ] ?? '';
}

function whs_frame_topbar_social_svg( $network ) {
	$defaults = [
		'facebook'  => 'fa-brands fa-facebook-f',
		'instagram' => 'fa-brands fa-instagram',
		'twitter'   => 'fa-brands fa-x-twitter',
		'linkedin'  => 'fa-brands fa-linkedin-in',
		'youtube'   => 'fa-brands fa-youtube',
		'tiktok'    => 'fa-brands fa-tiktok',
	];
	$default_class = $defaults[ $network ] ?? 'fa-brands fa-' . $network;
	$icon_class    = sanitize_text_field( whs_frame_opt( 'social_' . $network . '_icon', $default_class ) );
	return '<i class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';
}

// ─── Render Helpers ───────────────────────────────────────────────────────────

function whs_frame_topbar_render_social() {
	$networks = [
		'facebook'  => __( 'Facebook', 'whs-frame' ),
		'instagram' => __( 'Instagram', 'whs-frame' ),
		'twitter'   => __( 'Twitter / X', 'whs-frame' ),
		'linkedin'  => __( 'LinkedIn', 'whs-frame' ),
		'youtube'   => __( 'YouTube', 'whs-frame' ),
		'tiktok'    => __( 'TikTok', 'whs-frame' ),
	];

	$items = '';
	foreach ( $networks as $network => $label ) {
		$url = whs_frame_opt( 'topbar_social_' . $network, '' );
		if ( ! $url ) {
			continue;
		}
		$items .= sprintf(
			'<li><a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a></li>',
			esc_url( $url ),
			esc_attr( $label ),
			whs_frame_topbar_social_svg( $network )
		);
	}

	if ( $items ) {
		echo '<ul class="flexbase-topbar__social">' . $items . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

function whs_frame_topbar_render_col( $col ) {
	// Column type selector stays in Customizer (live preview support)
	$col_defaults = [ 'left' => 'email', 'center' => 'none', 'right' => 'social_icons' ];
	$type = get_theme_mod( 'whs_frame_topbar_' . $col . '_type', $col_defaults[ $col ] ?? 'none' );

	switch ( $type ) {
		case 'email':
			$email = sanitize_email( whs_frame_opt( 'topbar_' . $col . '_email', '' ) );
			if ( $email ) {
				printf(
					'<a href="mailto:%1$s" class="flexbase-topbar__link">%2$s<span>%1$s</span></a>',
					esc_attr( $email ),
					whs_frame_topbar_icon( 'email' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			break;

		case 'phone':
			$phone = sanitize_text_field( whs_frame_opt( 'topbar_' . $col . '_phone', '' ) );
			if ( $phone ) {
				$tel = preg_replace( '/[^\d+]/', '', $phone );
				printf(
					'<a href="tel:%s" class="flexbase-topbar__link">%s<span>%s</span></a>',
					esc_attr( $tel ),
					whs_frame_topbar_icon( 'phone' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html( $phone )
				);
			}
			break;

		case 'email_phone':
			$email = sanitize_email( whs_frame_opt( 'topbar_' . $col . '_email', '' ) );
			$phone = sanitize_text_field( whs_frame_opt( 'topbar_' . $col . '_phone', '' ) );
			if ( $email || $phone ) {
				echo '<div class="flexbase-topbar__contact">';
				if ( $email ) {
					printf(
						'<a href="mailto:%1$s" class="flexbase-topbar__link">%2$s<span>%1$s</span></a>',
						esc_attr( $email ),
						whs_frame_topbar_icon( 'email' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					);
				}
				if ( $phone ) {
					$tel = preg_replace( '/[^\d+]/', '', $phone );
					printf(
						'<a href="tel:%s" class="flexbase-topbar__link">%s<span>%s</span></a>',
						esc_attr( $tel ),
						whs_frame_topbar_icon( 'phone' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						esc_html( $phone )
					);
				}
				echo '</div>';
			}
			break;

		case 'social_icons':
			whs_frame_topbar_render_social();
			break;

		case 'custom_text':
			$text = whs_frame_opt( 'topbar_' . $col . '_text', '' );
			if ( $text ) {
				echo '<span class="flexbase-topbar__text">' . wp_kses_post( $text ) . '</span>';
			}
			break;
	}
}

// ─── Main Render ──────────────────────────────────────────────────────────────

function whs_frame_topbar_render() {
	// Enable/hide toggles stay in Customizer (live preview support)
	if ( ! get_theme_mod( 'whs_frame_topbar_enable', true ) ) {
		return;
	}

	$hide_mobile = get_theme_mod( 'whs_frame_topbar_hide_mobile', false );

	$dismissible = get_theme_mod( 'whs_frame_topbar_dismissible', false );

	$classes = [ 'flexbase-topbar' ];
	if ( $hide_mobile ) {
		$classes[] = 'flexbase-topbar--hide-mobile';
	}
	if ( $dismissible ) {
		$classes[] = 'flexbase-topbar--dismissible';
	}

	$inline_style = sprintf(
		'--topbar-bg-color:%s;--topbar-text-color:%s;--topbar-link-color:%s;',
		whs_frame_css_color( 'topbar_bg_color',   '#1e1e2e' ),
		whs_frame_css_color( 'topbar_text_color', '#ffffff' ),
		whs_frame_css_color( 'topbar_link_color', '#a5b4fc' )
	);
	?>
	<div id="flexbase-topbar"
		class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
		style="<?php echo esc_attr( $inline_style ); ?>"
		<?php echo $dismissible ? 'data-dismissible="true"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hardcoded attribute string, no user data ?>>

		<?php
		$col_types = [
			'left'   => get_theme_mod( 'whs_frame_topbar_left_type',   'email' ),
			'center' => get_theme_mod( 'whs_frame_topbar_center_type', 'none' ),
			'right'  => get_theme_mod( 'whs_frame_topbar_right_type',  'social_icons' ),
		];
		?>
		<div class="flexbase-topbar__inner">

			<?php foreach ( $col_types as $col => $col_type ) : ?>
			<div class="flexbase-topbar__col flexbase-topbar__col--<?php echo esc_attr( $col ); ?> flexbase-topbar__col--<?php echo esc_attr( $col_type ); ?>">
				<?php whs_frame_topbar_render_col( $col ); ?>
			</div>
			<?php endforeach; ?>

			<?php if ( $dismissible ) : ?>
			<button class="flexbase-topbar__close" aria-label="<?php esc_attr_e( 'Close top bar', 'whs-frame' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
			<?php endif; ?>

		</div>
	</div>
	<?php
}
add_action( 'whs_frame_topbar', 'whs_frame_topbar_render' );
