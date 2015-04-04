<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package Cucina
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses cucina_header_style()
 * @uses cucina_admin_header_style()
 * @uses cucina_admin_header_image()
 */
function cucina_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'cucina_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'f6986f',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'cucina_header_style'
	) ) );
}
add_action( 'after_setup_theme', 'cucina_custom_header_setup' );

/**
 * Styles the header image and text displayed on the blog
 *
 * @see cucina_custom_header_setup().
 */
function cucina_header_style() {
	$header_text_color = get_header_textcolor();
	$default_desc_color = apply_filters( 'cucina_default_desc_color', '8c785e' );
	$desc_text_color = ltrim( get_theme_mod( 'desc_textcolor', $default_desc_color ), '#' );
	$colors_css = '';

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR !== $header_text_color && 'blank' !== $header_text_color ) {
		$colors_css .= sprintf(
			".site-title a:link, .site-title a:active, .site-title a:hover, .site-title a:visited { color: #%s; } ",
			esc_attr( $header_text_color )
		);
	}

	if ( $default_desc_color !== $desc_text_color ) {
		$colors_css .= sprintf(
			".site-description { color: #%s; } ",
			esc_attr( $desc_text_color )
		);
	}

	if ( ! empty( $colors_css ) ) {
		printf( '<style type="text/css">%s</style>', $colors_css );
	}
}
