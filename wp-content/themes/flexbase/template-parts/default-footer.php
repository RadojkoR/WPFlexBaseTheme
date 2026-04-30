<?php defined( 'ABSPATH' ) || exit; ?>

<footer id="colophon" class="flexbase-footer">
	<div class="flexbase-footer__inner">

		<nav class="flexbase-footer__nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'flexbase' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'footer',
				'menu_class'     => 'flexbase-footer__menu',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 1,
			] );
			?>
		</nav>

		<p class="flexbase-footer__copyright">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</p>

	</div>
</footer>
