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

	$theme_support = array(
		'wide-images' => true,
	);

	if ( class_exists( 'Primer_Customizer_Colors' ) ) {

		$primer_colors = new Primer_Customizer_Colors();
		$colors_array  = $primer_colors->get_current_color_scheme_array();

		$theme_support['colors'] = array_values( array_unique( $colors_array['colors'] ) );

	}

	add_theme_support( 'gutenberg', $theme_support );

}
add_action( 'after_setup_theme', 'primer_gutenberg_theme_support' );
