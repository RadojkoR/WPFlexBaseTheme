<?php
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'whs-frame-blog-sidebar' ) ) {
	return;
}
?>
<aside class="whs-frame-sidebar" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'whs-frame' ); ?>">
	<?php dynamic_sidebar( 'whs-frame-blog-sidebar' ); ?>
</aside>
