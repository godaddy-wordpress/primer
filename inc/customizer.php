<?php

class Primer_Customizer {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Autoload all customizer components.
		 *
		 * @since 1.0.0
		 */
		foreach( glob( dirname( __FILE__ ) . '/customizer/*.php' ) as $filename ) {

			if ( is_readable( $filename ) ) {

				require_once $filename;

			}

		}

		add_action( 'after_setup_theme',      array( $this, 'logo' ) );
		add_action( 'customize_register',     array( $this, 'require_controls' ), 1 );
		add_action( 'customize_register',     array( $this, 'selective_refresh' ), 11 );
		add_action( 'customize_register',     array( $this, 'use_featured_header_image' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );

	}

	/**
	 * Include controls class required by our sections.
	 *
	 * This is hooked her since WP_Customize_Control is not present before.
	 */
	public function require_controls() {

		/**
		 * Autoload all customizer controls.
		 *
		 * @since 1.0.0
		 */
		foreach( glob( dirname( __FILE__ ) . '/customizer/controls/*.php' ) as $filename ) {

			if ( is_readable( $filename ) ) {

				require_once $filename;

			}

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
	 * @action customize_register
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

		// Color Scheme
		$wp_customize->get_section( 'colors' )->title = esc_html__( 'Color Scheme', 'primer' );

		// Header
		$wp_customize->get_section( 'header_image' )->title       = esc_html__( 'Header', 'primer' );
		$wp_customize->get_control( 'header_textcolor' )->section = 'title_tagline';
		$wp_customize->get_control( 'header_textcolor' )->label   = esc_html__( 'Site Title Color', 'primer' );

		// Footer
		$wp_customize->add_section(
			'primer_footer',
			array(
				'title'    => esc_html__( 'Footer', 'primer' ),
				'priority' => 30,
			)
		);

		// Background
		$wp_customize->get_section( 'background_image' )->title    = esc_html__( 'Background', 'primer' );
		$wp_customize->get_control( 'background_color' )->section  = 'background_image';
		$wp_customize->get_control( 'background_color' )->priority = 1;

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
	 * Add control to use featured images as the header image.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function use_featured_header_image( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'use_featured_header_image',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'use_featured_header_image',
			array(
				'label'       => esc_html__( 'Use featured image', 'primer' ),
				'description' => esc_html__( "Allow the featured image on the current post to override the header image.", 'primer' ),
				'section'     => 'header_image',
				'priority'    => 5,
				'type'        => 'checkbox',
			)
		);

	}

	/**
	 * Enqueue preview JS.
	 *
	 * @action customize_preview_init
	 * @since 1.0.0
	 */
	public function customize_preview_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-customize-preview', get_template_directory_uri() . "/assets/js/customizer{$suffix}.js", array( 'customize-preview' ), PRIMER_VERSION, true );

	}

	/**
	 * Return an array of CSS rules as plain CSS.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $rules
	 *
	 * @return string
	 */
	public static function parse_css_rules( array $rules ) {

		ob_start();

		foreach ( $rules as $rule => $properties ) {

			printf(
				"%s {\n",
				implode( ",\n", array_map( 'trim', explode( ',', $rule ) ) )
			);

			foreach ( $properties as $property => $value ) {

				printf( "\t%s: %s;\n", $property, $value );

			}

			echo "}\n";

		}

		return ob_get_clean();

	}

}

new Primer_Customizer;
