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
	$infinite_args = array(
		'container' => 'posts-container',
		'render'    => 'cucina_infinite_scroll_render',
		'footer'    => 'page',
		'type'      => 'click',
		'footer_widgets' => false,
	);
	add_theme_support( 'infinite-scroll', $infinite_args );

	add_theme_support( 'featured-content', array(
		'filter'     => 'cucina_get_featured_content',
		'max_posts'  => 1,
		'post_types' => array( 'post' ),
	) );
}
add_action( 'after_setup_theme', 'cucina_jetpack_setup' );

/**
 * Set the code to be rendered on for calling posts,
 * hooked to template parts when possible.
 *
 * Note: must define a loop.
 */
function cucina_infinite_scroll_render() {
	while( have_posts() ) : the_post();
		if ( cucina_tiled_layout() || ! is_home() ) {
			get_template_part( 'content', 'home' );
		} else {
			get_template_part( 'content', get_post_format() );
		}
	endwhile;
}

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
