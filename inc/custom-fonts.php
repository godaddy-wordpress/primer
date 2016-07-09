<?php
/**
 * Customizer support for custom fonts
 *
 * @package Primer
 * @subpackage primer
 * @since primer 1.0
 */

/**
 * If you want to disable the secondary font please add this to your child theme.
 *
 * add_filter( 'show_secondary_font', false, 5, 1 );
 */

/**
 * Font customization controls.
 *
 * Adds control for font pair selection.
 *
 * @action  customize_register
 *
 * @param $wp_customize
 */
function primer_font_switcher( $wp_customize ) {
	$wp_customize->add_section( 'typography' , array(
		'title'      => __( 'Typography', 'primer' ),
		'priority'   => 40,
	) );

	$wp_customize->add_setting( 'primary_font', array(
		'default'			=> primer_get_default_font( 'primary_font' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'primary_font', array(
		'label'    => __( 'Primary Font', 'ascension' ),
		'section'  => 'typography',
		'type'     => 'select',
		'choices'  => primer_get_font_choices(),
	) );

	if ( apply_filters( 'show_secondary_font', true ) ) {

		$wp_customize->add_setting( 'secondary_font', array(
			'default'           => primer_get_default_font( 'secondary_font' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'secondary_font', array(
			'label'   => __( 'Secondary Font', 'ascension' ),
			'section' => 'typography',
			'type'    => 'select',
			'choices' => primer_get_font_choices(),
		) );

	}
}
add_action( 'customize_register', 'primer_font_switcher' );

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
		'PT Serif',
	));
}

/**
 * Return the default font
 *
 * @param $font
 *
 * @return mixed
 */
function primer_get_default_font( $font ) {
	$fonts = primer_get_fonts();

	if ( 'primary_font' === $font ) {
		return $fonts[0];
	} elseif ( 'secondary_font' === $font ) {
		return $fonts[1];
	}
	return $fonts[0];
}

/**
 * Return primary or default font
 *
 * @param $font
 *
 * @return string
 */
function primer_get_font( $font ) {
	$font_option    = get_theme_mod( $font, primer_get_default_font( $font ) );
	$fonts          = primer_get_fonts();

	if ( in_array( $font_option, $fonts ) ) {
		return $font_option;
	}

	return $fonts[0];
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
 * Enqueue Google fonts
 */
function enqueue_google_fonts() {
	$primary_font = primer_get_font( 'primary_font' );

	if ( apply_filters( 'show_secondary_font', true ) ) {
		$secondary_font = primer_get_font( 'secondary_font' );

		$font_families = array(
			$primary_font . ':600,600italic,800,300,300italic,400,400italic,700,700italic,800italic',
			$secondary_font . ':600,600italic,800,300,300italic,400,400italic,700,700italic,800italic',
		);
		$font_families = implode( '|', $font_families );

	} else {
		$font_families = $primary_font . ':600,600italic,800,300,300italic,400,400italic,700,700italic,800italic';
	}

	$query_args = apply_filters( 'google_font_query_args', array(
		'family' => $font_families,
		'subset' => 'latin',
	) );
	wp_enqueue_style( 'ascension-google-fonts', add_query_arg( $query_args, '//fonts.googleapis.com/css' ), false );

}
add_action( 'wp_enqueue_scripts', 'enqueue_google_fonts', 11 );

/**
 * Return font options
 *
 * Return the full set of font family options.
 */
function primer_primary_font_css() {
	$default_primary_font      = primer_get_default_font( 'primary_font' );
	$primary_font              = get_theme_mod( 'primary_font', $default_primary_font );

	if ( $primary_font === $default_primary_font ) {
		return;
	}

	$css = apply_filters(
		'primary_font_css',
		'/* Primary Font */
		body {
			font-family: "%1$s", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
		}
	');

	wp_add_inline_style( 'primer', sprintf( $css, $primary_font ) );
}
add_action( 'wp_enqueue_scripts', 'primer_primary_font_css', 11 );

/**
 * Return font options
 *
 * Return the full set of font family options.
 */
function primer_secondary_font_css() {

	if ( apply_filters( 'show_secondary_font', true ) ) {

		$default_secondary_font = primer_get_default_font( 'secondary_font' );
		$secondary_font         = get_theme_mod( 'secondary_font', $default_secondary_font );

		if ( $secondary_font === $default_secondary_font ) {
			return;
		}

		$css = apply_filters(
			'secondary_font_css',
			'/* Secondary Font */
			body {
				font-family: "%1$s", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}
		' );

		wp_add_inline_style( 'primer', sprintf( $css, $secondary_font ) );

	}

}
add_action( 'wp_enqueue_scripts', 'primer_secondary_font_css', 11 );

?>
