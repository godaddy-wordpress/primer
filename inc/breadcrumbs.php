<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Primer
 */

if ( ! function_exists( 'primer_breadcrumbs' ) ) :

/**
 * Simple breadcrumbs
 *
 * Outputs a simple breadcrumb trail..
 *
 * @link https://wordpress.org/plugins/really-simple-breadcrumb/ 	Adapted from Christoph Weil's Really Simple Breadcrumb plugin.
 */
function primer_breadcrumbs() {

    global $post;

	$separator = ' <span class="sep"></span> ';

    echo '<div class="breadcrumbs">';

	if ( ! is_front_page() ) {

		echo '<a href="' . esc_url( get_home_url() ) . '">' . get_bloginfo( 'name' ) . '</a> ' . $separator;

		if( get_option( 'show_on_front') == 'page' ){

			echo '<a href="' . esc_url( primer_get_posts_url() ) . '">' . __( 'Blog' ) . '</a> ' . $separator;

		}

		if ( is_category() || is_single() ) {

			the_category( ', ' );

			if ( is_single() ) {

				echo $separator;

				the_title();

			}

		} elseif ( is_page() && $post->post_parent ) {

			$home = get_page( get_option('page_on_front') );

			for ( $i = count( $post->ancestors )-1; $i >= 0; $i-- ) {

				if ( ( $home->ID ) != ( $post->ancestors[$i] ) ) {

					echo '<a href="' . get_permalink( $post->ancestors[$i] ) . '">' . get_the_title( $post->ancestors[$i] ) . '</a>' . $separator;

				}
			}

			echo the_title();

		} elseif ( is_page() ) {

			echo the_title();

		} elseif ( is_404() ) {

			echo '404';

		}

	} else {

		bloginfo( 'name' );

	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'primer_get_posts_url' ) ) :

/**
 * Retrieve the posts page URI.
 *
 * In the event a custom homepage exists, we need to find the posts page and return its URI.
 *
 * @return 	string 	$posts_page_uri 	URL for the posts page if a custom homepage exists.
 */
function primer_get_posts_url() {

	if( get_option( 'show_on_front' ) == 'page') {

		$posts_page_id 	= get_option( 'page_for_posts' );
		$posts_page_url = get_page_uri( $posts_page_id );

	}

	if ( isset( $posts_page_url ) ) {

		return $posts_page_url;

	} else {

		return false;

	}
}
endif;
