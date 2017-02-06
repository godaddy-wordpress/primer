<?php
/**
 * Jetpack compatibility.
 *
 * @package    Compatibility
 * @subpackage Jetpack
 * @category   Core
 * @author     GoDaddy
 * @since      1.0.0
 */

/**
 * Enable support for certain Jetpack modules.
 *
 * @action after_setup_theme
 * @uses   [add_theme_support](https://developer.wordpress.org/reference/functions/add_theme_support/) To enable infinite-scroll.
 *
 * @link   https://jetpack.com/support/featured-content/
 * @link   https://jetpack.com/support/infinite-scroll/
 *
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
