<?php
defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$whs_frame_categories    = get_the_category();
	$whs_frame_tags          = get_the_tags();
	$whs_frame_word_count    = str_word_count( wp_strip_all_tags( get_the_content() ) );
	$whs_frame_reading_time  = max( 1, (int) ceil( $whs_frame_word_count / 200 ) );
	$whs_frame_author_bio    = get_the_author_meta( 'description' );
	?>

	<main id="main" class="whs-frame-main whs-frame-single">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'whs-frame-post container' ); ?>>

			<header class="whs-frame-post__header">

				<?php if ( $whs_frame_categories ) : ?>
					<div class="whs-frame-post__categories">
						<?php foreach ( $whs_frame_categories as $whs_frame_cat ) : ?>
							<a href="<?php echo esc_url( get_category_link( $whs_frame_cat->term_id ) ); ?>" class="whs-frame-post__category">
								<?php echo esc_html( $whs_frame_cat->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! whs_frame_post_disabled( '_whs_frame_disable_title' ) ) : ?>
					<h1 class="whs-frame-post__title"><?php the_title(); ?></h1>
				<?php endif; ?>

				<div class="whs-frame-post__meta">
					<span class="whs-frame-post__meta-item whs-frame-post__author">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', [ 'class' => 'whs-frame-post__author-avatar' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
							<?php the_author(); ?>
						</a>
					</span>

					<span class="whs-frame-post__meta-item whs-frame-post__date">
						<i class="fa-solid fa-calendar"></i>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</span>

					<span class="whs-frame-post__meta-item whs-frame-post__reading-time">
						<i class="fa-solid fa-clock"></i>
						<?php
						printf(
							/* translators: %d: estimated reading time in minutes. */
							esc_html( _n( '%d min read', '%d min read', $whs_frame_reading_time, 'whs-frame' ) ),
							absint( $whs_frame_reading_time )
						);
						?>
					</span>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<span class="whs-frame-post__meta-item whs-frame-post__comments-count">
							<i class="fa-solid fa-comment"></i>
							<a href="#comments">
								<?php
								printf(
									/* translators: %s: number of comments. */
									esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'whs-frame' ) ),
									esc_html( number_format_i18n( get_comments_number() ) )
								);
								?>
							</a>
						</span>
					<?php endif; ?>
				</div>

			</header>

			<?php if ( has_post_thumbnail() && ! whs_frame_post_disabled( '_whs_frame_disable_featured_image' ) ) : ?>
				<div class="whs-frame-post__thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="whs-frame-post__content">
				<?php
				the_content();

				wp_link_pages( [
					'before' => '<div class="whs-frame-post__pagination page-links">' . esc_html__( 'Pages:', 'whs-frame' ),
					'after'  => '</div>',
				] );
				?>
			</div>

			<?php if ( $whs_frame_tags ) : ?>
				<div class="whs-frame-post__tags">
					<i class="fa-solid fa-tag"></i>
					<?php foreach ( $whs_frame_tags as $whs_frame_tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $whs_frame_tag->term_id ) ); ?>" class="whs-frame-post__tag">
							<?php echo esc_html( $whs_frame_tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $whs_frame_author_bio ) : ?>
				<div class="whs-frame-post__author-box">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', '', [ 'class' => 'whs-frame-post__author-box-avatar' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="whs-frame-post__author-box-body">
						<span class="whs-frame-post__author-box-label"><?php esc_html_e( 'Written by', 'whs-frame' ); ?></span>
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="whs-frame-post__author-box-name">
							<?php the_author(); ?>
						</a>
						<p class="whs-frame-post__author-box-bio"><?php echo esc_html( $whs_frame_author_bio ); ?></p>
					</div>
				</div>
			<?php endif; ?>

			<?php
			the_post_navigation( [
				'prev_text' => '<span class="whs-frame-post__nav-label">' . esc_html__( 'Previous', 'whs-frame' ) . '</span><span class="whs-frame-post__nav-title">%title</span>',
				'next_text' => '<span class="whs-frame-post__nav-label">' . esc_html__( 'Next', 'whs-frame' ) . '</span><span class="whs-frame-post__nav-title">%title</span>',
			] );
			?>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>

		</article>
	</main>

	<?php
endwhile;

get_footer();
