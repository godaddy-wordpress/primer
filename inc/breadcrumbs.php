<?php
/**
 * Custom breadcrumbs for this theme.
 *
 * @package Primer
 */

if ( ! function_exists( 'primer_breadcrumbs' ) ) {

	/**
	 * Display very simple breadcrumbs.
	 *
	 * Adapted from Christoph Weil's Really Simple Breadcrumb plugin.
	 *
	 * @link https://wordpress.org/plugins/really-simple-breadcrumb/
	 */
	function primer_breadcrumbs() {

		global $post;

		$separator = ' <span class="sep"></span> ';

		echo '<div class="breadcrumbs">';

		if ( ! is_front_page() ) {

			printf(
				'<a href="%s">%s</a>%s',
				esc_url( home_url() ),
				esc_html( get_bloginfo( 'name' ) ),
				$separator // xss ok
			);

			if ( 'page' === get_option( 'show_on_front' ) ) {

				printf(
					'<a href="%s">%s</a>%s',
					esc_url( primer_get_posts_url() ),
					esc_html__( 'Blog', 'primer' ),
					$separator // xss ok
				);

			}

			if ( is_category() || is_single() ) {

				the_category( ', ' );

				if ( is_single() ) {

					echo $separator; // xss ok

					the_title();

				}

			} elseif ( is_page() && $post->post_parent ) {

				$home = get_page( get_option( 'page_on_front' ) );

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

}

if ( ! function_exists( 'primer_get_posts_url' ) ) {

	/**
	 * Return the posts page URL.
	 *
	 * In the event a custom homepage exists, we need
	 * to find the posts page and return its URL.
	 *
	 * @return string|false
	 */
	function primer_get_posts_url() {

		if ( 'page' === get_option( 'show_on_front' ) ) {

			$posts_page_id 	= get_option( 'page_for_posts' );
			$posts_page_url = get_page_uri( $posts_page_id );

		}

		return isset( $posts_page_url ) ? $posts_page_url : false;

	}

}
