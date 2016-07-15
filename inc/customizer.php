<?php

class Primer_Customizer {

	/**
	 * Array of customizable colors.
	 *
	 * @var array
	 */
	public static $colors = array();

	/**
	 * Array of available color schemes.
	 *
	 * @var array
	 */
	public static $color_schemes = array();

	/**
	 * Array of available fonts.
	 *
	 * @var array
	 */
	public static $fonts = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Filter the registered color settings.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		self::$colors = (array) apply_filters( 'primer_colors',
			array(
				array(
					'name'    => 'header_textcolor',
					'default' => '#222222',
					'css'     => array(
						'.site-title a, .site-title a:visited' => array(
							'color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'background_color',
					'default' => '#f9f9f9',
				),
				array(
					'name'    => 'menu_background_color',
					'label'   => __( 'Menu Background Color', 'primer' ),
					'default' => '#222222',
					'css'     => array(
						'.main-navigation-container, .main-navigation li a, .main-navigation li.menu-item-has-children ul' => array(
							'background-color' => '%1$s',
						),
						'.main-navigation li a' => array(
							'color' => '#ffffff',
						),
					),
				),
				array(
					'name'    => 'tagline_text_color',
					'label'   => __( 'Tagline Text Color', 'primer' ),
					'default' => '#7c7c7c',
					'css'     => array(
						'.site-description' => array(
							'color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'link_color',
					'label'   => __( 'Link Color', 'primer' ),
					'default' => '#1585cf',
					'css'     => array(
						'a, a:visited' => array(
							'color' => '%1$s',
						),
						'button, a.button, a.button:visited, input[type="button"], input[type="reset"], input[type="submit"], .site-info-wrapper .site-info .social-menu a' => array(
							'background-color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'main_text_color',
					'label'   => __( 'Main Text Color', 'primer' ),
					'default' => '#1a1a1a',
					'css'     => array(
						'.site-content, .site-content h1, .site-content h2, .site-content h3, .site-content h4, .site-content h5, .site-content h6, .site-content p, .site-content blockquote' => array(
							'color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'secondary_text_color',
					'label'   => __( 'Secondary Text Color', 'primer' ),
					'default' => '#686868',
					'css'     => array(
						'.secondary_text_color, .site-info-text' => array(
							'color' => '%1$s',
						),
					),
				),
			)
		);

		/**
		 * Default color scheme.
		 *
		 * The `default` color scheme is required and not filterable.
		 * If you want to customize values in this scheme, do so via
		 * a `primer_colors` filter in your Child Theme.
		 *
		 * @var array
		 */
		$default_scheme = array(
			'default' => array(
				'label'  => __( 'Default', 'primer' ),
				'colors' => wp_list_pluck( self::$colors, 'default', 'name' ),
			),
		);

		/**
		 * Filter the available color schemes.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$custom_schemes = (array) apply_filters( 'primer_color_schemes',
			array(
				'dark' => array(
					'label'  => __( 'Dark', 'primer' ),
					'colors' => array(
						'header_textcolor'      => '#1a1a1a',
						'background_color'      => '#262626',
						'menu_background_color' => '#589ef2',
						'tagline_text_color'    => '#1a1a1a',
						'link_color'            => '#589ef2',
						'main_text_color'       => '#e5e5e5',
						'secondary_text_color'  => '#c1c1c1',
					),
				),
				'muted' => array(
					'label'  => __( 'Muted', 'primer' ),
					'colors' => array(
						'header_textcolor'      => '#5a6175',
						'background_color'      => '#d5d6e0',
						'menu_background_color' => '#5a6175',
						'tagline_text_color'    => '#888c99',
						'link_color'            => '#3e4c75',
						'main_text_color'       => '#4f5875',
						'secondary_text_color'  => '#888c99',
					),
				),
				'red' => array(
					'label'  => __( 'Red', 'primer' ),
					'colors' => array(
						'header_textcolor'      => '#222222',
						'background_color'      => '#ffffff',
						'menu_background_color' => '#640c1f',
						'tagline_text_color'    => '#999999',
						'link_color'            => '#640c1f',
						'main_text_color'       => '#402b30',
						'secondary_text_color'  => '#222222',
					),
				),
			)
		);

		self::$color_schemes = $default_scheme + $custom_schemes;

		/**
		 * Filter the array of available fonts.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		self::$fonts = (array) apply_filters( 'primer_fonts',
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

		add_action( 'after_setup_theme', array( $this, 'background' ) );
		add_action( 'after_setup_theme', array( $this, 'header' ) );
		add_action( 'after_setup_theme', array( $this, 'logo' ) );

		add_action( 'customize_register', array( $this, 'selective_refresh' ), 11 );
		add_action( 'customize_register', array( $this, 'color_scheme' ), 11 );
		add_action( 'customize_register', array( $this, 'colors' ), 11 );
		add_action( 'customize_register', array( $this, 'typography' ), 11 );

		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'color_scheme_control_js' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'color_scheme_preview_css' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_colors_inline_css' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_google_fonts' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fonts_inline_css' ), 11 );

	}

	/**
	 * Add custom background support.
	 *
	 * @action after_setup_theme
	 * @since  1.0.0
	 */
	public function background() {

		/**
		 * Filter the custom background args.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$args = (array) apply_filters( 'primer_custom_background_args',
			array(
				'default-color' => $this->get_default_color_hex( 'background_color', 'default' ),
			)
		);

		add_theme_support( 'custom-background', $args );

	}

	/**
	 * Add custom header support.
	 *
	 * @action after_setup_theme
	 * @since  1.0.0
	 * @uses   $this->header_css()
	 */
	public function header() {

		/**
		 * Filter the custom header args.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$args = (array) apply_filters( 'primer_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => self::get_default_color_hex( 'header_textcolor', 'default' ),
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => array( $this, 'header_css' ),
			)
		);

		add_theme_support( 'custom-header', $args );

	}

	/**
	 * Custom header CSS.
	 *
	 * @see   $this->header()
	 * @since 1.0.0
	 */
	public function header_css() {

		$color = get_header_textcolor();
		$css   = ! empty( self::$colors['header_textcolor']['css'] ) ? self::$colors['header_textcolor']['css'] : array();

		if ( 'blank' === $color ) {

			$css = array(
				'.site-title, .site-description' => array(
					'position' => 'absolute',
					'clip'     => 'rect(1px, 1px, 1px, 1px)',
				),
			);

		}

		if ( $color && $css ) {

			printf(
				"<style type='text/css'>\n%s\n</style>",
				sprintf( self::parse_css_rules( $css ), $color )
			);

		}

	}

	/**
	 * Add custom logo support.
	 *
	 * @action after_setup_theme
	 * @since  1.0.0
	 */
	public function logo() {

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

	/**
	 * Adds postMessage support for site title and description for the Customizer.
	 *
	 * @action customize_save
	 * @since  1.0.0
	 * @uses   $this->blogname()
	 * @uses   $this->blogdescription()
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function selective_refresh( WP_Customize_Manager $wp_customize ) {

		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		if ( ! isset( $wp_customize->selective_refresh ) ) {

			return;

		}

		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title a',
				'container_inclusive' => false,
				'render_callback'     => array( $this, 'blogname' ),
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => array( $this, 'blogdescription' ),
			)
		);

	}

	/**
	 * Display the blog name.
	 *
	 * @since 1.0.0
	 * @see   $this->selective_refresh()
	 */
	public function blogname() {

		bloginfo( 'name' );

	}

	/**
	 * Display the blog description.
	 *
	 * @since 1.0.0
	 * @see   $this->selective_refresh()
	 */
	public function blogdescription() {

		bloginfo( 'description' );

	}

	/**
	 * Register a color scheme setting.
	 *
	 * @action customize_register
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function color_scheme( WP_Customize_Manager $wp_customize ) {

		if ( count( self::$color_schemes ) < 2 ) {

			return;

		}

		$wp_customize->add_setting(
			'color_scheme',
			array(
				'default'           => 'default',
				'sanitize_callback' => array( __CLASS__, 'sanitize_color_scheme' ),
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'color_scheme',
			array(
				'label'    => __( 'Base Color Scheme', 'primer' ),
				'section'  => 'colors',
				'type'     => 'select',
				'choices'  => array_combine( array_keys( self::$color_schemes ), wp_list_pluck( self::$color_schemes, 'label' ) ),
				'priority' => 1,
			)
		);

	}

	/**
	 * Register custom colors settings.
	 *
	 * @action customize_register
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function colors( WP_Customize_Manager $wp_customize ) {

		foreach ( self::$colors as $color ) {

			$this->register_color_setting( $wp_customize, $color );

		}

	}

	/**
	 * Register a custom color setting.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @param array                $color
	 */
	public function register_color_setting( WP_Customize_Manager $wp_customize, array $color ) {

		if ( empty( $color['name'] ) || empty( $color['default'] ) || empty( $color['label'] ) ) {

			return;

		}

		$name = sanitize_key( $color['name'] );

		$wp_customize->add_setting(
			$name,
			array(
				'default'           => sanitize_hex_color( $color['default'] ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$name,
				array(
					'label'   => $color['label'],
					'section' => 'colors',
				)
			)
		);

	}

	function customize_preview_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-customize-preview', get_template_directory_uri() . "/assets/js/customizer{$suffix}.js", array( 'customize-preview' ), PRIMER_VERSION, true );

	}

	public function color_scheme_control_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-color-scheme-control', get_template_directory_uri() . "/assets/js/color-scheme-control{$suffix}.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );

		wp_localize_script( 'primer-color-scheme-control', 'colorSchemes', self::$color_schemes );

	}

	public function color_scheme_preview_css() {

		?>
		<script type="text/html" id="tmpl-primer-color-scheme">
		<?php

		foreach ( self::$colors as $color ) {

			if ( empty( $color['name'] ) || empty( $color['css'] ) || ! is_array( $color['css'] ) ) {

				continue;

			}

			printf(
				self::parse_css_rules( $color['css'] ),
				sprintf( '{{ data.%s }}', $color['name'] )
			);

		}

		?>
		</script>
		<?php

	}

	/**
	 * Enqueue inline CSS for custom colors.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_colors_inline_css() {

		foreach ( self::$colors as $color ) {

			$this->add_color_inline_css( $color );

		}

	}

	/**
	 * Add color inline CSS.
	 *
	 * @see   $this->enqueue_colors_inline_css()
	 * @since 1.0.0
	 *
	 * @param array $color
	 */
	public function add_color_inline_css( array $color ) {

		if ( empty( $color['name'] ) || empty( $color['css'] ) ) {

			return;

		}

		$default = self::get_default_color_hex( $color['name'], 'default' );
		$hex     = trim( get_theme_mod( $color['name'], $default ), '#' );

		if ( $hex === $default ) {

			return;

		}

		wp_add_inline_style( 'primer', sprintf( self::parse_css_rules( $color['css'] ), '#' . $hex ) );

	}

	public static function parse_css_rules( array $rules ) {

		$output = '';

		foreach ( $rules as $rule => $properties ) {

			$output .= sprintf(
				"%s {\n",
				implode( ",\n", array_map( 'trim', explode( ',', $rule ) ) )
			);

			foreach ( $properties as $property => $value ) {

				$output .= sprintf( "\t%s: %s;\n", $property, $value );

			}

			$output .= "}\n";

		}

		return $output;

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
	public static function color_scheme_exists( $scheme ) {

		return array_key_exists( $scheme, self::$color_schemes );

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
	public static function sanitize_color_scheme( $scheme ) {

		return self::color_scheme_exists( $scheme ) ? $scheme : 'default';

	}

	/**
	 * Return the default HEX value for a color in a scheme.
	 *
	 * @param  string $color
	 * @param  string $scheme (optional)
	 * @param  bool   $hash   (optional)
	 *
	 * @return string|null
	 */
	public static function get_default_color_hex( $color, $scheme = '', $hash = false ) {

		$scheme = empty( $scheme ) ? self::get_current_color_scheme() : self::$color_schemes[ self::sanitize_color_scheme( $scheme ) ];
		$hex    = isset( $scheme['colors'][ $color ] ) ? $scheme['colors'][ $color ] : null;

		return ( $hash ) ? sanitize_hex_color( '#' . trim( $hex, '#' ) ) : sanitize_hex_color_no_hash( trim( $hex, '#' ) );

	}

	/**
	 * Return the current color scheme name.
	 *
	 * @return string
	 */
	public static function get_current_color_scheme_name() {

		return self::sanitize_color_scheme( get_theme_mod( 'color_scheme', 'default' ) );

	}

	/**
	 * Return the current color scheme array.
	 *
	 * @return array
	 */
	public static function get_current_color_scheme() {

		return self::$color_schemes[ self::get_current_color_scheme_name() ];

	}

	/**
	 * Register typography section and settings.
	 *
	 * @action customize_registers
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function typography( WP_Customize_Manager $wp_customize ) {

		if ( ! self::$fonts ) {

			return;

		}

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
				'default'           => self::get_default_font(),
				'sanitize_callback' => array( __CLASS__, 'sanitize_primary_font' ),
			)
		);

		$font_choices = array_combine( self::$fonts, self::$fonts );

		$wp_customize->add_control(
			'primary_font',
			array(
				'label'   => __( 'Primary Font', 'primer' ),
				'section' => 'typography',
				'type'    => 'select',
				'choices' => $font_choices,
			)
		);

		if ( self::secondary_font_enabled() ) {

			$wp_customize->add_setting(
				'secondary_font',
				array(
					'default'           => self::get_default_font( 'secondary_font' ),
					'sanitize_callback' => array( __CLASS__, 'sanitize_secondary_font' ),
				)
			);

			$wp_customize->add_control(
				'secondary_font',
				array(
					'label'   => __( 'Secondary Font', 'primer' ),
					'section' => 'typography',
					'type'    => 'select',
					'choices' => $font_choices,
				)
			);

		}

	}

	/**
	 * Check if a secondary font is enabled.
	 *
	 * If you want to disable the secondary font please use
	 * this filter to your child theme:
	 *
	 * add_filter( 'primer_secondary_font_enabled', false );
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function secondary_font_enabled() {

		/**
		 * Filter if the secondary font should be enabled.
		 *
		 * @since 1.0.0
		 *
		 * @var bool
		 */
		return (bool) apply_filters( 'primer_secondary_font_enabled', true );

	}

	/**
	 * Return the default font for a given font type.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font_type (optional)
	 *
	 * @return string
	 */
	public static function get_default_font( $font_type = 'primary_font' ) {

		$first  = ! empty( self::$fonts[0] ) ? self::$fonts[0] : null;
		$second = ! empty( self::$fonts[1] ) ? self::$fonts[1] : $first;

		return ( 'secondary_font' === $font_type ) ? $second : $first;

	}

	/**
	 * Return the primary font.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_primary_font() {

		return self::sanitize_primary_font( get_theme_mod( 'primary_font', self::get_default_font() ) );

	}

	/**
	 * Return the secondary font.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_secondary_font() {

		return self::sanitize_secondary_font( get_theme_mod( 'secondary_font', self::get_default_font( 'secondary_font' ) ) );

	}

	/**
	 * Sanitize the primary font.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font
	 *
	 * @return string
	 */
	public static function sanitize_primary_font( $font ) {

		return in_array( $font, self::$fonts ) ? $font : self::get_default_font();

	}

	/**
	 * Sanitize the primary font.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font
	 *
	 * @return string
	 */
	public static function sanitize_secondary_font( $font ) {

		return in_array( $font, self::$fonts ) ? $font : self::get_default_font( 'secondary_font' );

	}

	/**
	 * Enqueue Google fonts.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_google_fonts() {

		$primary_font  = self::get_primary_font();
		$font_families = $primary_font . ':300,400,700';

		if ( self::secondary_font_enabled() ) {

			$secondary_font = self::get_secondary_font();

			$font_families = array(
				$primary_font . ':300,400,700',
				$secondary_font . ':300,400,700',
			);

			$font_families = implode( '|', $font_families );

		}

		/**
		 * Filter the Google fonts query args.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$query_args = (array) apply_filters( 'primer_google_fonts_query_args',
			array(
				'family' => $font_families,
				'subset' => 'latin',
			)
		);

		wp_enqueue_style( 'primer-google-fonts', add_query_arg( $query_args, '//fonts.googleapis.com/css' ), false );

	}

	/**
	 * Add font inline CSS.
	 *
	 * @action   wp_enqueue_scripts
	 * @since    1.0.0
	 *
	 * @param string $font_type
	 *
	 * @internal param array $color
	 */
	public function enqueue_fonts_inline_css( $font_type = 'primary_font' ) {

		$css = array(
			'body, h1, h2, h3, h4, h5, h6, label' => array(
				'font-family' => '"%s", sans-serif',
			),
		);

		wp_add_inline_style( 'primer-google-fonts', sprintf( self::parse_css_rules( $css ), self::get_primary_font() ) );

		if ( ! self::secondary_font_enabled() ) {

			return;

		}

		$css = array(
			'p, blockquote, .fl-callout-text' => array(
				'font-family' => '"%s", sans-serif',
			),
		);

		wp_add_inline_style( 'primer-google-fonts', sprintf( self::parse_css_rules( $css ), self::get_secondary_font() ) );

	}

}

new Primer_Customizer;
