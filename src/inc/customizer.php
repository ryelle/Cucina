<?php
/**
 * Cucina Theme Customizer
 *
 * @package Cucina
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cucina_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_image' )->transport = 'refresh';

	$wp_customize->get_control( 'header_textcolor' )->priority = 10;
	$wp_customize->get_control( 'background_color' )->priority = 20;

	$wp_customize->add_setting( 'desc_textcolor', array(
		'default'           => apply_filters( 'cucina_default_desc_color', '8c785e' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'desc_textcolor', array(
		'label'      => __( 'Description Color', 'cucina' ),
		'section'    => 'colors',
		'settings'   => 'desc_textcolor',
		'priority'   => 15,
	) ) );

	$wp_customize->add_section( 'cucina_layout' , array(
		'title'      => __( 'Layout', 'cucina' ),
		'priority'   => 20,
	) );

	$wp_customize->add_setting( 'tiled_layout', array(
		'default'           => true,
		'sanitize_callback' => 'cucina_sanitize_yesno',
	) );

	$wp_customize->add_control( 'tiled_layout', array(
		'label'       => __( 'Use a tiled layout?', 'cucina' ),
		'section'     => 'cucina_layout',
		'type'        => 'checkbox',
		'description' => __( 'When checked, front page displays posts as image/title cards. Unchecked, posts are a single stream with excerpts of the post content.', 'cucina' ),
	) );

	$wp_customize->add_setting( 'background_size', array(
		'default'           => true,
		'sanitize_callback' => 'cucina_sanitize_yesno',
		'theme_supports'    => 'custom-background',
	) );

	$wp_customize->add_control( 'background_size', array(
		'label'       => __( 'This image is retina', 'cucina' ),
		'section'     => 'background_image',
		'type'        => 'checkbox',
		'description' => __( 'When selected, the background image is downsized by 50%, so that is displays at 2x depth on retina screens.', 'cucina' ),
	) );
}
add_action( 'customize_register', 'cucina_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cucina_customize_preview_js() {
	wp_enqueue_script( 'cucina_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), CUCINA_VERSION, true );
}
add_action( 'customize_preview_init', 'cucina_customize_preview_js' );

/**
 * Sanitization function to return a 'yes' or 'no' value.
 * Not using booleans to prevent confusion with the unset state "false".
 *
 * @param  mixed  $maybebool  Value that should be either 'yes' or 'no'.
 * @return string  'yes' or 'no'
 */
function cucina_sanitize_yesno( $maybebool ){
	if ( $maybebool == true ){
		return true;
	}
	return false;
}
