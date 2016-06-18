<?php
/**
 * Theme functions and definitions.
 *
 * @package Primer
 */

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

/**
 * Load custom theme layout functionality.
 */
require get_template_directory() . '/inc/theme-layouts.php';

/**
 * Set the content width based on the theme design and stylesheet.
 *
 * @link https://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {

	global $content_width;

	switch ( theme_layouts_get_layout() ) {

		case 'one-column-wide' :

			$content_width = 1068;

		case 'one-column-narrow' :

			$content_width = 688;

		default :

			$content_width = 688;

	}

}

if ( ! function_exists( 'primer_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the 'after_setup_theme' hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function primer_setup() {

		/**
		 * Load theme translations.
		 *
		 * Translations can be filed in the /languages/ directory. If you're
		 * building a theme based on Primer, use a find and replace to change
		 * 'primer' to the name of your theme in all the template files.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/load_theme_textdomain
		 */
		load_theme_textdomain( 'primer', get_template_directory() . '/languages' );

		/**
		 * Add image size for Featured Images.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_image_size
		 */
		add_image_size( 'primer-featured', 1600, 900, 1 );

		/**
		 * Enable support for Automatic Feed Links.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for plugins and themes to manage the document title tag.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register custom Custom Navigation Menus.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'primer' ),
				'social'  => __( 'Social Menu', 'primer' ),
			)
		);

		/**
		 * Enable support for theme layouts in Hybrid Core.
		 */
		add_theme_support(
			'theme-layouts',
			array(
				'one-column-wide'       => __( '1 Column Wide',                          'primer' ),
				'one-column-narrow'     => __( '1 Column Narrow',                        'primer' ),
				'two-column-default'    => __( '2 Columns: Content / Sidebar',           'primer' ),
				'two-column-reversed'   => __( '2 Columns: Sidebar / Content',           'primer' ),
				'three-column-default'  => __( '3 Columns: Content / Sidebar / Sidebar', 'primer' ),
				'three-column-center'   => __( '3 Columns: Sidebar / Content / Sidebar', 'primer' ),
				'three-column-reversed' => __( '3 Columns: Sidebar / Sidebar / Content', 'primer' ),
			),
			array( 'default' => 'two-column-default' )
		);

		/**
		 * Enable support for HTML5 markup.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Enable support for Post Formats.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		/**
		 * Enable support for Custom Background.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Background
		 */
		add_theme_support(
			'custom-background',
			apply_filters(
				'primer_custom_background_args',
				array(
					'default-color' => 'e7e7e7',
					'default-image' => '',
				)
			)
		);

		/**
		 * Enable support for featured content in Jetpack.
		 *
		 * @link https://jetpack.com/support/featured-content/#theme-support
		 */
		add_theme_support(
			'featured-content',
			array(
				'filter'     => 'primer_get_featured_posts',
				'max_posts'  => 1,
				'post_types' => array( 'post', 'page' ),
			)
		);

	}

}

add_action( 'after_setup_theme', 'primer_setup' );

if ( ! function_exists( 'primer_widgets_init' ) ) {

	/**
	 * Register widget area.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	function primer_widgets_init() {

		register_sidebar(
			array(
				'name'          => __( 'Sidebar', 'primer' ),
				'id'            => 'sidebar-1',
				'description'   => __( 'The primary sidebar appears alongside the content of every page, post, archive, and search template.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Secondary Sidebar', 'primer' ),
				'id'            => 'sidebar-2',
				'description'   => __( 'The secondary sidebar will only appear when you have selected a three-column layout.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Left', 'primer' ),
				'id'            => 'footer-1',
				'description'   => __( 'The footer left sidebar appears in the first column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Center', 'primer' ),
				'id'            => 'footer-2',
				'description'   => __( 'The footer center sidebar appears in the second column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Right', 'primer' ),
				'id'            => 'footer-3',
				'description'   => __( 'The footer right sidebar appears in the third column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);

	}

}

add_action( 'widgets_init', 'primer_widgets_init' );

if ( ! function_exists( 'primer_scripts' ) ) {

	/**
	 * Enqueue theme scripts and styles.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 * @link https://codex.wordpress.org/Function_Reference/wp_enqueue_script
	 */
	function primer_scripts() {

		$primer  = wp_get_theme();
		$version = apply_filters( 'theme_version', $primer->Version );

		wp_enqueue_style( 'primer', get_stylesheet_uri(), false, $version );

		wp_style_add_data( 'primer', 'rtl', 'replace' );

		wp_enqueue_script( 'primer-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), $version, true );
		wp_enqueue_script( 'primer-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), $version, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

			wp_enqueue_script( 'comment-reply' );

		}

	}

}

add_action( 'wp_enqueue_scripts', 'primer_scripts' );

if ( ! function_exists( 'primer_fonts_url' ) ) {

	/**
	 * Returns the Google font stylesheet URL, if available.
	 *
	 * The use of Lato and Merriweather by default is localized. For languages
	 * that use characters not supported by the font, the font can be disabled.
	 *
	 * @return string|null
	 */
	function primer_fonts_url() {

		$fonts_url = null;

		/* Translators: If there are characters in your language that are not
		 * supported by Lato, translate this to 'off' and do not translate
		 * into your own language.
		 */
		$lato = _x( 'on', 'Lato font: on or off', 'primer' );

		/* Translators: If there are characters in your language that are not
		 * supported by Merriweather, translate this to 'off' and do not translate
		 * into your own language.
		 */
		$poly = _x( 'on', 'Merriweather font: on or off', 'primer' );

		if ( 'off' !== $lato || 'off' !== $poly ) {

			$font_families = array();

			if ( 'off' !== $lato ) {

				$font_families[] = 'Lato:300,700';

			}

			if ( 'off' !== $poly ) {

				$font_families[] = 'Merriweather:400,400italic';

			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

		}

		return $fonts_url;

	}

}

if ( ! function_exists( 'primer_custom_excerpt_length' ) ) {

	/**
	 * Custom length (in words) for excerpts before they are truncated.
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_length
	 *
	 * @return int
	 */
	function primer_custom_excerpt_length( $length ) {

		return 20;

	}

}

add_filter( 'excerpt_length', 'primer_custom_excerpt_length', 999 );

if ( ! function_exists( 'primer_new_excerpt_more' ) ) {

	/**
	 * Custom ending for excerpts when they have been truncated.
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_more
	 *
	 * @return string
	 */
	function primer_new_excerpt_more( $more ) {

		return '&hellip;';

	}

}

add_filter( 'excerpt_more', 'primer_new_excerpt_more' );
