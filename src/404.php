<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Cucina
 */

get_header(); ?>

	<?php get_template_part( 'partial/header', 'none' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'cucina' ); ?></p>

					<?php get_sidebar('404'); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
