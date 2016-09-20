<?php
/**
 * Jetpack compatibility.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Enable support for certain Jetpack modules.
 *
 * @action after_setup_theme
 * @link   https://jetpack.com/support/featured-content/
 * @link   https://jetpack.com/support/infinite-scroll/
 * @since  1.0.0
 */
function primer_jetpack_setup() {

	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'main',
			'footer'    => 'page',
		)
	);

}
add_action( 'after_setup_theme', 'primer_jetpack_setup' );
