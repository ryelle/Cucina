<?php
/**
 * @package Cucina
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="entry-image">
		<?php the_post_thumbnail(); ?>
	</div>
	<?php endif; ?>

	<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php echo cucina_continue_reading_link(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
