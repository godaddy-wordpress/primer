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

	$args = array(
		'class'    => 'custom-logo',
		'itemprop' => 'logo',
	);

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

	$html = sprintf(
		'<h1 class="site-title"><a href="%s" rel="home">%s</a></h1>',
		esc_url( home_url( '/' ) ),
		get_bloginfo( 'name' )
	);

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

	$html = sprintf(
		'<div class="site-description">%s</div>',
		get_bloginfo( 'description' )
	);

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
 * Display a page title.
 *
 * @since 1.0.0
 */
function primer_the_page_title() {

	if ( $title = primer_get_the_page_title() ) {

		echo $title; // xss ok.

	}

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

		}

	} else {

		bloginfo( 'name' );

	}

	echo '</div>';

}
