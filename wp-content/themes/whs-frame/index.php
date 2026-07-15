<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" class="whs-frame-main">
	<?php
	if ( have_posts() ) :

		// Singular content (front page, static pages routed here) renders as-is;
		// archive-style requests get a linked-title excerpt list with pagination.
		if ( is_singular() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		else :
			?>
			<div class="whs-frame-archive container">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'whs-frame-archive__item' ); ?>>
						<h2 class="whs-frame-archive__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="whs-frame-archive__meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</div>
						<div class="whs-frame-archive__excerpt">
							<?php the_excerpt(); ?>
						</div>
					</article>
					<?php
				endwhile;

				the_posts_pagination( [
					'prev_text' => esc_html__( '&larr; Newer posts', 'whs-frame' ),
					'next_text' => esc_html__( 'Older posts &rarr;', 'whs-frame' ),
				] );
				?>
			</div>
			<?php
		endif;

	else :
		echo '<p>' . esc_html__( 'No content found.', 'whs-frame' ) . '</p>';
	endif;
	?>
</main>

<?php get_footer(); ?>
