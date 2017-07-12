<?php
/**
 * Custom template tags for this theme.
 *
 * @package  Functions
 * @category Core
 * @author   GoDaddy
 * @since    1.0.0
 */

/**
 * Display a custom logo.
 *
 * @since 1.0.0
 */
function primer_the_custom_logo() {

	/**
	 * For backwards compatibility prior to WordPress 4.5.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/the_custom_logo/
	 * @since 1.0.0
	 */
	if ( function_exists( 'the_custom_logo' ) ) {

		the_custom_logo();

		return;

	}

	$custom_logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $custom_logo_id && ! is_customize_preview() ) {

		return;

	}

	/**
	 * Filter the custom logo display args.
	 *
	 * @since 1.8.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_the_custom_logo_args', array(
		'class'    => 'custom-logo',
		'itemprop' => 'logo',
	) );

	printf( // xss ok.
		'<a href="%1$s" class="custom-logo-link" %2$s>%3$s</a>',
		esc_url( home_url( '/' ) ),
		$custom_logo_id ? 'rel="home" itemprop="url"' : 'style="display:none;"',
		$custom_logo_id ? wp_get_attachment_image( $custom_logo_id, 'full', false, $args ) : '<img class="custom-logo"/>'
	);

}

/**
 * Display the site title.
 *
 * @since 1.0.0
 */
function primer_the_site_title() {

	/**
	 * Filter the site title display args.
	 *
	 * @since 1.8.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_the_site_title_args', array(
		'wrapper'   => 'div',
		'atts'      => array( 'class' => 'site-title' ),
		'url'       => home_url( '/' ),
		'link_atts' => array( 'rel' => 'home' ),
		'title'     => get_bloginfo( 'name' ),
	) );

	if ( empty( $args['title'] ) ) {

		return;

	}

	$args['atts'] = empty( $args['atts'] ) ? array() : (array) $args['atts'];

	foreach ( $args['atts'] as $key => &$value ) {

		$value = sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $value ) );

	}

	$args['link_atts'] = empty( $args['link_atts'] ) ? array() : (array) $args['link_atts'];

	foreach ( $args['link_atts'] as $key => &$value ) {

		$value = sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $value ) );

	}

	$html = sprintf(
		'<a href="%s" %s>%s</a>',
		esc_url( $args['url'] ),
		implode( ' ', $args['link_atts'] ),
		$args['title']
	);

	if ( ! empty( $args['wrapper'] ) ) {

		$html = sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			sanitize_key( $args['wrapper'] ),
			implode( ' ', $args['atts'] ),
			$html
		);

	}

	/**
	 * Filter the site title HTML.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo (string) apply_filters( 'primer_the_site_title', $html ); // xss ok.

}

/**
 * Display the site description.
 *
 * @since 1.0.0
 */
function primer_the_site_description() {

	/**
	 * Filter the site description display args.
	 *
	 * @since 1.8.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_the_site_description_args', array(
		'wrapper'     => 'div',
		'atts'        => array( 'class' => 'site-description' ),
		'description' => get_bloginfo( 'description' ),
	) );

	if ( empty( $args['description'] ) ) {

		return;

	}

	$args['atts'] = empty( $args['atts'] ) ? array() : (array) $args['atts'];

	foreach ( $args['atts'] as $key => &$value ) {

		$value = sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $value ) );

	}

	$html = $args['description'];

	if ( ! empty( $args['wrapper'] ) ) {

		$html = sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			sanitize_key( $args['wrapper'] ),
			implode( ' ', $args['atts'] ),
			$html
		);

	}

	/**
	 * Filter the site description HTML.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	echo (string) apply_filters( 'primer_the_site_description', $html ); // xss ok.

}

/**
 * Display the page title.
 *
 * @since 1.0.0
 */
function primer_the_page_title() {

	/**
	 * Filter the page title display args.
	 *
	 * @since 1.8.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_the_page_title_args', array(
		'wrapper' => 'h1',
		'atts'    => array( 'class' => 'page-title' ),
		'title'   => primer_get_the_page_title(),
	) );

	if ( empty( $args['title'] ) ) {

		return;

	}

	$args['atts'] = empty( $args['atts'] ) ? array() : (array) $args['atts'];

	foreach ( $args['atts'] as $key => &$value ) {

		$value = sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $value ) );

	}

	$html = esc_html( $args['title'] );

	if ( ! empty( $args['wrapper'] ) ) {

		$html = sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			sanitize_key( $args['wrapper'] ),
			implode( ' ', $args['atts'] ),
			$html
		);

	}

	echo $html; // xss ok.

}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @global WP_Query $wp_query
 * @since  1.6.0
 * @uses  [the_posts_pagination](https://developer.wordpress.org/reference/functions/the_posts_pagination/)
 *
 * @param array $args (optional) Post pagination arguments.
 */
function primer_pagination( $args = array() ) {

	global $wp_query;

	if ( empty( $wp_query->max_num_pages ) || (int) $wp_query->max_num_pages < 2 ) {

		return;

	}

	global $post;

	$post_type_labels = get_post_type_labels( get_post_type_object( $post->post_type ) );
	$post_type_label  = isset( $post_type_labels->singular_name ) ? $post_type_labels->singular_name : $post->post_type;

	/**
	 * Filter the default post pagination args.
	 *
	 * @since 1.6.0
	 *
	 * @param int $current The current page number.
	 * @param int $total   The total number of pages.
	 *
	 * @var array
	 */
	$defaults = (array) apply_filters( 'primer_pagination_default_args', array(
		'prev_text'          => __( '&larr; Previous', 'primer' ),
		'next_text'          => __( 'Next &rarr;', 'primer' ),
		'screen_reader_text' => sprintf( /* translators: post type singular label */ esc_html__( '%1$s navigation', 'primer' ), esc_html( $post_type_label ) ),
	), max( 1, get_query_var( 'paged' ) ), absint( $wp_query->max_num_pages ) );

	$args = wp_parse_args( $args, $defaults );

	the_posts_pagination( $args );

}

/**
 * Display navigation to next/previous post, when applicable.
 *
 * @since 1.0.0
 * @uses  [the_post_navigation](https://developer.wordpress.org/reference/functions/the_post_navigation/)
 *
 * @param array $args (optional) Post navigation arguments.
 */
function primer_post_nav( $args = array() ) {

	/**
	 * Filter the default post navigation args.
	 *
	 * @since 1.5.0
	 *
	 * @var array
	 */
	$defaults = (array) apply_filters( 'primer_post_nav_default_args', array(
		'prev_text' => '&larr; %title',
		'next_text' => '%title &rarr;',
	) );

	$args = wp_parse_args( $args, $defaults );

	the_post_navigation( $args );

}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.0
 */
function primer_posted_on() {

	$time = sprintf(
		'<time class="entry-date published" datetime="%s">%s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {

		$time = sprintf(
			'<time class="updated" datetime="%s">%s</time>',
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

	}

	printf( // xss ok.
		'<span class="posted-on"><a href="%s" rel="bookmark">%s</a><span>',
		get_permalink(),
		$time
	);

}

/**
 * Prints the post format for the current post.
 *
 * @since 1.0.0
 */
function primer_post_format() {

	$format = get_post_format();
	$format = empty( $format ) ? 'standard' : $format;

	printf( '<span class="post-format">%s</span>', esc_html( $format ) );

}

/**
 * Display very simple breadcrumbs.
 *
 * Adapted from Christoph Weil's Really Simple Breadcrumb plugin.
 *
 * @global WP_Post $post
 * @link   https://wordpress.org/plugins/really-simple-breadcrumb/
 * @since  1.0.0
 */
function primer_breadcrumbs() {

	global $post;

	$separator = ' <span class="sep"></span> ';

	echo '<div class="breadcrumbs">';

	if ( ! is_front_page() ) {

		printf( // xss ok.
			'<a href="%s">%s</a>%s',
			esc_url( home_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) ),
			$separator
		);

		if ( 'page' === get_option( 'show_on_front' ) ) {

			printf( // xss ok.
				'<a href="%s">%s</a>%s',
				esc_url( primer_get_posts_url() ),
				esc_html__( 'Blog', 'primer' ),
				$separator
			);

		}

		if ( is_category() || is_single() ) {

			the_category( ', ' );

			if ( is_single() ) {

				echo $separator; // xss ok.

				the_title();

			}

		} elseif ( is_page() && $post->post_parent ) {

			$home = get_post( get_option( 'page_on_front' ) );

			for ( $i = count( $post->ancestors ) - 1; $i >= 0; $i-- ) {

				if ( $home->ID !== $post->ancestors[ $i ] ) {

					printf( // xss ok.
						'<a href="%s">%s</a>%s',
						esc_url( get_permalink( $post->ancestors[ $i ] ) ),
						esc_html( get_the_title( $post->ancestors[ $i ] ) ),
						$separator
					);

				}

			}

			the_title();

		} elseif ( is_page() ) {

			the_title();

		} elseif ( is_404() ) {

			echo '404';

		} // End if().

	} else {

		bloginfo( 'name' );

	} // End if().

	echo '</div>';

}
