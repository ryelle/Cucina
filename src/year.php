<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cucina
 */
get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php $prev_month = '01'; $prev_year = '0'; $i = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $current_month = get_the_date( 'm' ); ?>
				<?php $current_year = get_the_date( 'Y' ); ?>

				<?php if ( $prev_month !== $current_month || $prev_year !== $current_year || $i == 0  ) { ?>
				<?php if ( $i > 0 ) echo '</div>'; ?>
				<h2 class="page-title" ><?php the_time( 'F Y' ); ?></h2>
				<div class="masonry">
				<?php } ?>
				<?php
					get_template_part( 'content', 'home' );
				?>

				<?php $prev_month = get_the_date( 'm' ); $i++ ?>
				<?php $prev_year = get_the_date( 'Y' ); ?>
			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
