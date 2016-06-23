<?php
/**
 * Customizer support.
 *
 * @package Primer
 * @subpackage primer
 * @since primer 1.0
 */

/**
 * Sets up the WordPress core custom logo
 *
 * @since primer 1.0
 *
 */
function primer_custom_logo() {
	add_theme_support( 'custom-logo', apply_filters( 'primer_custom_logo_args', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	)));
}
add_action( 'after_setup_theme', 'primer_custom_logo' );

/**
 * Sets up the WordPress core custom background features.
 *
 * @since primer 1.0
 *
 * @see primer_header_style()
 */
function primer_background() {
	$color_scheme             	= primer_get_color_scheme();
	$default_background_color 	= trim( $color_scheme[1], '#' );

	/**
	 * Filter the arguments used when adding 'custom-background' support in primer.
	 *
	 * @since primer 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'primer_custom_background_args', array(
		'default-color' => $default_background_color,
	) ) );
}
add_action( 'after_setup_theme', 'primer_background' );

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @since primer 1.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function primer_customize_register( $wp_customize ) {
	$color_scheme = primer_get_color_scheme();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'primer_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'primer_customize_partial_blogdescription',
		) );
	}

	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'primer_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'primer' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => primer_get_color_scheme_choices(),
		'priority' => 1,
	) );

	// Add page background color setting and control.
	$wp_customize->add_setting( 'tagline_text_color', array(
		'default'           => $color_scheme[2],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_text_color', array(
		'label'       => __( 'Tagline Text Color', 'primer' ),
		'section'     => 'colors',
	) ) );

	// Add link color setting and control.
	$wp_customize->add_setting( 'link_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'       => __( 'Link Color', 'primer' ),
		'section'     => 'colors',
	) ) );

	// Add main text color setting and control.
	$wp_customize->add_setting( 'main_text_color', array(
		'default'           => $color_scheme[4],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_text_color', array(
		'label'       => __( 'Main Text Color', 'primer' ),
		'section'     => 'colors',
	) ) );

	// Add secondary text color setting and control.
	$wp_customize->add_setting( 'secondary_text_color', array(
		'default'           => $color_scheme[5],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_text_color', array(
		'label'       => __( 'Secondary Text Color', 'primer' ),
		'section'     => 'colors',
	) ) );
}
add_action( 'customize_register', 'primer_customize_register', 11 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since primer 1.2
 * @see primer_customize_register()
 *
 * @return void
 */
function primer_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since primer 1.2
 * @see primer_customize_register()
 *
 * @return void
 */
function primer_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Registers color schemes for primer.
 *
 * Can be filtered with {@see 'primer_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Link Color.
 * 4. Main Text Color.
 * 5. Secondary Text Color.
 *
 * @since primer 1.0
 *
 * @return array An associative array of color scheme options.
 */
function primer_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with primer.
	 *
	 * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
	 *
	 * @since primer 1.0
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 */
	return apply_filters( 'primer_color_schemes', array(
		'default' => array(
			'label'  => __( 'Default', 'primer' ),
			'colors' => array(
				'#ffffff',
				'#1a1a1a',
				'#ffffff',
				'#007acc',
				'#1a1a1a',
				'#686868',
			),
		),
		'dark' => array(
			'label'  => __( 'Dark', 'primer' ),
			'colors' => array(
				'#ffffff',
				'#262626',
				'#1a1a1a',
				'#9adffd',
				'#e5e5e5',
				'#c1c1c1',
			),
		),
		'gray' => array(
			'label'  => __( 'Gray', 'primer' ),
			'colors' => array(
				'#ffffff',
				'#616a73',
				'#4d545c',
				'#c7c7c7',
				'#f2f2f2',
				'#f2f2f2',
			),
		),
		'red' => array(
			'label'  => __( 'Red', 'primer' ),
			'colors' => array(
				'#ffffff',
				'#ffffff',
				'#ff675f',
				'#640c1f',
				'#402b30',
				'#402b30',
			),
		),
		'yellow' => array(
			'label'  => __( 'Yellow', 'primer' ),
			'colors' => array(
				'#ffffff',
				'#3b3721',
				'#ffef8e',
				'#774e24',
				'#3b3721',
				'#5b4d3e',
			),
		),
	) );
}

if ( ! function_exists( 'primer_get_color_scheme' ) ) :
/**
 * Retrieves the current primer color scheme.
 *
 * Create your own primer_get_color_scheme() function to override in a child theme.
 *
 * @since primer 1.0
 *
 * @return array An associative array of either the current or default color scheme HEX values.
 */
function primer_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = primer_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif; // primer_get_color_scheme

if ( ! function_exists( 'primer_get_color_scheme_choices' ) ) :
/**
 * Retrieves an array of color scheme choices registered for primer.
 *
 * Create your own primer_get_color_scheme_choices() function to override
 * in a child theme.
 *
 * @since primer 1.0
 *
 * @return array Array of color schemes.
 */
function primer_get_color_scheme_choices() {
	$color_schemes                = primer_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif; // primer_get_color_scheme_choices


if ( ! function_exists( 'primer_sanitize_color_scheme' ) ) :
/**
 * Handles sanitization for primer color schemes.
 *
 * Create your own primer_sanitize_color_scheme() function to override
 * in a child theme.
 *
 * @since primer 1.0
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function primer_sanitize_color_scheme( $value ) {
	$color_schemes = primer_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		return 'default';
	}

	return $value;
}
endif; // primer_sanitize_color_scheme

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since primer 1.0
 *
 * @see wp_add_inline_style()
 */
function primer_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = primer_get_color_scheme();

	// Convert main text hex color to rgba.
	$hover_color_rgb = primer_hex2rgb( $color_scheme[3] );

	// If the rgba values are empty return early.
	if ( empty( $hover_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		'header_textcolor'			=> $color_scheme[0],
		'background_color'      => $color_scheme[1],
		'tagline_text_color' 		=> $color_scheme[2],
		'link_color'            => $color_scheme[3],
		'main_text_color'       => $color_scheme[4],
		'secondary_text_color'  => $color_scheme[5],
		'hover_color'          => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.8)', $hover_color_rgb ),
	);

	$color_scheme_css = primer_get_color_scheme_css( $colors );

	wp_add_inline_style( 'primer', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'primer_color_scheme_css', 11 );

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since primer 1.0
 */
function primer_customize_control_js() {
	$suffix = SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . "/assets/js/color-scheme-control{$suffix}	.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );
	wp_localize_script( 'color-scheme-control', 'colorScheme', primer_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'primer_customize_control_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since primer 1.0
 */
function primer_customize_preview_js() {
	$suffix = SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'primer-customize-preview', get_template_directory_uri() . "/assets/js/customizer{$suffix}.js", array( 'customize-preview' ), PRIMER_VERSION, true);
}
add_action( 'customize_preview_init', 'primer_customize_preview_js' );

/**
 * Returns CSS for the color schemes.
 *
 * @since primer 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function primer_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'header_textcolor'			=> '',
		'background_color'      => '',
		'tagline_text_color' 		=> '',
		'link_color'            => '',
		'main_text_color'       => '',
		'secondary_text_color'  => '',
		'hover_color'          	=> '',
	) );

	$css = <<<CSS
	/* Color Scheme */

	/* Header Text Color */
	.header_textcolor {
		color: {$colors['header_textcolor']};
	}

	/* Background Color */
	.background_color {
		background-color: {$colors['background_color']};
	}

	/* Page Background Color */
	.tagline_text_color {
		color: {$colors['tagline_text_color']};
	}

	/* Link Color */
	a {
		color: {$colors['link_color']};
	}
	a:hover {
		color: {$colors['hover_color']};
	}

	/* Main Text Color */
	.main_text_color {
		color: {$colors['main_text_color']};
	}

	/* Secondary Text Color */
	.secondary_text_color {
		color: {$colors['secondary_text_color']};
	}

CSS;

	return apply_filters( 'color_scheme_css', $css );
}


/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since primer 1.0
 */
function primer_color_scheme_css_template() {
	$colors = array(
		'header_textcolor'			=> '{{ data.header_textcolor }}',
		'background_color'      => '{{ data.background_color }}',
		'tagline_text_color' 		=> '{{ data.tagline_text_color }}',
		'link_color'            => '{{ data.link_color }}',
		'main_text_color'       => '{{ data.main_text_color }}',
		'secondary_text_color'  => '{{ data.secondary_text_color }}',
		'hover_color'          	=> '{{ data.hover_color }}',
	);
	?>
	<script type="text/html" id="tmpl-primer-color-scheme">
		<?php echo primer_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'primer_color_scheme_css_template' );

//

/**
 * Enqueues front-end CSS for the page background color.
 *
 * @since primer 1.0
 *
 * @see wp_add_inline_style()
 */
function primer_header_textcolor_css() {
	$color_scheme          = primer_get_color_scheme();
	$default_color         = $color_scheme[0];
	$header_textcolor			 = '#' . get_theme_mod( 'header_textcolor', $default_color );  // No hash before

	// Don't do anything if the current color is the default.
	if ( $header_textcolor === $default_color ) {
		return;
	}

	$css = apply_filters(
		'custom_header_textcolor_css',
		'/* Custom Header Text Color */
		.header_textcolor {
			color: %1$s;
		}'
	);

	wp_add_inline_style( 'primer', sprintf( $css, $header_textcolor ) );
}
add_action( 'wp_enqueue_scripts', 'primer_header_textcolor_css', 11 );

/**
 * Enqueues front-end CSS for the page background color.
 *
 * @since primer 1.0
 *
 * @see wp_add_inline_style()
 */
function primer_tagline_text_color_css() {
	$color_scheme          = primer_get_color_scheme();
	$default_color         = $color_scheme[2];
	$tagline_text_color = get_theme_mod( 'tagline_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $tagline_text_color === $default_color ) {
		return;
	}

	$css = apply_filters(
		'custom_tagline_text_color_css',
		'/* Custom Tagline Text Color */
		.tagline_text_color {
			color: %1$s;
		}'
	);

	wp_add_inline_style( 'primer', sprintf( $css, $tagline_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'primer_tagline_text_color_css', 11 );

/**
 * Enqueues front-end CSS for the link color.
 *
 * @since primer 1.0
 *
 * @see wp_add_inline_style()
 */
function primer_link_color_css() {
	$color_scheme    = primer_get_color_scheme();
	$default_color   = $color_scheme[3];
	$link_color 		 = get_theme_mod( 'link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $link_color === $default_color ) {
		return;
	}

	// Convert main text hex color to rgba.
	$link_color_rgb = primer_hex2rgb( $link_color );

	// If the rgba values are empty return early.
	if ( empty( $link_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$hover_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.8)', $link_color_rgb );

	$css = apply_filters(
		'custom_link_color_css',
		'/* Custom Link Color */
		a {
			color: %1$s;
		}
		a:hover {
			color: %2$s;
		}'
	);

	wp_add_inline_style( 'primer', sprintf( $css, $link_color, $hover_color ) );
}
add_action( 'wp_enqueue_scripts', 'primer_link_color_css', 11 );

/**
 * Enqueues front-end CSS for the main text color.
 *
 * @since primer 1.0
 *
 * @see wp_add_inline_style()
 */
function primer_main_text_color_css() {
	$color_scheme    = primer_get_color_scheme();
	$default_color   = $color_scheme[4];
	$main_text_color = get_theme_mod( 'main_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $main_text_color === $default_color ) {
		return;
	}

	$css = apply_filters(
		'custom_main_text_color_css',
		'/* Custom Main Text Color */
		.main_text_color
			color: %1$s;
		}'
	);

	wp_add_inline_style( 'primer', sprintf( $css, $main_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'primer_main_text_color_css', 11 );

/**
 * Enqueues front-end CSS for the secondary text color.
 *
 * @since primer 1.0
 *
 * @see wp_add_inline_style()
 */
function primer_secondary_text_color_css() {
	$color_scheme    = primer_get_color_scheme();
	$default_color   = $color_scheme[5];
	$secondary_text_color = get_theme_mod( 'secondary_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $secondary_text_color === $default_color ) {
		return;
	}

	$css = apply_filters(
		'custom_secondary_text_color_css',
		'/* Custom Secondary Text Color */
		.secondary_text_color {
			color: %1$s;
		}'
	);

	wp_add_inline_style( 'primer', sprintf( $css, $secondary_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'primer_secondary_text_color_css', 11 );
