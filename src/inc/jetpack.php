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

	add_theme_support( 'featured-content', array(
		'filter'     => 'cucina_get_featured_content',
		'max_posts'  => 1,
		'post_types' => array( 'post' ),
	) );
}
add_action( 'after_setup_theme', 'cucina_jetpack_setup' );

/**
 * Pull featured content from Jetpack
 */
function cucina_get_featured_posts(){
	return apply_filters( 'cucina_get_featured_content', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function cucina_has_featured_posts() {
	return ! is_paged() && (bool) cucina_get_featured_posts();
}
