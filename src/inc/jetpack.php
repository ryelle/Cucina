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

	$args = array(
		'size' => 'full',
	);
	add_theme_support( 'site-logo', $args );
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

/**
 * Hijack the featured image and send it through Photon for resizing.
 */
function cucina_use_photon( $html, $post_id, $post_thumbnail_id, $size, $attr ){
	if ( ! Jetpack::is_module_active( 'photon' ) ){
		return $html;
	}
	$cucina_image_sizes = cucina_image_sizes();
	if ( preg_match("/src=\"(.*?)\"/", $html, $match ) && isset( $match[1] ) ) {
		$url = $match[1];
		if ( 'full' == $size ) {
			$w = 880;
			$h = 9999;
		} else {
			$w = $cucina_image_sizes[$size]['width'];
			$h = $cucina_image_sizes[$size]['height'];
		}
		$photon_url = apply_filters( 'jetpack_photon_url', $url, array( 'resize' => array( $w, $h ) ) );

		$html = str_replace( $url, $photon_url, $html );
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'cucina_use_photon', 10, 5 );

/**
 * Copied from Jetpack_Photon::image_size() because `protected` ಠ_ಠ
 */

/**
 * Provide an array of available image sizes and corresponding dimensions.
 * Similar to get_intermediate_image_sizes() except that it includes image sizes' dimensions, not just their names.
 *
 * @global $wp_additional_image_sizes
 * @uses get_option
 * @return array
 */
$cucina_image_sizes = null;
function cucina_image_sizes() {
	global $cucina_image_sizes;
	if ( null == $cucina_image_sizes ) {
		global $_wp_additional_image_sizes;

		// Populate an array matching the data structure of $_wp_additional_image_sizes so we have a consistent structure for image sizes
		$images = array(
			'thumb'  => array(
				'width'  => intval( get_option( 'thumbnail_size_w' ) ),
				'height' => intval( get_option( 'thumbnail_size_h' ) ),
				'crop'   => (bool) get_option( 'thumbnail_crop' )
			),
			'medium' => array(
				'width'  => intval( get_option( 'medium_size_w' ) ),
				'height' => intval( get_option( 'medium_size_h' ) ),
				'crop'   => false
			),
			'large'  => array(
				'width'  => intval( get_option( 'large_size_w' ) ),
				'height' => intval( get_option( 'large_size_h' ) ),
				'crop'   => false
			),
			'full'   => array(
				'width'  => null,
				'height' => null,
				'crop'   => false
			)
		);

		// Compatibility mapping as found in wp-includes/media.php
		$images['thumbnail'] = $images['thumb'];

		// Update class variable, merging in $_wp_additional_image_sizes if any are set
		if ( is_array( $_wp_additional_image_sizes ) && ! empty( $_wp_additional_image_sizes ) )
			$cucina_image_sizes = array_merge( $images, $_wp_additional_image_sizes );
		else
			$cucina_image_sizes = $images;
	}

	return is_array( $cucina_image_sizes ) ? $cucina_image_sizes : array();
}

