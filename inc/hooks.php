<?php
/**
 * Custom actions for this theme.
 *
 * @package  Hooks
 * @category Core
 * @author   GoDaddy
 * @since    1.0.0
 */

/**
 * Display some elements conditionally (Primer only).
 *
 * @action template_redirect
 * @since  1.0.0
 */
function primer_elements() {

	if ( is_child_theme() ) {

		return;

	}

	if ( is_home() ) {

		remove_action( 'primer_after_header', 'primer_add_page_title', 12 );

	}

}
add_action( 'template_redirect', 'primer_elements' );

/**
 * Display the video header.
 *
 * @action primer_before_header_wrapper
 * @since  1.7.0
 */
function primer_video_header() {

	if ( ! is_front_page() || ! function_exists( 'has_header_video' ) || ! has_header_video() ) {

		return;

	}

	the_custom_header_markup();

}
add_action( 'primer_before_header_wrapper', 'primer_video_header', 5 );

/**
 * Display site title in the header.
 *
 * @action primer_header
 * @since  1.0.0
 */
function primer_add_site_title() {

	get_template_part( 'templates/parts/site-title' );

}
add_action( 'primer_header', 'primer_add_site_title', primer_child_compat( 'header__add_site_title', 5 ) );

/**
 * Display hero element in the header.
 *
 * @action primer_header
 * @since  1.0.0
 */
function primer_add_hero() {

	if ( ! is_404() ) {

		get_template_part( 'templates/parts/hero' );

	}

}
add_action( 'primer_header', 'primer_add_hero', primer_child_compat( 'header__add_hero', 7 ) );

/**
 * Display content in the hero element.
 *
 * @action primer_hero
 * @since  1.0.0
 */
function primer_add_hero_content() {

	if ( is_front_page() && is_active_sidebar( 'hero' ) ) {

		dynamic_sidebar( 'hero' );

	}

}
add_action( 'primer_hero', 'primer_add_hero_content' );

/**
 * Display mobile menu html.
 *
 * @action primer_before_site_navigation
 * @since  1.0.0
 */
function primer_add_mobile_menu() {

	get_template_part( 'templates/parts/mobile-menu' );

}
add_action( 'primer_before_site_navigation', 'primer_add_mobile_menu' );

/**
 * Add primary menu.
 *
 * @action primer_site_navigation
 * @since 1.0.0
 */
function primer_add_primary_menu() {

	if ( ! has_nav_menu( 'primary' ) ) {

		wp_page_menu(
			array(
				'depth'     => 1, // Top-level only.
				'show_home' => true,
			)
		);

		return;

	}

	add_filter( 'walker_nav_menu_start_el', 'primer_add_primary_nav_sub_menu_buttons', 10, 3 );

	wp_nav_menu(
		array(
			'theme_location' => 'primary',
		)
	);

	remove_filter( 'walker_nav_menu_start_el', 'primer_add_primary_nav_sub_menu_buttons', 10 );
}
add_action( 'primer_site_navigation', 'primer_add_primary_menu' );

/**
 * Filter the HTML output of a nav menu item to add the AMP dropdown button to reveal the sub-menu.
 *
 * @link https://amp-wp.org/documentation/playbooks/navigation-sub-menu-buttons/()
 * @param string $item_output   Nav menu item HTML.
 * @param object $item          Nav menu item.
 * @param int    $depth         Depth.
 * @return string Modified nav menu item HTML.
 */
function primer_add_primary_nav_sub_menu_buttons( $item_output, $item, $depth ) {

	// Skip when the item has no sub-menu.
	if ( ! in_array( 'menu-item-has-children', $item->classes, true ) ) {
		return $item_output;
	}

	$indent = str_repeat( "\t", $depth );

	$item_output .= "\n";

	// @todo Why not a <button>?
	$expand_attrs = ' class="expand" role="button" tabindex="0"';

	// Add toggle behavior in AMP.
	if ( primer_is_amp() ) {
		$expand_attrs .= sprintf(
			' on="%s"',
			esc_attr(
				sprintf(
					'tap:menu-item-%d.toggleClass(class="open")',
					$item->ID
				)
			)
		);
	}

	$item_output .= "{$indent}<span {$expand_attrs}></span>\n";

	return $item_output;
}

/**
 * Display primary navigation menu after the header.
 *
 * @action primer_after_header
 * @since  1.0.0
 */
function primer_add_primary_navigation() {

	get_template_part( 'templates/parts/primary-navigation' );

}
add_action( 'primer_after_header', 'primer_add_primary_navigation', primer_child_compat( 'after_header__add_primary_navigation', 11 ) );

/**
 * Display page titles after the header.
 *
 * @action primer_after_header
 * @since  1.0.0
 */
function primer_add_page_title() {

	if ( primer_get_the_page_title() ) {

		get_template_part( 'templates/parts/page-title' );

	}

}
add_action( 'primer_after_header', 'primer_add_page_title', primer_child_compat( 'after_header__add_page_title', 12 ) );

/**
 * Display post meta template.
 *
 * @action primer_after_post_title_template
 * @since 1.0.0
 */
function primer_add_post_meta() {

	get_template_part( 'templates/parts/loop/post', 'meta' );

}
add_action( 'primer_after_post_title_template', 'primer_add_post_meta' );

/**
 * Display widget areas in the footer.
 *
 * @action primer_footer
 * @since  1.0.0
 */
function primer_add_footer_widgets() {

	get_template_part( 'templates/parts/footer-widgets' );

}
add_action( 'primer_footer', 'primer_add_footer_widgets' );

/**
 * Display site info after the footer.
 *
 * @action primer_after_footer
 * @since  1.0.0
 */
function primer_add_site_info() {

	get_template_part( 'templates/parts/site-info' );

}
add_action( 'primer_after_footer', 'primer_add_site_info' );

/**
 * Display footer navigation menu in the footer.
 *
 * @action primer_site_info
 * @since  1.0.0
 */
function primer_add_footer_navigation() {

	if ( has_nav_menu( 'footer' ) ) {

		get_template_part( 'templates/parts/footer-navigation' );

	}

}
add_action( 'primer_site_info', 'primer_add_footer_navigation', 5 );

/**
 * Display social navigation menu in the footer.
 *
 * @action primer_site_info
 * @since  1.0.0
 */
function primer_add_social_navigation() {

	if ( has_nav_menu( 'social' ) ) {

		get_template_part( 'templates/parts/social-navigation' );

	}

}
add_action( 'primer_site_info', 'primer_add_social_navigation', 7 );

/**
 * Display credit in the footer.
 *
 * @action primer_site_info
 * @since  1.0.0
 */
function primer_add_credit() {

	get_template_part( 'templates/parts/credit' );

}
add_action( 'primer_site_info', 'primer_add_credit' );

/**
 * Display privacy policy link
 *
 * @action the_privacy_policy_link
 * @since  1.8.3
 */
function primer_privacy_policy_link() {

	if ( function_exists( 'the_privacy_policy_link' ) ) {

		/**
		 * Filter the footer privacy policy link display.
		 *
		 * @since 1.8.3
		 *
		 * @var bool
		 */
		if ( ! (bool) apply_filters( 'primer_privacy_policy_link', true ) ) {

			return;

		}

		the_privacy_policy_link();

	}

}
add_action( 'primer_site_info', 'primer_privacy_policy_link', 7 );

/**
 * Set the post excerpt length to 20 words.
 *
 * To override this in a child theme, remove the filter and add
 * your own function tied to the `excerpt_length` filter hook:
 *
 * ```
 * remove_filter( 'excerpt_length', 'primer_excerpt_length' );
 * add_filter( 'excerpt_length', function() { return 30; } );
 * ```
 *
 * @filter excerpt_length
 * @link   https://developer.wordpress.org/reference/hooks/excerpt_length/
 * @since  1.0.0
 *
 * @param  int $number The number of words. Default is `55`.
 *
 * @return int Return the maximum number of words to use for excerpts.
 */
function primer_excerpt_length( $number ) {

	return 20;

}
add_filter( 'excerpt_length', 'primer_excerpt_length' );

/**
 * Replace "[...]" with an ellipsis.
 *
 * To override this in a child theme, remove the filter and add
 * your own function tied to the `excerpt_more` filter hook:
 *
 * ```
 * remove_filter( 'excerpt_more', 'primer_excerpt_more' );
 * add_filter( 'excerpt_more', function() { return '...and more'; } );
 * ```
 *
 * @filter excerpt_more
 * @link   https://developer.wordpress.org/reference/hooks/excerpt_more/
 * @since  1.0.0
 *
 * @param  string $more_string The string shown within the more link.
 *
 * @return string Returns the string in the “more” link displayed after a trimmed excerpt.
 */
function primer_excerpt_more( $more_string ) {

	return ! is_admin() ? '&hellip;' : $more_string;

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
 * @param  string $tag    The `<script>` tag for the enqueued script.
 * @param  string $handle The script's registered handle.
 *
 * @return string Returns the HTML script tag of an enqueued script.
 */
function primer_conditional_jquery_tag( $tag, $handle ) {

	return ( 'jquery' === $handle ) ? "<!--[if (gte IE 9) | (!IE)]><!-->$tag<!--<![endif]-->" : $tag;

}
add_filter( 'script_loader_tag', 'primer_conditional_jquery_tag', 10, 2 );

/**
 * Add custom body classes.
 *
 * @filter body_class
 * @since  1.0.0
 *
 * @param  array $classes An array of body classes.
 *
 * @return array Returns an array of body classes.
 */
function primer_body_class( array $classes ) {

	if ( is_multi_author() ) {

		$classes[] = 'group-blog';

	}

	if ( has_header_image() ) {

		$classes[] = 'custom-header-image';

	}

	return $classes;

}
add_filter( 'body_class', 'primer_body_class' );

/**
 * Alter the `<title>` tag based on what is being viewed.
 *
 * @filter wp_title
 * @global int $page
 * @global int $paged
 * @since  1.0.0
 *
 * @param  string $title Page title.
 * @param  string $sep   Title separator.
 *
 * @return string Return the page title.
 */
function primer_wp_title( $title, $sep ) {

	if ( is_feed() ) {

		return $title;

	}

	global $page, $paged;

	// Add the blog name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) ) {

		$title .= sprintf(
			' %s %s',
			$sep,
			$site_description
		);

	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {

		$title .= sprintf(
			' %s %s',
			$sep,
			sprintf(
				/* translators: page number */
				esc_html__( 'Page %d', 'primer' ),
				max( $paged, $page )
			)
		);

	}

	return $title;

}
add_filter( 'wp_title', 'primer_wp_title', 10, 2 );

/**
 * Filter the site title HTML wrapper.
 *
 * @filter primer_the_site_title_args
 * @since  1.8.0
 *
 * @param  array $args The site title args.
 *
 * @return array
 */
function primer_the_site_title_wrapper( $args ) {

	if ( is_home() ) {

		$args['wrapper'] = 'h1';

	}

	return $args;

}
add_filter( 'primer_the_site_title_args', 'primer_the_site_title_wrapper' );

/**
 * Filter the page title HTML wrapper.
 *
 * @filter primer_the_page_title_args
 * @since  1.8.0
 *
 * @param  array $args The page title args.
 *
 * @return array
 */
function primer_the_page_title_wrapper( $args ) {

	if ( is_single() ) {

		$args['wrapper'] = 'h2';

	}

	return $args;

}
add_filter( 'primer_the_page_title_args', 'primer_the_page_title_wrapper' );

/**
 * Customize the default pagination links template.
 *
 * @filter navigation_markup_template
 * @since  1.6.0
 *
 * @param  string $template The navigation template.
 * @param  string $class    The class passed by the calling function.
 *
 * @return string
 */
function primer_pagination_template( $template, $class ) {

	if ( 'pagination' !== $class ) {

		return $template;

	}

	global $wp_query;

	$search  = '<div class="nav-links">';
	$replace = sprintf(
		'<div class="paging-nav-text">%s</div>%s',
		sprintf(
			/* translators: 1. current page number, 2. total number of pages */
			esc_html__( 'Page %1$d of %2$d', 'primer' ),
			max( 1, get_query_var( 'paged' ) ),
			absint( $wp_query->max_num_pages )
		),
		$search
	);

	return str_replace( $search, $replace, $template );

}
add_filter( 'navigation_markup_template', 'primer_pagination_template', 10, 2 );
