<?php
/**
 * @package Cucina
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php printf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ); ?>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="entry-image">
		<?php the_post_thumbnail( 'square-thumbnail' ); ?>
	</div>
	<?php endif; ?>

	<header class="entry-header">
	<?php if ( get_the_title() ) : ?>
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	<?php else: ?>
		<div class="entry-excerpt"><?php the_excerpt(); ?></div>
	<?php endif; ?>
	</header><!-- .entry-header -->

	</a><!-- /permalink -->
</article><!-- #post-## -->
