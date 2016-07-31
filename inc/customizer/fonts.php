<?php

class Primer_Customizer_Fonts {

	/**
	 * Array of available fonts.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $fonts = array();

	/**
	 * Array of available font types.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $font_types = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Filter the array of available fonts.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$this->fonts = (array) apply_filters( 'primer_fonts',
			array(
				'Architects Daughter',
				'Asap',
				'Cabin',
				'Droid',
				'Droid Sans',
				'Josefin Sans',
				'Lato',
				'Merriweather',
				'Merriweather Sans',
				'Montserrat',
				'Open Sans',
				'Oswald',
				'Playfair Display',
				'PT Sans',
				'PT Serif',
				'Raleway',
				'Roboto',
				'Roboto Slab',
				'Source Sans Pro',
				'Source Serif Pro',
				'Ubuntu',
			)
		);

		if ( ! $this->fonts ) {

			return;

		}

		/**
		 * Filter the array of available font types.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$this->font_types = (array) apply_filters( 'primer_font_types',
			array(
				array(
					'name'    => 'primary_font',
					'label'   => esc_html__( 'Primary Font', 'primer' ),
					'default' => 'Open Sans',
					'css'     => array(
						'body, p' => array(
							'font-family' => '"%s", sans-serif',
						),
					),
				),
				array(
					'name'    => 'secondary_font',
					'label'   => esc_html__( 'Secondary Font', 'primer' ),
					'default' => 'Open Sans',
					'css'     => array(
						'blockquote, .entry-meta, .entry-footer, .comment-list li .comment-meta .says, .comment-list li .comment-metadata, .comment-reply-link, #respond .logged-in-as, .fl-callout-text' => array(
							'font-family' => '"%s", sans-serif',
						),
					),
				),
				array(
					'name'    => 'header_font',
					'label'   => esc_html__( 'Header Font', 'primer' ),
					'default' => 'Open Sans',
					'css'     => array(
						'h1, h2, h3, h4, h5, h6, label, legend, table th, .site-title, .entry-title, .widget-title, .main-navigation li a, button, a.button, input[type="button"], input[type="reset"], input[type="submit"]' => array(
							'font-family' => '"%s", sans-serif',
						),
					),
				),
			)
		);

		if ( ! $this->font_types ) {

			return;

		}

		add_action( 'customize_register', array( $this, 'typography' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_google_fonts' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_inline_css' ), 12 );

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

		if ( ! $this->fonts || ! $this->font_types ) {

			return;

		}

		$wp_customize->add_section(
			'typography',
			array(
				'title'    => esc_html__( 'Typography', 'primer' ),
				'priority' => 40,
			)
		);

		foreach ( $this->font_types as $font_type ) {

			if ( empty( $font_type['name'] ) || empty( $font_type['default'] ) || empty( $font_type['label'] ) ) {

				continue;

			}

			$wp_customize->add_setting(
				$font_type['name'],
				array(
					'default'           => $font_type['default'],
					'sanitize_callback' => array( $this, 'sanitize_font' ),
				)
			);

			$fonts = array_unique(
				array_merge(
					array( $this->get_default_font( $font_type['name'] ) ),
					$this->fonts
				)
			);

			$wp_customize->add_control(
				$font_type['name'],
				array(
					'label'   => $font_type['label'],
					'section' => 'typography',
					'type'    => 'select',
					'choices' => array_combine( $fonts, $fonts ),
				)
			);

		}

	}

	/**
	 * Return a font by type.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font_type
	 *
	 * @return string
	 */
	public function get_font( $font_type ) {

		return $this->sanitize_font( get_theme_mod( $font_type, $this->get_default_font( $font_type ) ) );

	}

	/**
	 * Return the default font for a given font type.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font_type
	 *
	 * @return string
	 */
	public function get_default_font( $font_type ) {

		$defaults = wp_list_pluck( $this->font_types, 'default', 'name' );
		$default  = isset( $defaults[ $font_type ] ) ? $defaults[ $font_type ] : $this->fonts[0];

		return $this->sanitize_font( $default );

	}

	/**
	 * Sanitize a font.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font
	 *
	 * @return string
	 */
	public function sanitize_font( $font ) {

		return in_array( $font, $this->fonts ) ? $font : array_shift( $this->fonts );

	}

	/**
	 * Return an array of weights for a font.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font
	 * @param  string $font_type
	 *
	 * @return array
	 */
	public function get_font_weights( $font, $font_type ) {

		/**
		 * Filter the array of weights for a font.
		 *
		 * @since 1.0.0
		 *
		 * @param string $font
		 * @param string $font_type
		 *
		 * @var array
		 */
		$weights = (array) apply_filters( 'primer_font_weights', array( 300, 400, 700 ), $font, $font_type );
		$weights = array_filter( array_map( 'absint', $weights ) );

		sort( $weights );

		return $weights;

	}

	/**
	 * Enqueue Google Fonts.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_google_fonts() {

		$font_families = array();

		foreach ( $this->font_types as $font_type ) {

			if ( empty( $font_type['name'] ) ) {

				continue;

			}

			$font    = $this->get_font( $font_type['name'] );
			$weights = $this->get_font_weights( $font, $font_type['name'] );

			$font_families[ $font ] = isset( $font_families[ $font ] ) ? array_merge( $font_families[ $font ], $weights ) : $weights;

		}

		foreach ( $font_families as $font => &$weights ) {

			$weights = implode( ',', array_unique( $weights ) );
			$weights = sprintf( '%s:%s', $font, $weights );

		}

		$font_families = implode( '|', $font_families );

		/**
		 * Filter the Google Fonts query args.
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
	 * Add inline CSS for the font customizations.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_inline_css() {

		foreach ( $this->font_types as $font_type ) {

			if ( ! empty( $font_type['name'] ) && ! empty( $font_type['css'] ) ) {

				$css = sprintf(
					Primer_Customizer::parse_css_rules( $font_type['css'] ),
					$this->get_font( $font_type['name'] )
				);

				wp_add_inline_style( 'primer-google-fonts', $css );

			}

		}

	}

}

new Primer_Customizer_Fonts;
