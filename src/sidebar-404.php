<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Cucina
 */

if ( ! is_active_sidebar( 'sidebar-3' ) ) {
	return;
}
?>

<div id="404-widgets" class="widget-area not-found-widget-area">
	<?php dynamic_sidebar( 'sidebar-3' ); ?>
</div><!-- #secondary -->
