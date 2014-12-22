
<header class="entry-header">
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="entry-image">
		<?php the_post_thumbnail( 'full' ); ?>
	</div>
	<?php endif; ?>
</header><!-- .entry-header -->
