<?php
/**
 * Custom actions for this theme.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Display some elements conditionally (Primer only).
 *
 * @action template_redirect
 * @since  1.0.0
 */
function the_primer_elements() {

	if ( is_child_theme() ) {

		return;

	}

	if ( is_front_page() ) {

		remove_action( 'the_primer_after_header', 'the_primer_add_page_title' );

	}

}
add_action( 'template_redirect', 'the_primer_elements' );

/**
 * Display site title in the header.
 *
 * @action the_primer_header
 * @since  1.0.0
 */
function the_primer_add_site_title() {

	get_template_part( 'templates/parts/site-title' );

}
add_action( 'the_primer_header', 'the_primer_add_site_title' );

/**
 * Display hero element in the header.
 *
 * @action the_primer_header
 * @since  1.0.0
 */
function the_primer_add_hero() {

	if ( ! is_404() ) {

		get_template_part( 'templates/parts/hero' );

	}

}
add_action( 'the_primer_header', 'the_primer_add_hero' );

/**
 * Display content in the hero element.
 *
 * @action the_primer_hero
 * @since  1.0.0
 */
function the_primer_add_hero_content() {

	if ( is_front_page() && is_active_sidebar( 'hero' ) ) {

		dynamic_sidebar( 'hero' );

	}

}
add_action( 'the_primer_hero', 'the_primer_add_hero_content' );

/**
 * Display mobile menu html.
 *
 * @action the_primer_before_site_navigation
 * @since  1.0.0
 */
function the_primer_add_mobile_menu() {

	get_template_part( 'templates/parts/mobile-menu' );

}
add_action( 'the_primer_before_site_navigation', 'the_primer_add_mobile_menu' );

/**
 * Add primary menu.
 *
 * @action the_primer_site_navigation
 * @since 1.0.0
 */
function the_primer_add_primary_menu() {

	if ( ! has_nav_menu( 'primary' ) ) {

		wp_page_menu(
			array(
				'depth'     => 1, // Top-level only
				'show_home' => true,
			)
		);

		return;

	}

	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'walker'         => new The_Primer_Walker_Nav_Menu,
		)
	);

}
add_action( 'the_primer_site_navigation', 'the_primer_add_primary_menu' );

/**
 * Display primary navigation menu after the header.
 *
 * @action the_primer_after_header
 * @since  1.0.0
 */
function the_primer_add_primary_navigation() {

	get_template_part( 'templates/parts/primary-navigation' );

}
add_action( 'the_primer_after_header', 'the_primer_add_primary_navigation' );

/**
 * Display page titles after the header.
 *
 * @action the_primer_after_header
 * @since  1.0.0
 */
function the_primer_add_page_title() {

	if ( the_primer_get_the_page_title() ) {

		get_template_part( 'templates/parts/page-title' );

	}

}
add_action( 'the_primer_after_header', 'the_primer_add_page_title' );

/**
 * Display post meta template.
 *
 * @action the_primer_after_post_title_template
 * @since 1.0.0
 */
function the_primer_add_post_meta() {

	get_template_part( 'templates/parts/loop/post', 'meta' );

}
add_action( 'the_primer_after_post_title_template', 'the_primer_add_post_meta' );

/**
 * Display widget areas in the footer.
 *
 * @action the_primer_footer
 * @since  1.0.0
 */
function the_primer_add_footer_widgets() {

	get_template_part( 'templates/parts/footer-widgets' );

}
add_action( 'the_primer_footer', 'the_primer_add_footer_widgets' );

/**
 * Display site info after the footer.
 *
 * @action the_primer_after_footer
 * @since  1.0.0
 */
function the_primer_add_site_info() {

	get_template_part( 'templates/parts/site-info' );

}
add_action( 'the_primer_after_footer', 'the_primer_add_site_info' );

/**
 * Display footer navigation menu in the footer.
 *
 * @action the_primer_site_info
 * @since  1.0.0
 */
function the_primer_add_footer_navigation() {

	if ( has_nav_menu( 'footer' ) ) {

		get_template_part( 'templates/parts/footer-navigation' );

	}

}
add_action( 'the_primer_site_info', 'the_primer_add_footer_navigation', 5 );

/**
 * Display social navigation menu in the footer.
 *
 * @action the_primer_site_info
 * @since  1.0.0
 */
function the_primer_add_social_navigation() {

	if ( has_nav_menu( 'social' ) ) {

		get_template_part( 'templates/parts/social-navigation' );

	}

}
add_action( 'the_primer_site_info', 'the_primer_add_social_navigation', 7 );

/**
 * Display credit in the footer.
 *
 * @action the_primer_site_info
 * @since  1.0.0
 */
function the_primer_add_credit() {

	get_template_part( 'templates/parts/credit' );

}
add_action( 'the_primer_site_info', 'the_primer_add_credit' );

/**
 * Set the post excerpt length to 20 words.
 *
 * To override this in a child theme, remove the filter and add
 * your own function tied to the `excerpt_length` filter hook:
 *
 * remove_filter( 'excerpt_length', 'the_primer_excerpt_length' );
 * add_filter( 'excerpt_length', function() { return 30; } );
 *
 * @filter excerpt_length
 * @link   https://developer.wordpress.org/reference/hooks/excerpt_length/
 * @since  1.0.0
 *
 * @return int
 */
function the_primer_excerpt_length( $length ) {

	return 20;

}
add_filter( 'excerpt_length', 'the_primer_excerpt_length' );

/**
 * Replace "[...]" with an ellipsis.
 *
 * To override this in a child theme, remove the filter and add
 * your own function tied to the `excerpt_more` filter hook:
 *
 * remove_filter( 'excerpt_more', 'the_primer_excerpt_more' );
 * add_filter( 'excerpt_more', function() { return '...and more'; } );
 *
 * @filter excerpt_more
 * @link   https://developer.wordpress.org/reference/hooks/excerpt_more/
 * @since  1.0.0
 *
 * @return string
 */
function the_primer_excerpt_more( $more ) {

	return ! is_admin() ? '&hellip;' : $more;

}
add_filter( 'excerpt_more', 'the_primer_excerpt_more' );

/**
 * Wrap the jQuery script tag in a conditional comment.
 *
 * This technique allows non-IE 9 (and lower) browsers to use the
 * latest version of jQuery.
 *
 * To override this behavior in a child theme, remove the filter:
 *
 * remove_filter( 'script_loader_tag', 'the_primer_conditional_jquery_tag', 10, 2 );
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
function the_primer_conditional_jquery_tag( $tag, $handle ) {

	return ( 'jquery' === $handle ) ? "<!--[if (gte IE 9) | (!IE)]><!-->$tag<!--<![endif]-->" : $tag;

}
add_filter( 'script_loader_tag', 'the_primer_conditional_jquery_tag', 10, 2 );

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
function the_primer_body_class( array $classes ) {

	if ( is_multi_author() ) {

		$classes[] = 'group-blog';

	}

	if ( has_header_image() ) {

		$classes[] = 'custom-header-image';

	}

	return $classes;

}
add_filter( 'body_class', 'the_primer_body_class' );

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
function the_primer_wp_title( $title, $sep ) {

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
				esc_html_x( 'Page %d', 'page number', 'the-primer' ),
				max( $paged, $page )
			)
		);

	}

	return $title;

}
add_filter( 'wp_title', 'the_primer_wp_title', 10, 2 );
