<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 *
 * @package WHS Frame
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="whs-frame-main whs-frame-main--full-width">
	<div class="whs-frame-container">
		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
			<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
		</article>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer();
