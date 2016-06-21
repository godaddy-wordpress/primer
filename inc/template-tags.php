<?php
/**
 * Custom template tags for this theme.
 *
 * @package Primer
 */

if ( ! function_exists( 'primer_active_footer_areas_count' ) ) {

	/**
	 * Return the number of active footer widget areas.
	 *
	 * @return int
	 */
	function primer_active_footer_areas_count() {

		global $wp_registered_sidebars;

		$count    = 0;
		$sidebars = preg_grep( '/^footer-(.*)/', array_keys( $wp_registered_sidebars ) );

		foreach ( $sidebars as $sidebar ) {

			if ( is_active_sidebar( $sidebar ) ) {

				$count++;

			}

		}

		return $count;

	}

}

if ( ! function_exists( 'primer_paging_nav' ) ) {

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function primer_paging_nav() {

		global $wp_query;

		if ( ! isset( $wp_query->max_num_pages ) || $wp_query->max_num_pages < 2 ) {

			return;

		}

		?>
		<nav class="navigation paging-navigation" role="navigation">

			<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'primer' ) ?></h1>

			<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>

				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'primer' ) ) ?></div>

			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>

				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'primer' ) ) ?></div>

			<?php endif; ?>

			</div><!-- .nav-links -->

		</nav><!-- .navigation -->
		<?php

	}

}

if ( ! function_exists( 'primer_post_nav' ) ) {

	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function primer_post_nav() {

		global $post;

		$previous = is_attachment() ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {

			return;

		}

		?>
		<nav class="navigation post-navigation" role="navigation">

			<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'primer' ) ?></h1>

			<div class="nav-links">

			<?php if ( is_rtl() ) : ?>

				<div class="nav-next"><?php next_post_link( '%link &larr;' ) ?></div>

				<div class="nav-previous"><?php previous_post_link( '&rarr; %link' ) ?></div>

			<?php else : ?>

				<div class="nav-previous"><?php previous_post_link( '&larr; %link' ) ?></div>

				<div class="nav-next"><?php next_post_link( '%link &rarr;' ) ?></div>

			<?php endif; ?>

			</div><!-- .nav-links -->

		</nav><!-- .navigation -->
		<?php

	}

}

if ( ! function_exists( 'primer_posted_on' ) ) {

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function primer_posted_on() {

		$time = sprintf(
			'<time class="entry-date published" datetime="%s">%s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {

			$time .= sprintf(
				'<time class="updated" datetime="%s">%s</time>',
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

		}

		printf(
			'<span class="posted-on"><a href="%s" rel="bookmark">%s</a><span>',
			get_permalink(),
			$time // xss ok
		);

	}

}

if ( ! function_exists( 'primer_post_format' ) ) {

	/**
	 * Prints the post format for the current post.
	 */
	function primer_post_format() {

		$format = get_post_format();
		$format = empty( $format ) ? 'standard' : $format;

		printf( '<span class="post-format">%s</span>', esc_html( $format ) );

	}

}

if ( ! function_exists( 'primer_get_featured_image_url' ) ) {

	/**
	 * Return the featured image URL.
	 *
	 * @return string|false
	 */
	function primer_get_featured_image_url() {

		$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'featured' );

		return empty( $featured_image_url[0] ) ? false : $featured_image_url;

	}

}

if ( ! function_exists( 'primer_has_active_categories' ) ) {

	/**
	 * Check if the site has active categories.
	 *
	 * We will store the result in a transient so this function
	 * can be called frequently without any performance concern.
	 *
	 * @see primer_has_active_categories_reset()
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

		return ! empty( $has_active_categories );

	}

}
