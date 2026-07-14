<?php
/**
 * Top Bar template part.
 *
 * Fires the whs_frame_topbar action so inc/topbar.php (and any third-party
 * filters) handle the actual output. Use this file via get_template_part()
 * when you need the top bar outside of header.php's normal flow.
 */
defined( 'ABSPATH' ) || exit;

do_action( 'whs_frame_topbar' );
