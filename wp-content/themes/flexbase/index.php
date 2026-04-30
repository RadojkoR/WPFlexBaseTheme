<?php get_header(); ?>

<main id="main" class="flexbase-main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	else :
		echo '<p>' . esc_html__( 'No content found.', 'flexbase' ) . '</p>';
	endif;
	?>
</main>

<?php get_footer(); ?>
