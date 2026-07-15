<?php
defined( 'ABSPATH' ) || exit;

do_action( 'whs_frame_before_footer' );
?>
<?php do_action( 'whs_frame_footer' ); ?>
<?php do_action( 'whs_frame_after_footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
