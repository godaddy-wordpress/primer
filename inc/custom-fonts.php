<?php
/**
 * Customizer support for custom fonts
 *
 * @package Primer
 * @subpackage primer
 * @since primer 1.0
 */

/**
 * Font customization controls.
 *
 * Adds control for font pair selection.
 *
 * @action  customize_register
 */
function primer_font_switcher($wp_customize) {
	$fonts = primer_get_fonts();
	$default_font = $fonts[0];

	$wp_customize->add_setting( 'main_font', array(
		'default'			=> 'Open Sans',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'main_font', array(
		'label'    => __( 'Font', 'ascension' ),
		'section'  => 'title_tagline',
		'type'     => 'select',
		'choices'  => primer_get_font_choices()
	) );
}
add_action('customize_register', 'primer_font_switcher');

/**
 * Lists acceptable font pairings
 *
 * Returns a filterable list of font families for site
 * customization.
 *
 * @filter  primer_fonts
 */
function primer_get_fonts() {
	return apply_filters( 'primer_fonts', array(
		'Open Sans',
		'Source Sans Pro',
		'Roboto',
		'Lato',
		'Montserrat',
		'Raleway',
		'PT Sans',
		'Noto Sans',
		'Muli',
		'Oxygen',
		'Source Serif Pro',
		'PT Serif'
	));
}

/**
 * Return primary or default font
 *
 */
function primer_get_font() {
	$font_option    = get_theme_mod( 'main_font', 'default' );
	$fonts          = primer_get_fonts();

	if ( in_array( $font_option, $fonts ) ) {
		return $font_option;
	}

	return $fonts[ 0 ];
}

/**
 * Return font options
 *
 * Return the full set of font family options.
 */
function primer_get_font_choices() {
	$fonts                  = primer_get_fonts();
	$font_control_options   = array();

	foreach ( $fonts as $font ) {
		$font_control_options[ $font ] = $font;
	}

	return $font_control_options;
}

/**
 * Return font options
 *
 * Return the full set of font family options.
 */

function primer_fonts_css() {

	$fonts                  = primer_get_fonts();
	$default_font           = $fonts[0];
	$main_font              = get_theme_mod( 'main_font', $default_font );

	$font = primer_get_font();

	$query_args = apply_filters( 'google_font_query_args', array(
		'family' => $font . ':600,600italic,800,300,300italic,400,400italic,700,700italic,800italic',
		'subset' => 'latin',
	) );
	wp_enqueue_style( 'ascension-google-fonts', add_query_arg( $query_args, '//fonts.googleapis.com/css' ), false );

	if ( $main_font === $default_font ) {
		return;
	}

	$css = apply_filters(
		'custom_fonts_css',
		'/* Custom Fonts */
		body {
			font-family: "%1$s", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
		}
	');

	wp_add_inline_style( 'primer', sprintf( $css, $main_font ) );
}
add_action( 'wp_enqueue_scripts', 'primer_fonts_css', 11 );

?>
