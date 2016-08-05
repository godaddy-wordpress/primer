<?php

class Primer_Customizer_Colors {

	/**
	 * Array of customizable colors.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $colors = array();

	/**
	 * Array of available color schemes.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $color_schemes = array();

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
		$this->colors = (array) apply_filters( 'primer_colors',
			array(
				array(
					'name'    => 'header_textcolor',
					'default' => '#f4f5f9',
					'css'     => array(
						'.site-title a, .site-title a:visited' => array(
							'color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.site-title a:hover, .site-title a:visited:hover' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				array(
					'name'    => 'background_color',
					'default' => '#f4f5f9',
					'css'     => array(
						'body' => array(
							'background' => '%1$s',
						),
						'.social-menu a, .social-menu a:visited, .social-menu a:hover, .social-menu a:visited:hover' => array(
							'color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'header_background_color',
					'label'   => esc_html__( 'Header Background Color', 'primer' ),
					'default' => '#0b3954',
					'css'     => array(
						'.site-header' => array(
							'background-color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'menu_background_color',
					'label'   => esc_html__( 'Menu Background Color', 'primer' ),
					'default' => '#0b3954',
					'css'     => array(
						'.main-navigation-container, .main-navigation ul ul' => array(
							'background-color' => '%1$s',
						),
						'.main-navigation li a, .main-navigation li a:hover, .main-navigation li a:visited:hover' => array(
							'color' => '#ffffff',
						),
						'.sub-menu .menu-item-has-children > a::after' => array(
							'border-color' => '#ffffff',
						),
						'.menu-toggle div' => array(
							'background-color' => '#ffffff',
						),
					),
				),
				array(
					'name'    => 'footer_background_color',
					'label'   => esc_html__( 'Footer Background Color', 'primer' ),
					'default' => '#0b3954',
					'css'     => array(
						'.site-footer' => array(
							'background-color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'tagline_text_color',
					'label'   => esc_html__( 'Tagline Text Color', 'primer' ),
					'default' => '#f4f5f9',
					'css'     => array(
						'.site-description' => array(
							'color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'link_color',
					'label'   => esc_html__( 'Link Color', 'primer' ),
					'default' => '#ff6663',
					'css'     => array(
						'a, a:visited, .entry-title a:hover, .entry-title a:visited:hover' => array(
							'color' => '%1$s',
						),
						'button, a.button, input[type="button"], input[type="reset"], input[type="submit"], .social-menu a:hover' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'a:hover, a:visited:hover, a:focus, a:visited:focus, a:active, a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
						'button:hover, button:active, button:focus, a.button:hover, a.button:active, a.button:focus, input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' => array(
							'background-color' => 'rgba(%1$s, 0.8)',
						),
						'button, button:hover, button:active, button:focus, a.button, a.button:hover, a.button:active, a.button:focus, a.button:visited, a.button:visited:hover, a.button:visited:active, a.button:visited:focus, input[type="button"], input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus, input[type="reset"], input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus, input[type="submit"], input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' => array(
							'color' => '#ffffff',
						),
						'.comment-list li.bypostauthor' => array(
							'border-color' => 'rgba(%1$s, 0.2)',
						),
					),
				),
				array(
					'name'    => 'main_text_color',
					'label'   => esc_html__( 'Main Text Color', 'primer' ),
					'default' => '#0b3954',
					'css'     => array(
						'body, input, select, textarea, h1, h2, h3, h4, h5, h6, .entry-title a, .entry-title a:visited, .entry-title a:before, input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, input[type="range"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="time"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="color"]:focus, textarea:focus' => array(
							'color' => '%1$s',
						),
						'.social-menu a' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'hr' => array(
							'background-color' => 'rgba(%1$s, 0.1)',
						),
						'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], textarea' => array(
							'color'        => 'rgba(%1$s, 0.5)',
							'border-color' => 'rgba(%1$s, 0.1)',
						),
						'select, fieldset, blockquote, pre, code, abbr, acronym, .hentry table th, .hentry table td' => array(
							'border-color' => 'rgba(%1$s, 0.1)',
						),
						'.hentry table tr:hover td' => array(
							'background-color' => 'rgba(%1$s, 0.075)',
						),
					),
				),
				array(
					'name'    => 'secondary_text_color',
					'label'   => esc_html__( 'Secondary Text Color', 'primer' ),
					'default' => '#686868',
					'css'     => array(
						'blockquote, .entry-meta, .entry-footer, .comment-meta .says, .logged-in-as, .fl-callout-text' => array(
							'color' => '%1$s',
						),
					),
				),
			)
		);

		if ( ! $this->colors ) {

			return;

		}

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
				'label'  => esc_html__( 'Default', 'primer' ),
				'colors' => wp_list_pluck( $this->colors, 'default', 'name' ),
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
					'label'  => esc_html__( 'Dark', 'primer' ),
					'colors' => array(
						'header_textcolor'        => '#ffffff',
						'background_color'        => '#333333',
						'header_background_color' => '#333333',
						'menu_background_color'   => '#444444',
						'footer_background_color' => '#222222',
						'tagline_text_color'      => '#999999',
						'link_color'              => '#589ef2',
						'main_text_color'         => '#e5e5e5',
						'secondary_text_color'    => '#c1c1c1',
					),
				),
				'muted' => array(
					'label'  => esc_html__( 'Muted', 'primer' ),
					'colors' => array(
						'header_textcolor'        => '#5a6175',
						'background_color'        => '#d5d6e0',
						'header_background_color' => '#d5d6e0',
						'menu_background_color'   => '#5a6175',
						'footer_background_color' => '#5a6175',
						'tagline_text_color'      => '#888c99',
						'link_color'              => '#3e4c75',
						'main_text_color'         => '#4f5875',
						'secondary_text_color'    => '#888c99',
					),
				),
				'red' => array(
					'label'  => esc_html__( 'Red', 'primer' ),
					'colors' => array(
						'header_textcolor'        => '#402b30',
						'background_color'        => '#f9f9f9',
						'header_background_color' => '#f9f9f9',
						'menu_background_color'   => '#640c1f',
						'footer_background_color' => '#640c1f',
						'tagline_text_color'      => '#999999',
						'link_color'              => '#640c1f',
						'main_text_color'         => '#402b30',
						'secondary_text_color'    => '#222222',
					),
				),
			)
		);

		$this->color_schemes = $default_scheme + $custom_schemes;

		add_action( 'customize_register', array( $this, 'colors' ), 11 );
		add_action( 'customize_register', array( $this, 'color_scheme' ), 11 );

		add_action( 'customize_controls_enqueue_scripts',      array( $this, 'color_scheme_control_js' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'color_scheme_preview_css' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_colors_inline_css' ), 11 );

		add_action( 'after_setup_theme', array( $this, 'header' ) );
		add_action( 'after_setup_theme', array( $this, 'background' ) );

	}

	/**
	 * Register custom colors settings.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function colors( WP_Customize_Manager $wp_customize ) {

		foreach ( $this->colors as $color ) {

			$this->register_color_setting( $wp_customize, $color );

		}

	}

	/**
	 * Register a custom color setting.
	 *
	 * @since 1.0.0
	 * @see   $this->colors()
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

	/**
	 * Enqueue inline CSS for custom colors.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_colors_inline_css() {

		foreach ( $this->colors as $color ) {

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

		$default = $this->get_default_color( $color['name'], 'default' );
		$hex     = trim( get_theme_mod( $color['name'], $default ), '#' );
		$css     = sprintf( Primer_Customizer::parse_css_rules( $color['css'] ), '#' . $hex );

		if ( ! empty( $color['rgba_css'] ) ) {

			$css .= sprintf( Primer_Customizer::parse_css_rules( $color['rgba_css'] ), implode( ', ', primer_hex2rgb( $hex ) ) );

		}

		wp_add_inline_style( 'primer', $css );

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
	public function get_default_color( $color, $scheme = '', $hash = false ) {

		/**
		 * Load for backwards compatibility prior to WordPress 4.6.
		 *
		 * @link  https://core.trac.wordpress.org/ticket/27583
		 * @since 1.0.0
		 */
		if ( ! function_exists( 'sanitize_hex_color' ) || ! function_exists( 'sanitize_hex_color_no_hash' ) ) {

			require_once ABSPATH . 'wp-includes/class-wp-customize-manager.php';

		}

		$scheme = empty( $scheme ) ? $this->get_current_color_scheme_array() : $this->color_schemes[ $this->sanitize_color_scheme( $scheme ) ];
		$hex    = isset( $scheme['colors'][ $color ] ) ? $scheme['colors'][ $color ] : null;

		return ( $hash ) ? sanitize_hex_color( '#' . trim( $hex, '#' ) ) : sanitize_hex_color_no_hash( trim( $hex, '#' ) );

	}

	/**
	 * Return an array of CSS rules for a color.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $color
	 *
	 * @return array
	 */
	public function get_color_css( $color ) {

		return ! empty( $this->colors[ $color ]['css'] ) ? $this->colors[ $color ]['css'] : array();

	}

	/**
	 * Register a color scheme setting.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function color_scheme( WP_Customize_Manager $wp_customize ) {

		if ( count( $this->color_schemes ) < 2 ) {

			return;

		}

		$wp_customize->add_setting(
			'color_scheme',
			array(
				'default'           => 'default',
				'sanitize_callback' => array( $this, 'sanitize_color_scheme' ),
				'transport'         => 'postMessage',
			)
		);

		$choices = array_combine(
			array_keys( $this->color_schemes ),
			wp_list_pluck( $this->color_schemes, 'label' )
		);

		$wp_customize->add_control(
			'color_scheme',
			array(
				'label'    => esc_html__( 'Base Color Scheme', 'primer' ),
				'section'  => 'colors',
				'type'     => 'select',
				'choices'  => $choices,
				'priority' => 1,
			)
		);

	}

	/**
	 * Enqueue color scheme control in the Customizer.
	 *
	 * @action customize_controls_enqueue_scripts
	 * @since  1.0.0
	 */
	public function color_scheme_control_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-color-scheme-control', get_template_directory_uri() . "/assets/js/admin/color-scheme-control{$suffix}.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );

		$color_schemes = $this->color_schemes;

		$color_schemes['custom'] = [
			'label' => sprintf( '- %s -' ,__( 'Custom', 'primer' ) ),
		];

		wp_localize_script( 'primer-color-scheme-control', 'colorSchemes', $color_schemes );

	}

	/**
	 * Inline style for color scheme
	 *
	 * @action customize_controls_print_footer_scripts
	 */
	public function color_scheme_preview_css() {

		?>
		<script type="text/html" id="tmpl-primer-color-scheme-css">
			<?php

			foreach ( $this->colors as $color ) {

				if ( empty( $color['name'] ) || empty( $color['css'] ) || ! is_array( $color['css'] ) ) {

					continue;

				}

				printf(
					Primer_Customizer::parse_css_rules( $color['css'] ),
					sprintf( '{{ data.%s }}', $color['name'] )
				);

			}

			?>
		</script>
		<?php

		$rgba_colors = $this->get_rgba_css();

		if ( ! $rgba_colors ) {

			return;

		}

		?>
		<script type="text/html" id="tmpl-primer-color-scheme-css-rgba">
			<?php

			foreach ( $rgba_colors as $name => $css ) {

				printf(
					Primer_Customizer::parse_css_rules( $css ),
					sprintf( '{{ data.%s }}', $name )
				);

			}

			?>
		</script>
		<?php

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
	public function color_scheme_exists( $scheme ) {

		return array_key_exists( $scheme, $this->color_schemes );

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
	public function sanitize_color_scheme( $scheme ) {

		return $this->color_scheme_exists( $scheme ) ? $scheme : 'default';

	}

	/**
	 * Return the current color scheme name.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_current_color_scheme() {

		return $this->sanitize_color_scheme( get_theme_mod( 'color_scheme', 'default' ) );

	}

	/**
	 * Return the current color scheme array.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_current_color_scheme_array() {

		return $this->color_schemes[ $this->get_current_color_scheme() ];

	}

	/**
	 * Return an array of CSS for colors supporting RGBA.
	 *
	 * @return array
	 */
	public function get_rgba_css() {

		$colors = array();

		foreach ( $this->colors as $color ) {

			if ( ! empty( $color['name'] ) && ! empty( $color['rgba_css'] ) && is_array( $color['rgba_css'] ) ) {

				$colors[ $color['name'] ] = $color['rgba_css'];

			}

		}

		return $colors;

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
				'default-text-color' => $this->get_default_color( 'header_textcolor', 'default' ),
				'width'              => 1600,
				'height'             => 400,
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
		$css   = $this->get_color_css( 'header_textcolor' );

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
				sprintf( Primer_Customizer::parse_css_rules( $css ), $color )
			);

		}

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
				'default-color' => $this->get_default_color( 'background_color', 'default' ),
			)
		);

		add_theme_support( 'custom-background', $args );

	}

}

new Primer_Customizer_Colors;
