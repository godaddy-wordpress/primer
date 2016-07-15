<?php

class Primer_Customizer_Font {

	/**
	 * Array of available fonts.
	 *
	 * @var array
	 */
	public $fonts = array();


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

		add_action( 'customize_register', array( $this, 'typography' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fonts_inline_css' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_google_fonts' ), 11 );

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

		if ( ! $this->fonts ) {

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
				'default'           => $this->get_default_font(),
				'sanitize_callback' => array( $this, 'sanitize_primary_font' ),
			)
		);

		$font_choices = array_combine( $this->fonts, $this->fonts );

		$wp_customize->add_control(
			'primary_font',
			array(
				'label'   => __( 'Primary Font', 'primer' ),
				'section' => 'typography',
				'type'    => 'select',
				'choices' => $font_choices,
			)
		);

		if ( $this->secondary_font_enabled() ) {

			$wp_customize->add_setting(
				'secondary_font',
				array(
					'default'           => $this->get_default_font( 'secondary_font' ),
					'sanitize_callback' => array( $this, 'sanitize_secondary_font' ),
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
	 * Return the default font for a given font type.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $font_type (optional)
	 *
	 * @return string
	 */
	public function get_default_font( $font_type = 'primary_font' ) {

		$first  = ! empty( $this->fonts[0] ) ? $this->fonts[0] : null;
		$second = ! empty( $this->fonts[1] ) ? $this->fonts[1] : $first;

		return ( 'secondary_font' === $font_type ) ? $second : $first;

	}

	/**
	 * Return the primary font.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_primary_font() {

		return $this->sanitize_primary_font( get_theme_mod( 'primary_font', $this->get_default_font() ) );

	}

	/**
	 * Return the secondary font.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_secondary_font() {

		return $this->sanitize_secondary_font( get_theme_mod( 'secondary_font', $this->get_default_font( 'secondary_font' ) ) );

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
	public function sanitize_primary_font( $font ) {

		return in_array( $font, $this->fonts ) ? $font : $this->get_default_font();

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
	public function sanitize_secondary_font( $font ) {

		return in_array( $font, $this->fonts ) ? $font : $this->get_default_font( 'secondary_font' );

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
	public function secondary_font_enabled() {

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
	 * Enqueue Google fonts.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_google_fonts() {

		$primary_font  = $this->get_primary_font();
		$font_families = $primary_font . ':300,400,700';

		if ( $this->secondary_font_enabled() ) {

			$secondary_font = $this->get_secondary_font();

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

		wp_add_inline_style( 'primer-google-fonts', sprintf( Primer_Customizer::parse_css_rules( $css ), $this->get_primary_font() ) );

		if ( ! $this->secondary_font_enabled() ) {

			return;

		}

		$css = array(
			'p, blockquote, .fl-callout-text' => array(
				'font-family' => '"%s", sans-serif',
			),
		);

		wp_add_inline_style( 'primer-google-fonts', sprintf( Primer_Customizer::parse_css_rules( $css ), $this->get_secondary_font() ) );

	}

}
