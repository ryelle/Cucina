<?php
/**
 * Cucina functions and definitions
 *
 * @package Cucina
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 545; /* pixels */
}

if ( ! function_exists( 'cucina_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cucina_setup() {
	global $content_width;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Cucina, use a find and replace
	 * to change 'cucina' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'cucina', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 * @link http://make.wordpress.org/core/2014/02/20/audio-video-2-0-update-playlists/
	 */
	add_post_type_support( 'attachment:audio', 'thumbnail' );
	add_post_type_support( 'attachment:video', 'thumbnail' );
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'attachment:audio', 'attachment:video' ) );
	set_post_thumbnail_size( 545, 545, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'cucina' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'cucina_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => get_template_directory_uri() . '/images/kiwis.png',
		'default-attachment' => 'fixed',
	) ) );
}
endif; // cucina_setup
add_action( 'after_setup_theme', 'cucina_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function cucina_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'cucina' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'cucina_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cucina_scripts() {
	wp_enqueue_style( 'cucina-style', get_stylesheet_uri() );

	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', array(), '3.1.8', true );

	wp_enqueue_script( 'cucina', get_template_directory_uri() . '/js/cucina.js', array( 'masonry', 'imagesloaded', 'jquery' ), '20120206', true );

	wp_enqueue_script( 'cucina-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cucina_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';
