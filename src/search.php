<?php
/**
 * The template for displaying search results pages.
 *
 * @package Cucina
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php get_template_part( 'partial/header', 'search' ); ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<div class="layout river" id="posts-container">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'content', 'search' );
					?>

				<?php endwhile; ?>
				</div>

				<?php the_posts_navigation(); ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	<?php else : ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php get_template_part( 'content', 'none' ); ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
