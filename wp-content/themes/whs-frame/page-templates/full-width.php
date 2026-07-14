<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 *
 * @package FlexBase
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="flexbase-main flexbase-main--full-width">
	<div class="flexbase-container">
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
