<?php
/**
 * The template for displaying featured content
 *
 * @package Cucina
 */
global $in_featured;
$in_featured = true;
?>

<div id="featured-content" class="featured-content">
	<div class="featured-content-inner">
	<?php
		$featured_posts = cucina_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );

			 // Include the featured content template.
			get_template_part( 'content', 'featured' );

		endforeach;
		wp_reset_postdata();
		$in_featured = false;
	?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
