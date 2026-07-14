<?php get_header(); ?>

<main id="main" class="whs-frame-main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	else :
		echo '<p>' . esc_html__( 'No content found.', 'whs-frame' ) . '</p>';
	endif;
	?>
</main>

<?php get_footer(); ?>
