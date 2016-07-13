<?php
/**
 * Customizer support for custom fonts.
 *
 * @package Primer
 */

/**
 * Check if a secondary font is enabled.
 *
 * If you want to disable the secondary font please use
 * this filter to your child theme:
 *
 * add_filter( 'primer_has_secondary_font', false );
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_has_secondary_font() {

	/**
	 * Filter if the secondary font should be enabled.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	return (bool) apply_filters( 'primer_has_secondary_font', true );

}

/**
 * Font customization controls.
 *
 * Adds control for font pair selection.
 *
 * @action customize_register
 *
 * @since 1.0.0
 *
 * @param $wp_customize
 */
function primer_font_switcher( $wp_customize ) {

	$wp_customize->add_section(
		'typography',
		array(
			'title'    => __( 'Typography', 'primer' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'primary_font',
		array(
			'default'           => primer_get_default_font( 'primary_font' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'primary_font',
		array(
			'label'   => __( 'Primary Font', 'primer' ),
			'section' => 'typography',
			'type'    => 'select',
			'choices' => primer_get_font_choices(),
		)
	);

	if ( primer_has_secondary_font() ) {

		$wp_customize->add_setting(
			'secondary_font',
			array(
				'default'           => primer_get_default_font( 'secondary_font' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'secondary_font',
			array(
				'label'   => __( 'Secondary Font', 'primer' ),
				'section' => 'typography',
				'type'    => 'select',
				'choices' => primer_get_font_choices(),
			)
		);

	}

}
add_action( 'customize_register', 'primer_font_switcher' );

/**
 * Lists acceptable font pairings
 *
 * Returns a filterable list of font families for site
 * customization.
 *
 * @since 1.0.0
 */
function primer_get_fonts() {

	$fonts = array(
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
	);

	/**
	 * Filter the array of registered Primer fonts.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	return (array) apply_filters( 'primer_fonts', $fonts );

}

/**
 * Return the default font for a font type.
 *
 * @since 1.0.0
 *
 * @param  string $font_type (optional)
 *
 * @return string
 */
function primer_get_default_font( $font_type = 'primary_font' ) {

	$fonts = primer_get_fonts();

	return ( 'secondary_font' === $font_type && ! empty( $fonts[1] ) ) ? $fonts[1] : $fonts[0];

}

/**
 * Return primary or default font.
 *
 * @since 1.0.0
 *
 * @param  string $font
 *
 * @return string
 */
function primer_get_font( $font ) {

	$option = get_theme_mod( $font, primer_get_default_font( $font ) );
	$fonts  = primer_get_fonts();

	return in_array( $option, $fonts ) ? $option : $fonts[0];

}

/**
 * Return the full set of font family options.
 *
 * @since 1.0.0
 */
function primer_get_font_choices() {

	$fonts = primer_get_fonts();

	return array_combine( $fonts, $fonts );

}

/**
 * Enqueue Google fonts.
 *
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 */
function primer_enqueue_google_fonts() {

	$primary_font  = primer_get_font( 'primary_font' );
	$font_families = $primary_font . ':300,400,700';

	if ( primer_has_secondary_font() ) {

		$secondary_font = primer_get_font( 'secondary_font' );

		$font_families = array(
			$primary_font . ':300,400,700',
			$secondary_font . ':300,400,700',
		);

		$font_families = implode( '|', $font_families );

	}

	$query_args = array(
		'family' => $font_families,
		'subset' => 'latin',
	);

	/**
	 * Filter the Google font query args.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$query_args = (array) apply_filters( 'primer_google_font_query_args', $query_args );

	wp_enqueue_style( 'primer-google-fonts', add_query_arg( $query_args, '//fonts.googleapis.com/css' ), false );

}
add_action( 'wp_enqueue_scripts', 'primer_enqueue_google_fonts', 11 );

/**
 * Add inline CSS for the primary font.
 *
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 */
function primer_primary_font_css() {

	$default = primer_get_default_font();
	$font    = get_theme_mod( 'primary_font', $default );

	if ( $font === $default ) {

		return;

	}

	$css = <<<CSS
		/* Primary Font */
		body, h1, h2, h3, h4, h5, h6, label {
			font-family: "%s", sans-serif;
		}
CSS;

	/**
	 * Filter the primary font inline CSS.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'primer_primary_font_css', $css );

	wp_add_inline_style( 'primer', sprintf( $css, $font ) );

}
add_action( 'wp_enqueue_scripts', 'primer_primary_font_css', 11 );

/**
 * Add inline CSS for the secondary font.
 *
 * @action wp_enqueue_scripts
 *
 * @since 1.0.0
 */
function primer_secondary_font_css() {

	if ( ! primer_has_secondary_font() ) {

		return;

	}

	$default = primer_get_default_font( 'secondary_font' );
	$font    = get_theme_mod( 'secondary_font', $default );

	if ( $font === $default ) {

		return;

	}

	$css = <<<CSS
	/* Secondary Font */
	p, blockquote, .fl-callout-text {
		font-family: "%s", serif;
	}
CSS;

	/**
	 * Filter the secondary font inline CSS.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'primer_secondary_font_css', $css );

	wp_add_inline_style( 'primer', sprintf( $css, $font ) );

}
add_action( 'wp_enqueue_scripts', 'primer_secondary_font_css', 11 );
