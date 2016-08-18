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
				/**
				 * Text colors
				 */
				'header_textcolor' => array(
					'label'    => esc_html__( 'Site Title Color', 'primer' ),
					'default'  => '#f4f5f9',
					'section'  => 'title_tagline',
					'priority' => 11,
					'css'      => array(
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
				'tagline_text_color' => array(
					'label'    => esc_html__( 'Tagline Color', 'primer' ),
					'default'  => '#f4f5f9',
					'section'  => 'title_tagline',
					'priority' => 11,
					'css'      => array(
						'.site-description' => array(
							'color' => '%1$s',
						),
					),
				),
				'hero_text_color' => array(
					'label'   => esc_html__( 'Hero Text Color', 'primer' ),
					'default' => '#f4f5f9',
					'section' => 'header_image',
					'css'     => array(
						'.hero,
						.hero .widget h1,
						.hero .widget h2,
						.hero .widget h3,
						.hero .widget h4,
						.hero .widget h5,
						.hero .widget h6,
						.hero .widget p,
						.hero .widget ul,
						.hero .widget ol,
						.hero .widget li,
						.hero .page-header h1' => array(
							'color' => '%1$s',
						),
					),
				),
				'menu_text_color' => array(
					'label'   => esc_html__( 'Primary Menu Text Color', 'primer' ),
					'default' => '#f4f5f9',
					'section' => 'menu_locations',
					'css'     => array(
						'.main-navigation ul li a, .main-navigation ul li a:hover, .main-navigation ul li a:visited:hover' => array(
							'color' => '%1$s',
						),
						'.main-navigation .sub-menu .menu-item-has-children > a::after' => array(
							'border-right-color' => '%1$s',
							'border-left-color'  => '%1$s', // RTL support
						),
						'.menu-toggle div' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.main-navigation ul li a:hover' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'heading_text_color' => array(
					'label'    => esc_html__( 'Heading Text Color', 'primer' ),
					'default'  => '#0b3954',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'h1, h2, h3, h4, h5, h6,
						label,
						legend,
						table th,
						dl dt,
						.entry-title, .entry-title a, .entry-title a:visited,
						.widget-title' => array(
							'color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.entry-title a:hover, .entry-title a:visited:hover, .entry-title a:focus, .entry-title a:visited:focus, .entry-title a:active, .entry-title a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'main_text_color' => array(
					'label'    => esc_html__( 'Main Text Color', 'primer' ),
					'default'  => '#0b3954',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'body,
						input,
						select,
						textarea,
						input[type="text"]:focus,
						input[type="email"]:focus,
						input[type="url"]:focus,
						input[type="password"]:focus,
						input[type="search"]:focus,
						input[type="number"]:focus,
						input[type="tel"]:focus,
						input[type="range"]:focus,
						input[type="date"]:focus,
						input[type="month"]:focus,
						input[type="week"]:focus,
						input[type="time"]:focus,
						input[type="datetime"]:focus,
						input[type="datetime-local"]:focus,
						input[type="color"]:focus,
						textarea:focus,
						.fl-callout-text,
						.fl-rich-text' => array(
							'color' => '%1$s',
						),
						'.social-menu a, .social-menu a:visited' => array(
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
				'secondary_text_color' => array(
					'label'    => esc_html__( 'Secondary Text Color', 'primer' ),
					'default'  => '#686868',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'blockquote,
						.entry-meta,
						.entry-footer,
						.comment-meta .says,
						.logged-in-as' => array(
							'color' => '%1$s',
						),
					),
				),
				'footer_widget_text_color' => array(
					'label'    => esc_html__( 'Footer Widget Text Color', 'primer' ),
					'default'  => '#0b3954',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'.site-footer .widget' => array(
							'color' => '%1$s',
						),
					),
				),
				'footer_text_color' => array(
					'label'    => esc_html__( 'Footer Text Color', 'primer' ),
					'default'  => '#0b3954',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'.site-info-text' => array(
							'color' => '%1$s',
						),
					),
				),
				/**
				 * Link / Button colors
				 */
				'link_color' => array(
					'label'    => esc_html__( 'Link Color', 'primer' ),
					'default'  => '#ff6663',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'a, a:visited,
						.entry-title a:hover, .entry-title a:visited:hover' => array(
							'color' => '%1$s',
						),
						'.social-menu a:hover, .social-menu a:visited:hover' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'a:hover, a:visited:hover, a:focus, a:visited:focus, a:active, a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
						'.comment-list li.bypostauthor' => array(
							'border-color' => 'rgba(%1$s, 0.2)',
						),
					),
				),
				'button_color' => array(
					'label'    => esc_html__( 'Button Color', 'primer' ),
					'default'  => '#ff6663',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'button,
						a.button, a.button:visited,
						.content-area .fl-builder-content a.fl-button, .content-area .fl-builder-content a.fl-button:visited,
						input[type="button"],
						input[type="reset"],
						input[type="submit"]' => array(
							'background'       => 'none',
							'background-color' => '%1$s',
							'border-color'     => '%1$s',
						),
					),
					'rgba_css' => array(
						'button:hover, button:active, button:focus,
						a.button:hover, a.button:active, a.button:focus, a.button:visited:hover, a.button:visited:active, a.button:visited:focus,
						.content-area .fl-builder-content a.fl-button:hover, .content-area .fl-builder-content a.fl-button:active, .content-area .fl-builder-content a.fl-button:focus, .content-area .fl-builder-content a.fl-button:visited:hover, .content-area .fl-builder-content a.fl-button:visited:active, .content-area .fl-builder-content a.fl-button:visited:focus,
						input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus,
						input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus,
						input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' => array(
							'background'       => 'none',
							'background-color' => 'rgba(%1$s, 0.8)',
							'border-color'     => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'button_text_color' => array(
					'label'    => esc_html__( 'Button Text Color', 'primer' ),
					'default'  => '#f4f5f9',
					'section'  => 'fonts',
					'priority' => 20,
					'css'      => array(
						'button, button:hover, button:active, button:focus,
						a.button, a.button:hover, a.button:active, a.button:focus, a.button:visited, a.button:visited:hover, a.button:visited:active, a.button:visited:focus,
						a.fl-button, a.fl-button:hover, a.fl-button:active, a.fl-button:focus, a.fl-button:visited, a.fl-button:visited:hover, a.fl-button:visited:active, a.fl-button:visited:focus,
						input[type="button"], input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus,
						input[type="reset"], input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus,
						input[type="submit"], input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' => array(
							'color' => '%1$s',
						),
					),
				),
				/**
				 * Background colors
				 */
				'background_color' => array(
					'label'   => esc_html__( 'Background Color', 'primer' ),
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
				'content_background_color' => array(
					'label'   => esc_html__( 'Content Background Color', 'primer' ),
					'default' => '#ffffff',
					'section' => 'background_image',
					'css'     => array(
						'.hentry, .widget, #page > .page-title-container' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'hero_background_color' => array(
					'label'   => esc_html__( 'Hero Background Color', 'primer' ),
					'default' => '#0b3954',
					'section' => 'header_image',
					'css'     => array(
						primer_get_hero_image_selector() => array(
							'background-color' => '%1$s',
						),
					),
				),
				'menu_background_color' => array(
					'label'   => esc_html__( 'Primary Menu Background Color', 'primer' ),
					'default' => '#0b3954',
					'section' => 'menu_locations',
					'css'     => array(
						'.main-navigation-container, .main-navigation ul ul, .main-navigation .sub-menu' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'footer_widget_background_color' => array(
					'label'   => esc_html__( 'Footer Widget Background Color', 'primer' ),
					'default' => '#0b3954',
					'section' => 'primer_footer',
					'css'     => array(
						'.site-footer' => array(
							'background' => '%1$s',
						),
					),
				),
				'footer_background_color' => array(
					'label'   => esc_html__( 'Footer Background Color', 'primer' ),
					'default' => '#f4f5f9',
					'section' => 'primer_footer',
					'css'     => array(
						'.site-info-wrapper' => array(
							'background' => '%1$s',
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
				'colors' => array_combine(
					array_keys( $this->colors ),
					wp_list_pluck( $this->colors, 'default' )
				),
			),
			'_custom' => array(
				'label' => sprintf( '- %s -' , __( 'Custom', 'primer' ) ),
			)
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
				'bronze' => array(
					'label'  => esc_html_x( 'Bronze', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f4f5f9',
						'tagline_text_color'       => '#f4f5f9',
						'hero_text_color'          => '#f4f5f9',
						'menu_text_color'          => '#f4f5f9',
						'heading_text_color'       => '#353535',
						'main_text_color'          => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#b1a18b',
						'button_color'      => '#b1a18b',
						'button_text_color' => '#f4f5f9',
						// Backgrounds
						'background_color'               => '#f4f5f9',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#796B5A',
						'menu_background_color'          => '#b1a18b',
						'footer_widget_background_color' => '#796B5A',
						'footer_background_color'        => '#f4f5f9',
					),
				),
				'dark' => array(
					'label'  => esc_html_x( 'Dark', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#e5e5e5',
						'tagline_text_color'       => '#999999',
						'hero_text_color'          => '#e5e5e5',
						'menu_text_color'          => '#e5e5e5',
						'heading_text_color'       => '#e5e5e5',
						'main_text_color'          => '#e5e5e5',
						'secondary_text_color'     => '#c1c1c1',
						'footer_widget_text_color' => '#e5e5e5',
						'footer_text_color'        => '#e5e5e5',
						// Links & Buttons
						'link_color'        => '#589ef2',
						'button_color'      => '#589ef2',
						'button_text_color' => '#e5e5e5',
						// Backgrounds
						'background_color'               => '#222222',
						'content_background_color'       => '#444444',
						'hero_background_color'          => '#222222',
						'menu_background_color'          => '#333333',
						'footer_widget_background_color' => '#333333',
						'footer_background_color'        => '#222222',
					),
				),
				'green' => array(
					'label'  => esc_html_x( 'Green', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f4f5f9',
						'tagline_text_color'       => '#f4f5f9',
						'hero_text_color'          => '#f4f5f9',
						'menu_text_color'          => '#f4f5f9',
						'heading_text_color'       => '#353535',
						'main_text_color'          => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#62bf7c',
						'button_color'      => '#62bf7c',
						'button_text_color' => '#f4f5f9',
						// Backgrounds
						'background_color'               => '#f4f5f9',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#3f8850',
						'menu_background_color'          => '#62bf7c',
						'footer_widget_background_color' => '#3f8850',
						'footer_background_color'        => '#f4f5f9',
					),
				),
				'muted' => array(
					'label'  => esc_html_x( 'Muted', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#ffffff',
						'tagline_text_color'       => '#ffffff',
						'hero_text_color'          => '#ffffff',
						'menu_text_color'          => '#ffffff',
						'heading_text_color'       => '#4f5875',
						'main_text_color'          => '#4f5875',
						'secondary_text_color'     => '#888c99',
						'footer_widget_text_color' => '#4f5875',
						'footer_text_color'        => '#4f5875',
						// Links & Buttons
						'link_color'        => '#3e4c75',
						'button_color'      => '#3e4c75',
						'button_text_color' => '#ffffff',
						// Backgrounds
						'background_color'               => '#d5d6e0',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#5a6175',
						'menu_background_color'          => '#5a6175',
						'footer_widget_background_color' => '#5a6175',
						'footer_background_color'        => '#d5d6e0',
					),
				),
				'oranage' => array(
					'label'  => esc_html_x( 'Orange', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f4f5f9',
						'tagline_text_color'       => '#f4f5f9',
						'hero_text_color'          => '#f4f5f9',
						'menu_text_color'          => '#f4f5f9',
						'heading_text_color'       => '#353535',
						'main_text_color'          => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#fc9e4f',
						'button_color'      => '#fc9e4f',
						'button_text_color' => '#f4f5f9',
						// Backgrounds
						'background_color'               => '#f4f5f9',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#da7c37',
						'menu_background_color'          => '#fc9e4f',
						'footer_widget_background_color' => '#da7c37',
						'footer_background_color'        => '#f4f5f9',
					),
				),
				'red' => array(
					'label'  => esc_html_x( 'Red', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f4f5f9',
						'tagline_text_color'       => '#f4f5f9',
						'hero_text_color'          => '#f4f5f9',
						'menu_text_color'          => '#f4f5f9',
						'heading_text_color'       => '#353535',
						'main_text_color'          => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#cc494f',
						'button_color'      => '#cc494f',
						'button_text_color' => '#f4f5f9',
						// Backgrounds
						'background_color'               => '#f4f5f9',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#85252d',
						'menu_background_color'          => '#cc494f',
						'footer_widget_background_color' => '#85252d',
						'footer_background_color'        => '#f4f5f9',
					),
				),
				'yellow' => array(
					'label'  => esc_html_x( 'Yellow', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f4f5f9',
						'tagline_text_color'       => '#f4f5f9',
						'hero_text_color'          => '#f4f5f9',
						'menu_text_color'          => '#f4f5f9',
						'heading_text_color'       => '#353535',
						'main_text_color'          => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#e9c46a',
						'button_color'      => '#e9c46a',
						'button_text_color' => '#f4f5f9',
						// Backgrounds
						'background_color'               => '#f4f5f9',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#c5a24d',
						'menu_background_color'          => '#e9c46a',
						'footer_widget_background_color' => '#c5a24d',
						'footer_background_color'        => '#f4f5f9',
					),
				),
			)
		);

		$this->color_schemes = $default_scheme + $custom_schemes;

		add_action( 'customize_register', array( $this, 'colors' ), 9 );
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

		foreach ( $this->colors as $name => $args ) {

			$this->register_color_setting( $wp_customize, $name, $args );

		}

	}

	/**
	 * Register a custom color setting.
	 *
	 * @since 1.0.0
	 * @see   $this->colors()
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @param string               $name
	 * @param array                $args
	 */
	public function register_color_setting( WP_Customize_Manager $wp_customize, $name, array $args ) {

		if ( empty( $name ) || empty( $args['default'] ) ) {

			return;

		}

		$name = sanitize_key( $name );

		$wp_customize->add_setting(
			$name,
			array(
				'default'              => sanitize_hex_color_no_hash( $args['default'] ),
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$name,
				array(
					'label'       => ! empty( $args['label'] ) ? $args['label'] : $name,
					'description' => ! empty( $args['description'] ) ? $args['description'] : null,
					'section'     => ! empty( $args['section'] ) ? $args['section'] : 'colors',
					'priority'    => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
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

		foreach ( $this->colors as $name => $args ) {

			$this->add_color_inline_css( $name, $args );

		}

	}

	/**
	 * Add color inline CSS.
	 *
	 * @see   $this->enqueue_colors_inline_css()
	 * @since 1.0.0
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function add_color_inline_css( $name, array $args ) {

		if ( empty( $name ) || empty( $args['css'] ) ) {

			return;

		}

		$default = $this->get_default_color( $name, 'default' );
		$hex     = trim( get_theme_mod( $name, $default ), '#' );
		$css     = sprintf( Primer_Customizer::parse_css_rules( $args['css'] ), '#' . $hex );

		if ( ! empty( $args['rgba_css'] ) ) {

			$css .= sprintf( Primer_Customizer::parse_css_rules( $args['rgba_css'] ), implode( ', ', primer_hex2rgb( $hex ) ) );

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
		$hex    = isset( $scheme['colors'][ $color ] ) ? trim( $scheme['colors'][ $color ], '#' ) : null;

		return ( $hash ) ? sanitize_hex_color( '#' . $hex ) : sanitize_hex_color_no_hash( $hex );

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

		wp_localize_script( 'primer-color-scheme-control', 'colorSchemes', $this->color_schemes );

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

			foreach ( $this->colors as $name => $args ) {

				if ( empty( $name ) || empty( $args['css'] ) || ! is_array( $args['css'] ) ) {

					continue;

				}

				printf(
					Primer_Customizer::parse_css_rules( $args['css'] ),
					sprintf( '{{ data.%s }}', $name )
				);

			}

			?>
		</script>
		<?php

		$rgba_colors = $this->get_rgba_css();

		if ( ! $rgba_colors ) {

			// Required for themes without rgba css rules
			echo '<script type="text/html" id="tmpl-primer-color-scheme-css-rgba"></script>';

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

		foreach ( $this->colors as $name => $args ) {

			if ( ! empty( $name ) && ! empty( $args['rgba_css'] ) && is_array( $args['rgba_css'] ) ) {

				$colors[ $name ] = $args['rgba_css'];

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
				'default-text-color' => $this->get_default_color( 'header_textcolor', 'default' ),
				'width'              => 2400,
				'height'             => 1300,
				'flex-height'        => true,
				'wp-head-callback'   => array( $this, 'header_css' ),
			)
		);

		add_theme_support( 'custom-header', $args );

		/**
		 * Filter the default header images.
		 *
		 * @var array
		 */
		$defaults = (array) apply_filters( 'primer_default_header_images',
			array(
				'default' => array(
					'url'           => 'assets/images/hero.jpg',
					'thumbnail_url' => 'assets/images/hero-thumbnail.jpg',
					'description'   => esc_html__( 'City', 'primer' ),
				),
			)
		);

		foreach ( $defaults as $name => &$args ) {

			$path = trailingslashit( get_stylesheet_directory() );
			$url  = trailingslashit( get_stylesheet_directory_uri() );

			if ( ! file_exists( $path . $args['url'] ) ) {

				unset( $defaults[ $name ] );

				continue;

			}

			$args['url']           = $url . $args['url'];
			$args['thumbnail_url'] = file_exists( $path . $args['thumbnail_url'] ) ? $url . $args['thumbnail_url'] : $args['url'];

		}

		if ( $defaults ) {

			register_default_headers( $defaults );

		}

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
