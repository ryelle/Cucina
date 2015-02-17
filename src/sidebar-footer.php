<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @package Cucina
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div id="tertiary" class="widget-area footer-widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #tertiary -->
