<?php
/**
 * Cucina functions and definitions
 *
 * @package Cucina
 */

if ( ! defined( 'CUCINA_VERSION' ) ) {
	define( 'CUCINA_VERSION', time() );
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 535; /* pixels */
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
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add custom TinyMCE CSS
	// add_editor_style( array( 'editor-style.css', cucina_fonts_url() ) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 535, 535, true ); // 535 for the width of the river view
	add_image_size( 'square-thumbnail', 250, 250, true );
	add_image_size( 'page-header', 880, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'cucina' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'cucina_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => get_template_directory_uri() . '/images/cocina.gif',
		'default-attachment' => 'fixed',
	) ) );
}
endif; // cucina_setup
add_action( 'after_setup_theme', 'cucina_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
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

	register_sidebar( array(
		'name'          => __( 'Footer', 'cucina' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Lives below your content, and is full-width.', 'cucina' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( '404 Page', 'cucina' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Use this space to give visitors suggestions when they end up on a "Not Found" page.', 'cucina' ),
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
	wp_enqueue_style( 'cucina-style', get_stylesheet_uri(), array(), CUCINA_VERSION );

	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', array(), '3.1.8', true );

	wp_enqueue_script( 'cucina', get_template_directory_uri() . '/js/cucina.js', array( 'masonry', 'imagesloaded', 'jquery' ), CUCINA_VERSION, true );

	wp_enqueue_script( 'cucina-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Only load if Jetpack is active and version is >= 3.4
	if ( defined( 'JETPACK__VERSION' ) && version_compare( JETPACK__VERSION, '3.4', '>=' ) ) {
		wp_enqueue_script( 'museum-jetpack-fix', get_template_directory_uri() . '/js/jetpack-infscroll-fix.js', array(), CUCINA_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cucina_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Sacramento and Raleway by default is localized.
 * For languages that use characters not supported by either
 * font, the font can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function cucina_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Sacramento, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$sacramento = _x( 'on', 'Sacramento font: on or off', 'cucina' );

	/* Translators: If there are characters in your language that are not
	 * supported by Quattrocento Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$quattrocento = _x( 'on', 'Quattrocento Sans font: on or off', 'cucina' );

	if ( 'off' !== $sacramento || 'off' !== $quattrocento ) {
		$font_families = array();

		if ( 'off' !== $sacramento ) {
			$font_families[] = urlencode( 'Sacramento:400' );
		}

		if ( 'off' !== $quattrocento ) {
			$font_families[] = urlencode( 'Quattrocento Sans:500,500italic,600,700,700italic' );
		}

		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'cucina-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @return void
 */
function cucina_fonts() {
	$fonts_url = cucina_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'cucina-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'cucina_fonts' );

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
require get_template_directory() . '/inc/jetpack.php';
