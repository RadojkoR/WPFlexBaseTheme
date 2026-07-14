<?php defined( 'ABSPATH' ) || exit;

?>

<header id="masthead" class="whs-frame-header">
	<div class="whs-frame-header__inner">

		<div class="whs-frame-header__logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="whs-frame-header__site-name">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="whs-frame-header__nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'whs-frame' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => 'whs-frame-nav__menu',
				'container'      => false,
				'fallback_cb'    => false,
			] );
			?>
		</nav>

		<?php
		$show_login    = whs_frame_opt( 'nav_login_enable' );
		$show_signup   = whs_frame_opt( 'nav_signup_enable' );
		$show_language = whs_frame_opt( 'nav_language_switcher_enable' )
			&& ( function_exists( 'pll_the_languages' ) || defined( 'WPML_VERSION' ) );

		// Custom URLs with WordPress fallbacks when left empty in settings.
		$login_url  = whs_frame_opt( 'nav_login_url' )  ?: wp_login_url();
		$logout_url = whs_frame_opt( 'nav_logout_url' ) ?: wp_logout_url( home_url( '/' ) );
		$signup_url = whs_frame_opt( 'nav_signup_url' ) ?: wp_registration_url();

		if ( $show_login || $show_signup || $show_language ) :
			$button_style = whs_frame_opt( 'nav_button_style', 'link' );
			$button_class = 'link' === $button_style ? 'whs-frame-header__action-link' : 'whs-frame-header__action-button';
			?>
			<div class="whs-frame-header__actions">
				<?php
				// Login / Logout button
				if ( $show_login ) :
					if ( is_user_logged_in() ) :
						?>
						<a href="<?php echo esc_url( $logout_url ); ?>" class="<?php echo esc_attr( $button_class . ( 'button' === $button_style ? ' whs-frame-header__action-button--login' : '' ) ); ?>" rel="nofollow">
							<?php esc_html_e( 'Logout', 'whs-frame' ); ?>
						</a>
						<?php
					else :
						?>
						<a href="<?php echo esc_url( $login_url ); ?>" class="<?php echo esc_attr( $button_class . ( 'button' === $button_style ? ' whs-frame-header__action-button--login' : '' ) ); ?>" rel="nofollow">
							<?php echo esc_html( whs_frame_opt( 'nav_login_label', 'Login' ) ); ?>
						</a>
						<?php
					endif;
				endif;
				?>

				<?php
				// Signup button
				if ( $show_signup && ! is_user_logged_in() ) :
					?>
					<a href="<?php echo esc_url( $signup_url ); ?>" class="<?php echo esc_attr( $button_class . ( 'button' === $button_style ? ' whs-frame-header__action-button--signup' : '' ) ); ?>" rel="nofollow">
						<?php echo esc_html( whs_frame_opt( 'nav_signup_label', 'Sign Up' ) ); ?>
					</a>
					<?php
				endif;
				?>

				<?php
				// Language Switcher
				if ( $show_language ) :
					if ( function_exists( 'pll_the_languages' ) ) :
						// Polylang
						$show_flags = whs_frame_opt( 'nav_language_switcher_flags' );
						$show_name  = whs_frame_opt( 'nav_language_switcher_name' );
						$show_code  = whs_frame_opt( 'nav_language_switcher_code' );
						$lang_display = [];
						if ( $show_flags ) $lang_display[] = 'flag';
						if ( $show_name ) $lang_display[] = 'name';
						if ( $show_code ) $lang_display[] = 'slug';
						?>
						<div class="whs-frame-header__language-switcher">
							<?php pll_the_languages( [ 'display' => implode( ',', $lang_display ) ] ); ?>
						</div>
						<?php
					elseif ( defined( 'WPML_VERSION' ) ) :
						// WPML — flag/name/code display is configured in WPML's own settings.
						?>
						<div class="whs-frame-header__language-switcher">
							<?php do_action( 'wpml_add_language_selector' ); ?>
						</div>
						<?php
					endif;
				endif;
				?>
			</div>
		<?php endif; ?>

		<button
			class="whs-frame-header__hamburger"
			aria-controls="whs-frame-mobile-menu"
			aria-expanded="false"
			aria-label="<?php esc_attr_e( 'Toggle navigation', 'whs-frame' ); ?>"
		>
			<span class="whs-frame-header__hamburger-bar"></span>
			<span class="whs-frame-header__hamburger-bar"></span>
			<span class="whs-frame-header__hamburger-bar"></span>
		</button>

	</div>

	<?php
	$mobile_css_vars = [
		'--mobile-menu-bg: ' . esc_attr( whs_frame_opt( 'mobile_menu_bg_color', '#ffffff' ) ),
		'--mobile-menu-text: ' . esc_attr( whs_frame_opt( 'mobile_menu_text_color', '#1e1e2e' ) ),
		'--mobile-menu-link-hover: ' . esc_attr( whs_frame_opt( 'mobile_menu_link_hover', '#6366f1' ) ),
		'--mobile-menu-active-bg: ' . esc_attr( whs_frame_opt( 'mobile_menu_active_bg', '#f5f3ff' ) ),
		'--mobile-menu-active-text: ' . esc_attr( whs_frame_opt( 'mobile_menu_active_text', '#6366f1' ) ),
		'--mobile-close-bg: ' . esc_attr( whs_frame_opt( 'mobile_close_bg_color', '#ffffff' ) ),
		'--mobile-close-icon: ' . esc_attr( whs_frame_opt( 'mobile_close_icon_color', '#1e1e2e' ) ),
		'--mobile-close-border: ' . esc_attr( whs_frame_opt( 'mobile_close_border_color', '#e5e7eb' ) ),
		'--mobile-close-bd-size: ' . absint( whs_frame_opt( 'mobile_close_border_width', 1 ) ) . 'px',
		'--mobile-close-border-radius: ' . absint( whs_frame_opt( 'mobile_close_border_radius', 8 ) ) . 'px',
	];
	$mobile_style = 'style="' . esc_attr( implode( '; ', $mobile_css_vars ) ) . '"';
	?>

	<div id="whs-frame-mobile-menu" class="whs-frame-header__mobile-menu" aria-hidden="true" <?php echo $mobile_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped via esc_attr() on line 132 ?>>


		<button
			class="whs-frame-header__mobile-close"
			aria-label="<?php esc_attr_e( 'Close menu', 'whs-frame' ); ?>"
			aria-controls="whs-frame-mobile-menu"
		>
			<span class="whs-frame-header__mobile-close-bar"></span>
			<span class="whs-frame-header__mobile-close-bar"></span>
		</button>

		<?php if ( get_theme_mod( 'whs_frame_mobile_menu_logo', true ) ) : ?>
		<div class="whs-frame-header__mobile-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="whs-frame-header__site-name">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<nav aria-label="<?php esc_attr_e( 'Mobile Navigation', 'whs-frame' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => 'whs-frame-nav__menu whs-frame-nav__menu--mobile',
				'container'      => false,
				'fallback_cb'    => false,
			] );
			?>
		</nav>

		<?php
		$show_login    = whs_frame_opt( 'nav_login_enable' );
		$show_signup   = whs_frame_opt( 'nav_signup_enable' );

		if ( $show_login || $show_signup ) :
			$button_style = whs_frame_opt( 'nav_button_style', 'link' );
			$button_class = 'link' === $button_style ? 'whs-frame-header__action-link' : 'whs-frame-header__action-button';
			?>
			<div class="whs-frame-header__mobile-actions">
				<?php
				// Login / Logout button
				if ( $show_login ) :
					if ( is_user_logged_in() ) :
						?>
						<a href="<?php echo esc_url( $logout_url ); ?>" class="<?php echo esc_attr( $button_class . ( 'button' === $button_style ? ' whs-frame-header__action-button--login' : '' ) ); ?>" rel="nofollow">
							<?php esc_html_e( 'Logout', 'whs-frame' ); ?>
						</a>
						<?php
					else :
						?>
						<a href="<?php echo esc_url( $login_url ); ?>" class="<?php echo esc_attr( $button_class . ( 'button' === $button_style ? ' whs-frame-header__action-button--login' : '' ) ); ?>" rel="nofollow">
							<?php echo esc_html( whs_frame_opt( 'nav_login_label', 'Login' ) ); ?>
						</a>
						<?php
					endif;
				endif;
				?>

				<?php
				// Signup button
				if ( $show_signup && ! is_user_logged_in() ) :
					?>
					<a href="<?php echo esc_url( $signup_url ); ?>" class="<?php echo esc_attr( $button_class . ( 'button' === $button_style ? ' whs-frame-header__action-button--signup' : '' ) ); ?>" rel="nofollow">
						<?php echo esc_html( whs_frame_opt( 'nav_signup_label', 'Sign Up' ) ); ?>
					</a>
					<?php
				endif;
				?>
			</div>
		<?php endif; ?>
	</div>
</header>
