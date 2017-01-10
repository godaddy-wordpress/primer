<?php
/**
 * Custom helper functions for this theme.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Return a page title based on the current page.
 *
 * @return string
 */
function primer_get_the_page_title() {

	$title = '';

	switch ( true ) {

		case is_front_page() :

			$title = get_the_title( get_option( 'page_on_front' ) );

			break;

		case is_home() :

			$title = get_the_title( get_option( 'page_for_posts' ) );

			break;

		case is_archive() :

			$title = get_the_archive_title();

			break;

		case is_search() :

			$title = sprintf(
				esc_html_x( 'Search Results for: %s', 'search term', 'primer' ),
				sprintf(
					'<span>%s</span>',
					get_search_query()
				)
			);

			break;

		case is_404() :

			$title = esc_html__( '404 Page Not Found', 'primer' );

			break;

		case is_page() :

			$title = get_the_title();

			break;

		case ( ( $post = get_queried_object() ) && ! is_post_type_hierarchical( get_post_type( $post ) ) ) :

			$show_on_front  = get_option( 'show_on_front' );
			$page_for_posts = get_option( 'page_for_posts' );

			if ( 'post' === $post->post_type && 'posts' !== $show_on_front && ! empty( $page_for_posts ) ) {

				$title = get_the_title( $page_for_posts );

				break;

			}

			$labels = get_post_type_labels( get_post_type_object( $post->post_type ) );

			$title = isset( $labels->name ) ? $labels->name : false;

			break;

	}

	/**
	 * Filter the page title.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return (string) apply_filters( 'primer_the_page_title', $title );

}

/**
 * Return the current page width setting.
 *
 * @return string
 */
function primer_get_page_width() {

	return get_theme_mod( 'page_width', 'fixed' );

}

/**
 * Check if pages are being displayed with fluid width.
 *
 * @return bool
 */
function primer_is_fluid_width() {

	return ( 'fluid' === primer_get_page_width() );

}

/**
 * Check if pages are being displayed with fixed width.
 *
 * @return bool
 */
function primer_is_fixed_width() {

	return ( 'fixed' === primer_get_page_width() );

}

/**
 * Return the current layout.
 *
 * @global Primer_Customizer_Layouts $primer_customizer_layouts
 * @since  1.0.0
 *
 * @param  int $post_id (optional)
 *
 * @return string
 */
function primer_get_layout( $post_id = null ) {

	global $primer_customizer_layouts;

	$post_id = ( $post_id ) ? $post_id : get_queried_object_id();

	return $primer_customizer_layouts->get_current_layout( $post_id );

}

/**
 * Return the global layout.
 *
 * @global Primer_Customizer_Layouts $primer_customizer_layouts
 * @since  1.0.0
 *
 * @return string
 */
function primer_get_global_layout() {

	global $primer_customizer_layouts;

	return $primer_customizer_layouts->get_global_layout();

}

/**
 * Check if the current layout has a sidebar.
 *
 * @since 1.0.0
 *
 * @param  string $layout (optional)
 *
 * @return bool
 */
function primer_layout_has_sidebar( $layout = null ) {

	$layout      = ( $layout ) ? $layout : primer_get_layout();
	$has_sidebar = ! in_array( $layout, array( 'one-column-wide', 'one-column-narrow' ) );

	/**
	 * Filter if the current layout has a sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @param string $layout
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'primer_layout_has_sidebar', $has_sidebar, $layout );

}

/**
 * Check if the site has a custom logo.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_has_custom_logo() {

 	/**
	 * For backwards compatibility prior to WordPress 4.5.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/has_custom_logo/
	 * @since 1.0.0
	 */
	$enabled = function_exists( 'has_custom_logo' ) ? has_custom_logo() : (bool) get_theme_mod( 'custom_logo' );

	/**
	 * Filter if the site has a custom logo.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'primer_has_custom_logo', $enabled );

}

/**
 * Return the hero image element selector.
 *
 * @since 1.0.0
 *
 * @return string
 */
function primer_get_hero_image_selector() {

	/**
	 * Filter the hero image element selector.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	$selector = (string) apply_filters( 'primer_hero_image_selector', '.site-header' );

	return wp_strip_all_tags( $selector );

}

/**
 * Check if a post's featured image should be the header image.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_use_featured_hero_image() {

	$enabled = (bool) get_theme_mod( 'use_featured_hero_image' );

	/**
	 * Filter if a post's featured image should be the header image.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'primer_use_featured_hero_image', $enabled );

}

/**
 * Check if there is a header image to display.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_has_hero_image() {

	return ( has_header_image() || ( primer_use_featured_hero_image() && has_post_thumbnail( get_queried_object() ) ) );

}

/**
 * Return the hero image URL.
 *
 * @since 1.0.0
 *
 * @return string|null
 */
function primer_get_hero_image() {

	/**
	 * Filter the hero image size.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	$size = (string) apply_filters( 'primer_hero_image_size', 'primer-hero' );

	/**
	 * Featured Image (if enabled)
	 */
	if ( primer_use_featured_hero_image() && ( $post = get_queried_object() ) && has_post_thumbnail( $post ) ) {

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), $size );

		if ( isset( $image[0] ) ) {

			return $image[0];

		}

	}

	/**
	 * Header Image
	 */
	if ( has_header_image() ) {

		$header = get_custom_header();

		if ( ! empty( $header->attachment_id ) ) {

			$image = wp_get_attachment_image_src( $header->attachment_id, $size );

			if ( isset( $image[0] ) ) {

				return $image[0];

			}

		}

		return get_header_image();

	}

}

/**
 * Return the size to use for featured images.
 *
 * @return string
 */
function primer_get_featured_image_size() {

	/**
	 * Filter the size to use for featured images.
	 *
	 * @var string
	 */
	return (string) apply_filters( 'primer_featured_image_size', 'primer-featured' );

}

/**
 * Return the posts page URL.
 *
 * In the event a custom homepage exists, we need
 * to find the posts page and return its URL.
 *
 * @since 1.0.0
 *
 * @return string
 */
function primer_get_posts_url() {

	$url = ( 'page' === get_option( 'show_on_front' ) ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : null;

	/**
	 * Filter the posts page URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return (string) apply_filters( 'primer_posts_url', $url );

}

/**
 * Return an array of footer widget areas.
 *
 * @global array $wp_registered_sidebars
 * @since  1.0.0
 *
 * @return array
 */
function primer_get_footer_sidebars() {

	global $wp_registered_sidebars;

	$sidebars = preg_grep( '/^footer-(.*)/', array_keys( $wp_registered_sidebars ) );

	/**
	 * Filter the array of footer widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	return (array) apply_filters( 'primer_footer_sidebars', $sidebars );

}

/**
 * Return an array of active footer widget areas.
 *
 * @since 1.0.0
 *
 * @return array
 */
function primer_get_active_footer_sidebars() {

	return array_filter( primer_get_footer_sidebars(), 'is_active_sidebar' );

}

/**
 * Check if there are active footer widget areas.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_has_active_footer_sidebars() {

	return (bool) primer_get_active_footer_sidebars();

}

/**
 * Check if a footer or social menu is assigned.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_has_footer_menu() {

	return ( has_nav_menu( 'footer' ) || has_nav_menu( 'social' ) );

}

/**
 * Check if the site has active categories.
 *
 * We will store the result in a transient so this function
 * can be called frequently without any performance concern.
 *
 * @see   primer_has_active_categories_reset()
 * @since 1.0.0
 *
 * @return bool
 */
function primer_has_active_categories() {

	if ( WP_DEBUG || false === ( $has_active_categories = get_transient( 'primer_has_active_categories' ) ) ) {

		$categories = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2, // We only care if more than 1 exists
			)
		);

		$has_active_categories = ( count( $categories ) > 1 );

		set_transient( 'primer_has_active_categories', $has_active_categories );

	}

	/**
	 * Filter if the site has active categories.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'primer_has_active_categories', ! empty( $has_active_categories ) );

}

/**
 * Convert a 3- or 6-digit hexadecimal color to an associative RGB array.
 *
 * @since 1.0.0
 *
 * @param  string $color
 *
 * @return array
 */
function primer_hex2rgb( $color ) {

	$color = trim( $color, '#' );

	switch ( strlen( $color ) ) {

		case 3 :

			$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
			$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
			$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );

			break;

		case 6 :

			$r = hexdec( substr( $color, 0, 2 ) );
			$g = hexdec( substr( $color, 2, 2 ) );
			$b = hexdec( substr( $color, 4, 2 ) );

			break;

		default :

			return array();

	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );

}

/**
 * Recursively replace elements from passed arrays into the first array (safe for PHP 5.2).
 *
 * @author Frankie Jarrett <fjarrett@gmail.com>
 * @link   http://php.net/manual/en/function.array-replace-recursive.php
 * @since  1.0.0
 *
 * @param  array $array1
 * @param  array $array2
 * @param  array $...
 *
 * @return array
 */
function primer_array_replace_recursive( array $array1, array $array2 ) {

	if ( function_exists( 'array_replace_recursive' ) ) {

		return call_user_func_array( 'array_replace_recursive', func_get_args() );

	}

	$result = array();

	for ( $i = 0, $total = func_num_args(); $i < $total; $i++ ) {

		$_array = func_get_arg( $i );

		foreach ( $_array as $key => &$value ) {

			if ( is_array( $value ) && isset( $result[ $key ] ) && is_array( $result[ $key ] ) ) {

				$result[ $key ] = call_user_func( __FUNCTION__, $result[ $key ], $value );

				continue;

			}

			$is_assoc = ( array_keys( $_array ) !== range( 0, count( $_array ) - 1 ) );

			if ( ! $is_assoc && ! in_array( $value, $merged, true ) ) {

				$result[] = $value;

				continue;

			}

			$result[ $key ] = $value;

		}

	}

	return (array) $result;

}
