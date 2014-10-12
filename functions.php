<?php
/**
 * Basis functions and definitions
 *
 * @package Basis
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'basis_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function basis_setup() {

	global $post;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Basis, use a find and replace
	 * to change 'basis' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'basis', get_template_directory() . '/languages' );

	// Add image size for featured images
	add_image_size( 'featured', 1600, 900, 1 );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'basis' ),
		'social' => __( 'Social Menu', 'basis' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'basis_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add support for Jetpack featured content
	add_theme_support( 'featured-content', array(
		'filter'     => 'basis_get_featured_posts',
		'max_posts'  => 1,
		'post_types' => array( 'post', 'page' ),
	) );

}
endif; // basis_setup
add_action( 'after_setup_theme', 'basis_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function basis_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'basis' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Left', 'basis' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Center', 'basis' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Right', 'basis' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );
}
add_action( 'widgets_init', 'basis_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function basis_scripts() {
	wp_enqueue_style( 'basis', get_stylesheet_uri() );

	wp_style_add_data( 'basis', 'rtl', 'replace' );

	wp_enqueue_script( 'basis-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'basis-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'basis_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of PT Sans and Merriweather by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @return string	$fonts_url 	Font stylesheet or empty string if disabled.
 */
function basis_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by PT Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$pt_sans = _x( 'on', 'PT Sans font: on or off', 'basis' );

	/* Translators: If there are characters in your language that are not
	 * supported by Merriweather, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$poly = _x( 'on', 'Merriweather font: on or off', 'basis' );

	if ( 'off' !== $pt_sans || 'off' !== $poly ) {
		$font_families = array();

		if ( 'off' !== $pt_sans )
			$font_families[] = 'PT Sans:400,600,700';

		if ( 'off' !== $poly )
			$font_families[] = 'Merriweather:400,400italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Define a custom excerpt length.
 */
function custom_excerpt_length( $length ) {
	return 20;
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Define custom excerpt more.
 */
function new_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'new_excerpt_more');
/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Includes template parts within the theme.
 */
require get_template_directory() . '/inc/action-hooks.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';