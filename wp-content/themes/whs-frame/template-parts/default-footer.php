<?php defined( 'ABSPATH' ) || exit;

// Build CSS variables for all footer colors
$_footer_style = sprintf(
	'--whs-frame-color-background:%s;--whs-frame-color-text:%s;--footer-link-color:%s;--footer-link-hover-color:%s;--footer-address-color:%s;--footer-heading-color:%s;--footer-social-icon-color:%s;--footer-social-hover-color:%s;--footer-copyright-text-color:%s;--footer-powered-by-color:%s;',
	whs_frame_css_color( 'footer_bg_color',                '#ffffff' ),
	whs_frame_css_color( 'footer_text_color',              '#4b5563' ),
	whs_frame_css_color( 'footer_link_color',              '#6b7280' ),
	whs_frame_css_color( 'footer_link_hover_color',        '#6366f1' ),
	whs_frame_css_color( 'footer_address_color',           '#6b7280' ),
	whs_frame_css_color( 'footer_heading_color',           '#9ca3af' ),
	whs_frame_css_color( 'footer_social_icon_color',       '#6b7280' ),
	whs_frame_css_color( 'footer_social_hover_color',      '#6366f1' ),
	whs_frame_css_color( 'footer_copyright_text_color',    '#9ca3af' ),
	whs_frame_css_color( 'footer_powered_by_color',        '#9ca3af' )
);

// Contact colors for Address, Email, Phone
$_contact_style = sprintf(
	'--contact-address-icon-color:%s;--contact-address-link-color:%s;--contact-address-hover-color:%s;--contact-email-icon-color:%s;--contact-email-hover-color:%s;--contact-phone-icon-color:%s;--contact-phone-hover-color:%s;',
	whs_frame_css_color( 'footer_contact_address_icon_color',   '#6b7280' ),
	whs_frame_css_color( 'footer_contact_address_link_color',   '#6b7280' ),
	whs_frame_css_color( 'footer_contact_address_hover_color',  '#6366f1' ),
	whs_frame_css_color( 'footer_contact_email_icon_color',     '#6b7280' ),
	whs_frame_css_color( 'footer_contact_email_hover_color',    '#6366f1' ),
	whs_frame_css_color( 'footer_contact_phone_icon_color',     '#6b7280' ),
	whs_frame_css_color( 'footer_contact_phone_hover_color',    '#6366f1' )
);

// Social icon styling
$_social_style = sprintf(
	'--social-icon-bg-color:%s;--social-icon-bg-hover-color:%s;--social-icon-border-color:%s;--social-icon-border-hover-color:%s;--social-icon-bd-size:%dpx;--social-icon-border-radius:%dpx;',
	whs_frame_css_color( 'footer_social_icon_bg_color', 'transparent' ),
	whs_frame_css_color( 'footer_social_icon_bg_hover_color', 'transparent' ),
	whs_frame_css_color( 'footer_social_icon_border_color', '#e5e7eb' ),
	whs_frame_css_color( 'footer_social_icon_border_hover_color', '#6366f1' ),
	absint( whs_frame_opt( 'footer_social_icon_border_width', 1 ) ),
	absint( whs_frame_opt( 'footer_social_icon_border_radius', 8 ) )
);

$footer_logo_id = absint( get_theme_mod( 'whs_frame_footer_logo', 0 ) );

// Address info
$footer_address      = whs_frame_opt( 'footer_address', '' );
$contact_map_url     = esc_url( whs_frame_opt( 'footer_contact_address_map_url', '' ) );
$contact_address_icon = whs_frame_opt( 'footer_contact_address_icon', 'fa-solid fa-location-dot' );

// Email contacts
$contact_email_1 = sanitize_email( whs_frame_opt( 'footer_contact_email_1', '' ) );
$contact_email_2 = sanitize_email( whs_frame_opt( 'footer_contact_email_2', '' ) );

// Phone contacts
$contact_phone_1 = sanitize_text_field( whs_frame_opt( 'footer_contact_phone_1', '' ) );
$contact_phone_2 = sanitize_text_field( whs_frame_opt( 'footer_contact_phone_2', '' ) );

// Copyright
$footer_copy = whs_frame_opt( 'footer_copyright', '' );

// Powered by
$powered_by_text = whs_frame_opt( 'footer_powered_by_text', '' );
$powered_by_url  = esc_url( whs_frame_opt( 'footer_powered_by_url', '' ) );

// Social networks
$social_networks = [ 'facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'tiktok' ];
$social_labels   = [
	'facebook'  => __( 'Facebook', 'whs-frame' ),
	'instagram' => __( 'Instagram', 'whs-frame' ),
	'twitter'   => __( 'Twitter / X', 'whs-frame' ),
	'linkedin'  => __( 'LinkedIn', 'whs-frame' ),
	'youtube'   => __( 'YouTube', 'whs-frame' ),
	'tiktok'    => __( 'TikTok', 'whs-frame' ),
];

// Check what columns to show
$has_contact = $contact_email_1 || $contact_email_2 || $contact_phone_1 || $contact_phone_2;
$has_social  = false;
foreach ( $social_networks as $n ) {
	if ( whs_frame_opt( 'footer_social_' . $n, '' ) ) {
		$has_social = true;
		break;
	}
}
?>

<footer id="colophon" class="whs-frame-footer" style="<?php echo esc_attr( $_footer_style . $_contact_style . $_social_style ); ?>">

	<div class="whs-frame-footer__columns">
		<div class="whs-frame-footer__inner">

			<!-- Column 1: Brand & Address -->
			<div class="whs-frame-footer__col whs-frame-footer__col--brand">

				<div class="whs-frame-footer__logo">
					<?php if ( $footer_logo_id ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php echo wp_get_attachment_image( $footer_logo_id, 'full', false, [ 'class' => 'custom-logo' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php elseif ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="whs-frame-footer__site-name">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if ( $footer_address ) : ?>
					<address class="whs-frame-footer__address">
						<?php if ( $contact_map_url ) : ?>
							<a href="<?php echo esc_url( $contact_map_url ); ?>" target="_blank" rel="noopener noreferrer" class="whs-frame-footer__address-link">
								<i class="<?php echo esc_attr( $contact_address_icon ); ?>"></i>
								<span><?php echo wp_kses_post( nl2br( $footer_address ) ); ?></span>
							</a>
						<?php else : ?>
							<div class="whs-frame-footer__address-text">
								<i class="<?php echo esc_attr( $contact_address_icon ); ?>"></i>
								<span><?php echo wp_kses_post( nl2br( $footer_address ) ); ?></span>
							</div>
						<?php endif; ?>
					</address>
				<?php endif; ?>

			</div>

			<?php if ( $has_contact ) : ?>
			<!-- Column 2: Contact -->
			<div class="whs-frame-footer__col whs-frame-footer__col--contact">

				<h4 class="whs-frame-footer__heading"><?php esc_html_e( 'Contact', 'whs-frame' ); ?></h4>

				<?php if ( $contact_email_1 ) : ?>
					<a href="mailto:<?php echo esc_attr( $contact_email_1 ); ?>" class="whs-frame-footer__contact-link whs-frame-footer__contact-link--email">
						<i class="fa-solid fa-envelope"></i>
						<span><?php echo esc_html( $contact_email_1 ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $contact_email_2 ) : ?>
					<a href="mailto:<?php echo esc_attr( $contact_email_2 ); ?>" class="whs-frame-footer__contact-link whs-frame-footer__contact-link--email">
						<i class="fa-solid fa-envelope"></i>
						<span><?php echo esc_html( $contact_email_2 ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $contact_phone_1 ) :
					$tel_1 = preg_replace( '/[^\d+]/', '', $contact_phone_1 );
				?>
					<a href="tel:<?php echo esc_attr( $tel_1 ); ?>" class="whs-frame-footer__contact-link whs-frame-footer__contact-link--phone">
						<i class="fa-solid fa-phone"></i>
						<span><?php echo esc_html( $contact_phone_1 ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $contact_phone_2 ) :
					$tel_2 = preg_replace( '/[^\d+]/', '', $contact_phone_2 );
				?>
					<a href="tel:<?php echo esc_attr( $tel_2 ); ?>" class="whs-frame-footer__contact-link whs-frame-footer__contact-link--phone">
						<i class="fa-solid fa-phone"></i>
						<span><?php echo esc_html( $contact_phone_2 ); ?></span>
					</a>
				<?php endif; ?>

			</div>
			<?php endif; ?>

			<?php if ( $has_social ) : ?>
			<!-- Column 3: Social Media -->
			<div class="whs-frame-footer__col whs-frame-footer__col--social">

				<h4 class="whs-frame-footer__heading"><?php esc_html_e( 'Follow Us', 'whs-frame' ); ?></h4>

				<ul class="whs-frame-footer__social">
					<?php foreach ( $social_networks as $network ) :
						$url  = whs_frame_opt( 'footer_social_' . $network, '' );
						$icon = whs_frame_opt( 'social_' . $network . '_icon', '' );
						if ( ! $url ) {
							continue;
						}
					?>
						<li>
							<a href="<?php echo esc_url( $url ); ?>"
							   target="_blank"
							   rel="noopener noreferrer"
							   aria-label="<?php echo esc_attr( $social_labels[ $network ] ); ?>"
							   class="whs-frame-footer__social-link">
								<?php if ( $icon ) : ?>
									<i class="<?php echo esc_attr( $icon ); ?>"></i>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

			</div>
			<?php endif; ?>

		</div>
	</div>

	<?php
	// Footer navigation (if menu is set)
	if ( has_nav_menu( 'footer' ) ) : ?>
		<nav class="whs-frame-footer__nav" aria-label="<?php esc_attr_e( 'Footer Menu', 'whs-frame' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'footer',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => false,
				'items_wrap'     => '<ul class="whs-frame-footer__nav-menu">%3$s</ul>',
			] );
			?>
		</nav>
	<?php endif; ?>

	<div class="whs-frame-footer__bar">
		<div class="whs-frame-footer__bar-inner">

			<?php if ( $footer_copy ) : ?>
				<p class="whs-frame-footer__copyright"><?php echo wp_kses_post( $footer_copy ); ?></p>
			<?php else : ?>
				<p class="whs-frame-footer__copyright">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
				</p>
			<?php endif; ?>

			<?php if ( $powered_by_text ) : ?>
				<p class="whs-frame-footer__powered-by">
					<?php if ( $powered_by_url ) : ?>
						<a href="<?php echo esc_url( $powered_by_url ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( $powered_by_text ); ?>
						</a>
					<?php else : ?>
						<?php echo esc_html( $powered_by_text ); ?>
					<?php endif; ?>
				</p>
			<?php endif; ?>

		</div>
	</div>

</footer>
