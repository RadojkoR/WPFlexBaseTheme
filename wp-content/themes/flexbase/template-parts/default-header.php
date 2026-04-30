<?php defined( 'ABSPATH' ) || exit; ?>

<header id="masthead" class="flexbase-header">
	<div class="flexbase-header__inner">

		<div class="flexbase-header__logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="flexbase-header__site-name">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="flexbase-header__nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'flexbase' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_class'     => 'flexbase-nav__menu',
				'container'      => false,
				'fallback_cb'    => false,
			] );
			?>
		</nav>

	</div>
</header>
