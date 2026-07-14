<?php
/**
 * Template Name: Elementor Canvas
 * Template Post Type: page
 *
 * @package FlexBase
 */

defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'elementor-page elementor-page-' . get_the_ID() ); ?>>
<?php wp_body_open(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<?php wp_footer(); ?>
</body>
</html>
