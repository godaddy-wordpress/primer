<?php

class Primer_Customizer_Colors {

	/**
	 * Array of customizable colors.
	 *
	 * @var array
	 */
	protected $colors = array();

	/**
	 * Array of available color schemes.
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
						'a, a:visited, .entry-footer a' => array(
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
						'.site-content, .site-content h1, .site-content h2, .site-content h3, .site-content h4, .site-content h5, .site-content h6, .site-content p, .site-content blockquote, legend' => array(
							'color' => '%1$s',
						),
					),
				),
				array(
					'name'    => 'secondary_text_color',
					'label'   => __( 'Secondary Text Color', 'primer' ),
					'default' => '#686868',
					'css'     => array(
						'blockquote, .entry-meta, .entry-footer, .comment-list li .comment-meta .says, .comment-list li .comment-metadata, .comment-reply-link, #respond .logged-in-as, .fl-callout-text' => array(
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

		$this->color_schemes = $default_scheme + $custom_schemes;

		add_action( 'customize_register', array( $this, 'colors' ), 11 );
		add_action( 'customize_register', array( $this, 'color_scheme' ), 11 );

		add_action( 'customize_controls_enqueue_scripts',      array( $this, 'color_scheme_control_js' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'color_scheme_preview_css' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_colors_inline_css' ), 11 );

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

		foreach ( $this->colors as $color ) {

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

		$default = $this->get_default_color_hex( $color['name'], 'default' );
		$hex     = trim( get_theme_mod( $color['name'], $default ), '#' );

		if ( $hex === $default ) {

			return;

		}

		wp_add_inline_style( 'primer', sprintf( Primer_Customizer::parse_css_rules( $color['css'] ), '#' . $hex ) );

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
	public function get_default_color_hex( $color, $scheme = '', $hash = false ) {

		$scheme = empty( $scheme ) ? $this->get_current_color_scheme() : $this->color_schemes[ $this->sanitize_color_scheme( $scheme ) ];
		$hex    = isset( $scheme['colors'][ $color ] ) ? $scheme['colors'][ $color ] : null;

		return ( $hash ) ? sanitize_hex_color( '#' . trim( $hex, '#' ) ) : sanitize_hex_color_no_hash( trim( $hex, '#' ) );

	}

	/**
	 * Get header textcolor
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_header_textcolor_css() {

		if ( ! empty( $this->colors['header_textcolor']['css'] ) ) {

			return $this->colors['header_textcolor']['css'];

		}

		return array();

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

		$wp_customize->add_control(
			'color_scheme',
			array(
				'label'    => __( 'Base Color Scheme', 'primer' ),
				'section'  => 'colors',
				'type'     => 'select',
				'choices'  => array_combine( array_keys( $this->color_schemes ), wp_list_pluck( $this->color_schemes, 'label' ) ),
				'priority' => 1,
			)
		);

	}

	/**
	 * Enqueue color scheme control in customizer
	 *
	 * @action customize_controls_enqueue_scripts
	 */
	public function color_scheme_control_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-color-scheme-control', get_template_directory_uri() . "/assets/js/color-scheme-control{$suffix}.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );

		wp_localize_script( 'primer-color-scheme-control', 'colorSchemes', $this->color_schemes );

	}

	/**
	 * Inline style for color scheme
	 *
	 * @action customize_controls_print_footer_scripts
	 */
	public function color_scheme_preview_css() {

		?>
		<script type="text/html" id="tmpl-primer-color-scheme">
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
	 * @return string
	 */
	public function get_current_color_scheme_name() {

		return $this->sanitize_color_scheme( get_theme_mod( 'color_scheme', 'default' ) );

	}

	/**
	 * Return the current color scheme array.
	 *
	 * @return array
	 */
	public function get_current_color_scheme() {

		return $this->color_schemes[ $this->get_current_color_scheme_name() ];

	}
}
