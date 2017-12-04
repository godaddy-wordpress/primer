<?php
/**
 * Gutenberg compatibility.
 *
 * @package    Compatibility
 * @subpackage Gutenberg
 * @category   Core
 * @author     GoDaddy
 * @since      NEXT
 */

/**
 * Enable Gutenberg features.
 *
 * @since NEXT
 */
function primer_gutenberg_theme_support() {

	add_theme_support( 'gutenberg', array(
		'wide-images' => true,
	) );

}
add_action( 'after_setup_theme', 'primer_gutenberg_theme_support' );
