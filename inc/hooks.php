<?php
/**
 * Custom actions for this theme.
 *
 * @package Primer
 */

/**
 * Display site title in the header.
 *
 * @action primer_header
 * @since  1.0.0
 */
function primer_add_site_title() {

	get_template_part( 'templates/parts/site-title' );

}
add_action( 'primer_header', 'primer_add_site_title', 5 );

/**
 * Display primary navigation menu after the header.
 *
 * @action primer_after_header
 * @since  1.0.0
 */
function primer_add_primary_navigation() {

	get_template_part( 'templates/parts/primary-navigation' );

}
add_action( 'primer_after_header', 'primer_add_primary_navigation', 20 );

/**
 * Display widget areas in the footer.
 *
 * @action primer_footer
 * @since  1.0.0
 */
function primer_add_footer_widgets() {

	get_template_part( 'templates/parts/footer-widgets' );

}
add_action( 'primer_footer', 'primer_add_footer_widgets', 5 );

/**
 * Display site info after the footer.
 *
 * @action primer_after_footer
 * @since  1.0.0
 */
function primer_add_site_info() {

	get_template_part( 'templates/parts/site-info' );

}
add_action( 'primer_after_footer', 'primer_add_site_info', 20 );

/**
 * Set the post excerpt length to 20 words.
 *
 * To override this in a child theme, remove the filter and add
 * your own function tied to the `excerpt_length` filter hook:
 *
 * remove_filter( 'excerpt_length', 'primer_excerpt_length' );
 * add_filter( 'excerpt_length', function() { return 30; } );
 *
 * @filter excerpt_length
 * @link   https://developer.wordpress.org/reference/hooks/excerpt_length/
 * @since  1.0.0
 *
 * @return int
 */
function primer_excerpt_length( $length ) {

	return 20;

}
add_filter( 'excerpt_length', 'primer_excerpt_length' );

/**
 * Replace "[...]" with an ellipsis.
 *
 * To override this in a child theme, remove the filter and add
 * your own function tied to the `excerpt_more` filter hook:
 *
 * remove_filter( 'excerpt_more', 'primer_excerpt_more' );
 * add_filter( 'excerpt_more', function() { return '...and more'; } );
 *
 * @filter excerpt_more
 * @link   https://developer.wordpress.org/reference/hooks/excerpt_more/
 * @since  1.0.0
 *
 * @return string
 */
function primer_excerpt_more( $more ) {

	return ! is_admin() ? '&hellip;' : $more;

}
add_filter( 'excerpt_more', 'primer_excerpt_more' );

/**
 * Wrap the jQuery script tag in a conditional comment.
 *
 * This technique allows non-IE 9 (and lower) browsers to use the
 * latest version of jQuery.
 *
 * To override this behavior in a child theme, remove the filter:
 *
 * remove_filter( 'script_loader_tag', 'primer_conditional_jquery_tag', 10, 2 );
 *
 * @filter script_loader_tag
 * @link   https://developer.wordpress.org/reference/hooks/script_loader_tag/
 * @since  1.0.0
 *
 * @param  string $tag
 * @param  string $handle
 *
 * @return string
 */
function primer_conditional_jquery_tag( $tag, $handle ) {

	return ( 'jquery' === $handle ) ? "<!--[if (gte IE 9) | (!IE)]><!-->$tag<!--<![endif]-->" : $tag;

}
add_filter( 'script_loader_tag', 'primer_conditional_jquery_tag', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @filter wp_page_menu_args
 * @since  1.0.0
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
 * @since  1.0.0
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
 * @global int $page
 * @global int $paged
 * @since  1.0.0
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
