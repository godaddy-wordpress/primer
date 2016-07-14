<?php
/**
 * Customizer support.
 *
 * @package Primer
 */

/**
 * Add custom logo support.
 *
 * @action after_setup_theme
 * @since  1.0.0
 */
function primer_custom_logo_setup() {

	/**
	 * Filter the custom logo args.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_custom_logo_args',
		array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		)
	);

	add_theme_support( 'custom-logo', $args );

}
add_action( 'after_setup_theme', 'primer_custom_logo_setup' );

/**
 * Add custom background support.
 *
 * @action after_setup_theme
 * @since  1.0.0
 */
function primer_custom_background_setup() {

	$scheme = primer_get_color_scheme();

	/**
	 * Filter the custom background args.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_custom_background_args',
		array(
			'default-color' => trim( $scheme[1], '#' ),
		)
	);

	add_theme_support( 'custom-background', $args );

}
add_action( 'after_setup_theme', 'primer_custom_background_setup' );

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function primer_customize_register( WP_Customize_Manager $wp_customize ) {

	$scheme = primer_get_color_scheme();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title a',
				'container_inclusive' => false,
				'render_callback'     => 'primer_customize_partial_blogname',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'primer_customize_partial_blogdescription',
			)
		);

	}

	// Add color scheme setting and control.
	$wp_customize->add_setting(
		'color_scheme',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'primer_sanitize_color_scheme',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'color_scheme',
		array(
			'label'    => __( 'Base Color Scheme', 'primer' ),
			'section'  => 'colors',
			'type'     => 'select',
			'choices'  => primer_get_color_scheme_choices(),
			'priority' => 1,
		)
	);

	// Add menu background color setting and control.
	$wp_customize->add_setting(
		'menu_background_color',
		array(
			'default'           => $scheme[2],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_background_color',
			array(
				'label'   => __( 'Menu Background Color', 'primer' ),
				'section' => 'colors',
			)
		)
	);

	// Add tagline text color setting and control.
	$wp_customize->add_setting(
		'tagline_text_color',
		array(
			'default'           => $scheme[3],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'tagline_text_color',
			array(
				'label'   => __( 'Tagline Text Color', 'primer' ),
				'section' => 'colors',
			)
		)
	);

	// Add link color setting and control.
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'           => $scheme[4],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label'   => __( 'Link Color', 'primer' ),
				'section' => 'colors',
			)
		)
	);

	// Add main text color setting and control.
	$wp_customize->add_setting(
		'main_text_color',
		array(
			'default'           => $scheme[5],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'main_text_color',
			array(
				'label'   => __( 'Main Text Color', 'primer' ),
				'section' => 'colors',
			)
		)
	);

	// Add secondary text color setting and control.
	$wp_customize->add_setting(
		'secondary_text_color',
		array(
			'default'           => $scheme[6],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_text_color',
			array(
				'label'   => __( 'Secondary Text Color', 'primer' ),
				'section' => 'colors',
			)
		)
	);

	// Add typography secion.
	$wp_customize->add_section(
		'typography',
		array(
			'title'    => __( 'Typography', 'primer' ),
			'priority' => 40,
		)
	);

	// Add primary font setting and control.
	$wp_customize->add_setting(
		'primary_font',
		array(
			'default'           => primer_get_default_font(),
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

		// Add secondary font setting and control.
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
add_action( 'customize_register', 'primer_customize_register', 11 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @see primer_customize_register()
 */
function primer_customize_partial_blogname() {

	bloginfo( 'name' );

}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see primer_customize_register()
 */
function primer_customize_partial_blogdescription() {

	bloginfo( 'description' );

}

/**
 * Return an array of available color schemes.
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
 * @return array An associative array of color scheme options.
 */
function primer_get_color_schemes() {

	/**
	 * Filter the array of available color schemes.
	 *
	 * The default schemes include: 'default', 'dark', 'muted', and 'red'.
	 *
	 * @since 1.0.0
	 *
	 * @var array $schemes {
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
	return (array) apply_filters( 'primer_color_schemes',
		array(
			'default' => array(
				'label'  => __( 'Default', 'primer' ),
				'colors' => array(
					'#222222',
					'#f9f9f9',
					'#4db790',
					'#7c7c7c',
					'#4db790',
					'#1a1a1a',
					'#686868',
				),
			),
			'dark' => array(
				'label'  => __( 'Dark', 'primer' ),
				'colors' => array(
					'#1a1a1a',
					'#262626',
					'#589ef2',
					'#1a1a1a',
					'#589ef2',
					'#e5e5e5',
					'#c1c1c1',
				),
			),
			'muted' => array(
				'label'  => __( 'Muted', 'primer' ),
				'colors' => array(
					'#5a6175',
					'#d5d6e0',
					'#5a6175',
					'#888c99',
					'#3e4c75',
					'#4f5875',
					'#888c99',
				),
			),
			'red' => array(
				'label'  => __( 'Red', 'primer' ),
				'colors' => array(
					'#222222',
					'#ffffff',
					'#640c1f',
					'#999999',
					'#640c1f',
					'#402b30',
					'#222222',
				),
			),
		)
	);

}

/**
 * Return an array of the current or default color scheme HEX values.
 *
 * Create your own primer_get_color_scheme() function to override in a child theme.
 *
 * @since 1.0.0
 *
 * @return array
 */
function primer_get_color_scheme() {

	$option  = get_theme_mod( 'color_scheme', 'default' );
	$schemes = primer_get_color_schemes();

	return isset( $schemes[ $option ] ) ? $schemes[ $option ]['colors'] : $schemes['default']['colors'];

}

/**
 * Return an array of color scheme choices.
 *
 * @since 1.0.0
 *
 * @return array
 */
function primer_get_color_scheme_choices() {

	$schemes = primer_get_color_schemes();

	return array_combine( array_keys( $schemes ), wp_list_pluck( $schemes, 'label' ) );

}

/**
 * Check if a color scheme exists.
 *
 * @since 1.0.0
 *
 * @param  string $scheme
 *
 * @return bool
 */
function primer_color_scheme_exists( $scheme ) {

	return array_key_exists( $value, primer_get_color_schemes() );

}

/**
 * Sanitize a color scheme by ensuring it exists.
 *
 * @since 1.0.0
 *
 * @param  string $scheme
 *
 * @return string
 */
function primer_sanitize_color_scheme( $scheme ) {

	return primer_color_scheme_exists( $scheme ) ? $scheme : 'default';

}

/**
 * Enqueue inline CSS for the color scheme.
 *
 * @since 1.0.0
 */
function primer_color_scheme_css() {

	if ( 'default' === get_theme_mod( 'color_scheme', 'default' ) ) {

		return;

	}

	$scheme = primer_get_color_scheme();
	$rgb    = primer_hex2rgb( $scheme[4] ); // Link color

	if ( empty( $rgb ) ) {

		return;

	}

	$colors = array(
		'header_textcolor'      => $scheme[0],
		'background_color'      => $scheme[1],
		'menu_background_color' => $scheme[2],
		'tagline_text_color'    => $scheme[3],
		'link_color'            => $scheme[4],
		'main_text_color'       => $scheme[5],
		'secondary_text_color'  => $scheme[6],
		'hover_color'           => vsprintf( 'rgba( %s, %s, %s, 0.8)', $rgb ),
	);

	$css = primer_get_color_scheme_css( $colors );

	wp_add_inline_style( 'primer', $css );

}
add_action( 'wp_enqueue_scripts', 'primer_color_scheme_css', 11 );

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 */
function primer_customize_control_js() {

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'primer-color-scheme-control', get_template_directory_uri() . "/assets/js/color-scheme-control{$suffix}.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );

	wp_localize_script( 'primer-color-scheme-control', 'colorScheme', primer_get_color_schemes() );

}
add_action( 'customize_controls_enqueue_scripts', 'primer_customize_control_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function primer_customize_preview_js() {

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'primer-customize-preview', get_template_directory_uri() . "/assets/js/customizer{$suffix}.js", array( 'customize-preview' ), PRIMER_VERSION, true );

}
add_action( 'customize_preview_init', 'primer_customize_preview_js' );

/**
 * Return color scheme CSS.
 *
 * @since 1.0.0
 *
 * @param  array $colors
 *
 * @return string
 */
function primer_get_color_scheme_css( array $colors ) {

	$colors = wp_parse_args(
		$colors,
		array(
			'header_textcolor'      => '',
			'background_color'      => '',
			'menu_background_color' => '',
			'tagline_text_color'    => '',
			'link_color'            => '',
			'main_text_color'       => '',
			'secondary_text_color'  => '',
			'hover_color'          	=> '',
		)
	);

	$css = <<<CSS
	/* Color Scheme */

	/* Header Text Color */
	.site-title a {
		color: {$colors['header_textcolor']};
	}

	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}

	/* Menu Background Color */
	.main-navigation-container,
	.main-navigation li a,
	.main-navigation li.menu-item-has-children ul {
		background-color: {$colors['menu_background_color']};
	}
	.main-navigation li a:hover {
		color: {$colors['hover_color']};
	}

	/* Tagline Text Color */
	.site-description {
		color: {$colors['tagline_text_color']};
	}

	/* Link Color */
	a {
		color: {$colors['link_color']};
	}
	a:hover {
		color: {$colors['hover_color']};
	}

	button,
	a.button,
	a.button:visited,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.site-info-wrapper .site-info .social-menu a {
		background-color: {$colors['link_color']};
	}

	button:hover,
	a.button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	.site-info-wrapper .site-info .social-menu a:hover {
		background-color: {$colors['hover_color']};
	}

	/* Main Text Color */
	.site-content,
	.site-content h1,
	.site-content h2,
	.site-content h3,
	.site-content h4,
	.site-content h5,
	.site-content h6,
	.site-content p,
	.site-content blockquote {
		color: {$colors['main_text_color']};
	}

	/* Secondary Text Color */
	.secondary_text_color,
	.site-info-text {
		color: {$colors['secondary_text_color']};
	}
CSS;

	/**
	 * Filter color scheme CSS.
	 *
	 * @since 1.0.0
	 *
	 * @param array $colors
	 *
	 * @var string
	 */
	return (string) apply_filters( 'primer_color_scheme_css', $css, $colors );

}

/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since 1.0.0
 */
function primer_color_scheme_css_template() {

	$colors = array(
		'header_textcolor'      => '{{ data.header_textcolor }}',
		'background_color'      => '{{ data.background_color }}',
		'menu_background_color' => '{{ data.menu_background_color }}',
		'tagline_text_color'    => '{{ data.tagline_text_color }}',
		'link_color'            => '{{ data.link_color }}',
		'main_text_color'       => '{{ data.main_text_color }}',
		'secondary_text_color'  => '{{ data.secondary_text_color }}',
		'hover_color'           => '{{ data.hover_color }}',
	);

	?>
	<script type="text/html" id="tmpl-primer-color-scheme">
		<?php echo primer_get_color_scheme_css( $colors ) ?>
	</script>
	<?php

}
add_action( 'customize_controls_print_footer_scripts', 'primer_color_scheme_css_template' );

/**
 * Enqueue inline CSS for the header text color.
 *
 * @since 1.0.0
 */
function primer_header_textcolor_css() {

	$scheme  = primer_get_color_scheme();
	$default = $scheme[0];
	$color   = get_theme_mod( 'header_textcolor', $default );

	if ( $color === $default ) {

		return;

	}

	$color = '#' . $color; // Prepend hash for this color

	$css = <<<CSS
	/* Header Text Color */
	.header_textcolor {
		color: %s;
	}
CSS;

	/**
	 * Filter inline CSS for the header text color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'custom_header_textcolor_css', $css, $color );

	wp_add_inline_style( 'primer', sprintf( $css, $color ) );

}
add_action( 'wp_enqueue_scripts', 'primer_header_textcolor_css', 11 );

/**
 * Enqueue inline CSS for the menu background color.
 *
 * @since 1.0.0
 */
function primer_menu_background_color_css() {

	$scheme  = primer_get_color_scheme();
	$default = $scheme[2];
	$color   = get_theme_mod( 'menu_background_color', $default );

	if ( $color === $default ) {

		return;

	}

	$css = <<<CSS
	/* Menu Background Color */
	.main-navigation-container,
	.main-navigation li a,
	.main-navigation li.menu-item-has-children ul {
		background-color: %1\$s;
	}
	.main-navigation li a {
		color: %2\$s;
	}
CSS;

	$text_color = 'rgba( 255, 255, 255, 0.9)';

	/**
	 * Filter inline CSS for the menu background color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color
	 * @param string $text_color
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'custom_menu_background_color_css', $css, $color, $text_color );

	wp_add_inline_style( 'primer', sprintf( $css, $color, $text_color ) );

}
add_action( 'wp_enqueue_scripts', 'primer_menu_background_color_css', 11 );

/**
 * Enqueue inline CSS for the tagline text color.
 *
 * @since 1.0.0
 */
function primer_tagline_text_color_css() {

	$scheme  = primer_get_color_scheme();
	$default = $scheme[3];
	$color   = get_theme_mod( 'tagline_text_color', $default );

	if ( $color === $default ) {

		return;

	}

	$css = <<<CSS
	/* Tagline Text Color */
	.site-description {
		color: %s;
	}
CSS;

	/**
	 * Filter inline CSS for the tagline text color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'custom_tagline_text_color_css', $css, $color );

	wp_add_inline_style( 'primer', sprintf( $css, $color ) );

}
add_action( 'wp_enqueue_scripts', 'primer_tagline_text_color_css', 11 );

/**
 * Enqueue inline CSS for the link color.
 *
 * @since 1.0.0
 */
function primer_link_color_css() {

	$scheme  = primer_get_color_scheme();
	$default = $scheme[4];
	$color   = get_theme_mod( 'link_color', $default );

	if ( $color === $default ) {

		return;

	}

	$rgb = primer_hex2rgb( $color );

	if ( ! $rgb ) {

		return;

	}

	$css = <<<CSS
	/* Link Color */
	a {
		color: %1\$s;
	}
	a:hover {
		color: %2\$s;
	}

	button,
	a.button,
	a.button:visited,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.site-info-wrapper .site-info .social-menu a {
		background-color: %1\$s;
	}

	button:hover,
	a.button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	.site-info-wrapper .site-info .social-menu a:hover {
		background-color: %2\$s;
	}
CSS;

	$hover_color = vsprintf( 'rgba( %s, %s, %s, 0.8)', $rgb );

	/**
	 * Filter inline CSS for the link color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color
	 * @param array  $rgb
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'custom_link_color_css', $css, $color, $rgb );

	wp_add_inline_style( 'primer', sprintf( $css, $color, $hover_color ) );

}
add_action( 'wp_enqueue_scripts', 'primer_link_color_css', 11 );

/**
 * Enqueue inline CSS for the main text color.
 *
 * @since 1.0.0
 */
function primer_main_text_color_css() {

	$scheme  = primer_get_color_scheme();
	$default = $scheme[5];
	$color   = get_theme_mod( 'main_text_color', $default );

	if ( $color === $default ) {

		return;

	}

	$css = <<<CSS
	/* Main Text Color */
	.site-content,
	.site-content h1,
	.site-content h2,
	.site-content h3,
	.site-content h4,
	.site-content h5,
	.site-content h6,
	.site-content p,
	.site-content blockquote {
		color: %s;
	}
CSS;

	/**
	 * Filter inline CSS for the main text color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'custom_main_text_color_css', $css, $color );

	wp_add_inline_style( 'primer', sprintf( $css, $color ) );

}
add_action( 'wp_enqueue_scripts', 'primer_main_text_color_css', 11 );

/**
 * Enqueue inline CSS for the secondary text color.
 *
 * @since 1.0.0
 */
function primer_secondary_text_color_css() {

	$scheme  = primer_get_color_scheme();
	$default = $scheme[6];
	$color   = get_theme_mod( 'secondary_text_color', $default );

	if ( $color === $default ) {

		return;

	}

	$css = <<<CSS
	/* Secondary Text Color */
	.secondary_text_color,
	.site-info-text {
		color: %s;
	}
CSS;

	/**
	 * Filter inline CSS for the secondary text color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color
	 *
	 * @var string
	 */
	$css = (string) apply_filters( 'custom_secondary_text_color_css', $css, $color );

	wp_add_inline_style( 'primer', sprintf( $css, $color ) );

}
add_action( 'wp_enqueue_scripts', 'primer_secondary_text_color_css', 11 );

/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so:

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 */

/**
 * Add custom header support.
 *
 * @action after_setup_theme
 * @since  1.0.0
 * @uses   primer_header_style()
 * @uses   primer_admin_header_style()
 * @uses   primer_admin_header_image()
 */
function primer_custom_header_setup() {

	$scheme = primer_get_color_scheme();

	/**
	 * Filter the custom header args.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_custom_header_args',
		array(
			'default-image'          => '',
			'default-text-color'     => trim( $scheme[0], '#' ),
			'width'                  => 1000,
			'height'                 => 250,
			'flex-height'            => true,
			'wp-head-callback'       => 'primer_header_style',
			'admin-head-callback'    => 'primer_admin_header_style',
			'admin-preview-callback' => 'primer_admin_header_image',
		)
	);

	add_theme_support( 'custom-header', $args );

}
add_action( 'after_setup_theme', 'primer_custom_header_setup' );

if ( ! function_exists( 'primer_header_style' ) ) {

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see primer_custom_header_setup()
	 *
	 * @since 1.0.0
	 */
	function primer_header_style() {

		$header_text_color = get_header_textcolor();

		// If no custom options for text are set, let's bail
		// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
		if ( HEADER_TEXTCOLOR === $header_text_color ) {

			return;

		}

		?>
		<style type="text/css">
		<?php if ( 'blank' == $header_text_color ) : ?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php else : ?>
			.site-title a,
			.site-description {
				color: #<?php echo $header_text_color ?>;
			}
		<?php endif; ?>
		</style>
		<?php

	}

} // primer_header_style

if ( ! function_exists( 'primer_admin_header_style' ) ) {

	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * @see primer_custom_header_setup()
	 *
	 * @since 1.0.0
	 */
	function primer_admin_header_style() {

		?>
		<style type="text/css">
			.appearance_page_custom-header #headimg {
				border: none;
			}
			#headimg h1, #desc {}
			#headimg h1 {}
			#headimg h1 a {}
			#desc {}
			#headimg img {}
		</style>
		<?php

	}

} // primer_admin_header_style

if ( ! function_exists( 'primer_admin_header_image' ) ) {

	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * @see primer_custom_header_setup()
	 *
	 * @since 1.0.0
	 */
	function primer_admin_header_image() {

		$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );

		?>
		<div id="headimg">

			<h1 class="displaying-header-text"><a id="name"<?php echo $style // xss ok ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php bloginfo( 'name' ) ?></a></h1>

			<div class="displaying-header-text" id="desc"<?php echo $style // xss ok ?>><?php bloginfo( 'description' ) ?></div>

		<?php if ( get_header_image() ) : ?>

			<img src="<?php header_image() ?>" alt="">

		<?php endif; ?>

		</div>
		<?php

	}

} // primer_admin_header_image

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
 * Lists acceptable font pairings
 *
 * Returns a filterable list of font families for site
 * customization.
 *
 * @since 1.0.0
 */
function primer_get_fonts() {

	/**
	 * Filter the array of registered Primer fonts.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	return (array) apply_filters( 'primer_fonts',
		array(
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
		)
	);

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
 * @param  string $font (optional)
 *
 * @return string
 */
function primer_get_font( $font = 'primary_font' ) {

	$option = get_theme_mod( $font, primer_get_default_font( $font ) );
	$fonts  = primer_get_fonts();

	return in_array( $option, $fonts ) ? $option : $fonts[0];

}

/**
 * Return an array of font choices.
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
 * @since  1.0.0
 */
function primer_enqueue_google_fonts() {

	$primary_font  = primer_get_font();
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
 * @since  1.0.0
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
 * @since  1.0.0
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
