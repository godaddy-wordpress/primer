<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Primer
 */

/**
 * Enable support for certain Jetpack modules.
 *
 * @link https://jetpack.com/support/featured-content/
 * @link https://jetpack.com/support/infinite-scroll/
 */
function primer_jetpack_setup() {

	add_theme_support(
		'featured-content',
		array(
			'filter'     => 'primer_get_featured_posts',
			'max_posts'  => 1,
			'post_types' => array( 'post', 'page' ),
		)
	);

	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'main',
			'footer'    => 'page',
		)
	);

}
add_action( 'after_setup_theme', 'primer_jetpack_setup' );

/**
 * Display Featured Posts from Jetpack in the theme.
 *
 * @action primer_header_after
 */
function primer_jetpack_init(){

	if ( is_home() || is_front_page() ) {

		primer_display_featured_posts();

	}

}
add_action( 'primer_header_after', 'primer_jetpack_init' );

/**
 * Return an array of Featured Posts from Jetpack.
 *
 * @link http://jetpack.me/support/featured-content/
 *
 * @return array
 */
function primer_get_featured_posts() {

	return (array) apply_filters( 'primer_get_featured_posts', array() );

}

/**
 * Check for Featured Posts in Jetpack.
 *
 * @param  int $minimum (optional)
 *
 * @return bool
 */
function primer_has_featured_posts( $minimum = 1 ) {

	if ( is_paged() ) {

		return false;

	}

	$featured_posts = (array) apply_filters( 'primer_get_featured_posts', array() );

	return ( $featured_posts && count( $featured_posts ) > absint( $minimum ) );

}

/**
 * Display the featured content post loop.
 */
function primer_display_featured_posts() {

	get_template_part( 'content', 'featured' );

}

/**
 * Add featured post image background to header.
 *
 * @action wp_print_styles
 */
function primer_get_featured_content_post_bg(){

	$featured_content = primer_get_featured_posts();

	if ( ! $featured_content || ! is_array( $featured_content ) ) {

		return;

	}

	$post_ID = $featured_content[0]->ID;

	if ( has_post_thumbnail( $post_ID ) ) :

		$image_id  = get_post_thumbnail_id( $post_ID );
		$image_src = wp_get_attachment_image_src( $image_id, 'original', true );

		?>
		<style id="primer-featured-content">
		.featured-content{
			background-image: url(<?php echo $image_src[0] ?>);
		}
		</style>
		<?php

	endif;

}
add_action( 'wp_print_styles', 'primer_get_featured_content_post_bg' );
