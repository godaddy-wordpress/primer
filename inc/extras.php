<?php
/**
 * Special hooks and overrides for this theme.
 *
 * @package Primer
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @filter wp_page_menu_args
 *
 * @param  array $args
 *
 * @return array
 */
function primer_page_menu_args( array $args ) {

	$args['show_home'] = true;

	return $args;

}
add_filter( 'wp_page_menu_args', 'primer_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @filter body_class
 *
 * @param  array $classes
 *
 * @return array
 */
function primer_body_class( array $classes ) {

	if ( is_multi_author() ) {

		$classes[] = 'group-blog';

	}

	return $classes;

}
add_filter( 'body_class', 'primer_body_class' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @filter wp_title
 *
 * @param  string $title
 * @param  string $sep
 *
 * @return string
 */
function primer_wp_title( $title, $sep ) {

	if ( is_feed() ) {

		return $title;

	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) ) {

		$title .= sprintf(
			' %s %s',
			$sep, // xss ok
			$site_description // xss ok
		);

	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {

		$title .= sprintf(
			' %s %s',
			$sep, // xss ok
			sprintf(
				esc_html_x( 'Page %d', 'page number', 'primer' ),
				max( $paged, $page )
			)
		);

	}

	return $title;

}
add_filter( 'wp_title', 'primer_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @action wp
 *
 * @global WP_Query $wp_query
 */
function primer_setup_author() {

	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {

		global $authordata;

		$authordata = get_userdata( $wp_query->post->post_author );

	}

}
add_action( 'wp', 'primer_setup_author' );

/**
 * Reset the transient for the active categories check.
 *
 * @action create_category
 * @action edit_category
 * @action delete_category
 * @action save_post
 *
 * @see primer_has_active_categories()
 */
function primer_has_active_categories_reset() {

	delete_transient( 'primer_has_active_categories' );

}
add_action( 'create_category', 'primer_has_active_categories_reset' );
add_action( 'edit_category',   'primer_has_active_categories_reset' );
add_action( 'delete_category', 'primer_has_active_categories_reset' );
add_action( 'save_post',       'primer_has_active_categories_reset' );

/**
* Converts a HEX value to RGB.
*
* @since primer 1.0
*
* @param string $color The original color, in 3- or 6-digit hexadecimal form.
* @return array Array containing RGB (red, green, and blue) values for the given
*               HEX code, empty array otherwise.
*/
function primer_hex2rgb( $color ) {
	$color = trim( $color, '#' );
	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}
