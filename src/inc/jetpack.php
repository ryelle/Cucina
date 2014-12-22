<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Cucina
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function cucina_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'masonry',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'cucina_jetpack_setup' );
