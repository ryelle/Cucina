<?php
/**
 * The home page template file.
 *
 * @package Cucina
 */

get_header(); ?>

	<?php
	if ( is_front_page() && cucina_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<div class="layout <?php echo cucina_tiled_layout()? 'masonry': 'river'; ?>" id="posts-container">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( cucina_tiled_layout() ) {
						get_template_part( 'content', 'home' );
					} else {
						get_template_part( 'content', get_post_format() );
					} ?>

				<?php endwhile; ?>
				</div><!-- /.layout -->

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
