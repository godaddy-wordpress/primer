<?php
/**
 * Customizer bootstrap.
 *
 * @package Primer
 * @since   1.0.0
 */

class Primer_Customizer {

	/**
	 * Stylesheet slug.
	 *
	 * @var string
	 */
	public static $stylesheet;

	/**
	 * Class constructor.
	 */
	public function __construct() {

		self::$stylesheet = get_stylesheet();

		/**
		 * Load Customizer Colors functionality.
		 *
		 * @since 1.0.0
		 */
		require_once get_template_directory() . '/inc/customizer/colors.php';

		/**
		 * Load Customizer Fonts functionality.
		 *
		 * @since 1.0.0
		 */
		require_once get_template_directory() . '/inc/customizer/fonts.php';

		/**
		 * Load Customizer Layouts functionality.
		 *
		 * @since 1.0.0
		 */
		require_once get_template_directory() . '/inc/customizer/layouts.php';

		/**
		 * Load additional site identity options
		 *
		 * @since NEXT
		 */
		require_once get_template_directory() . '/inc/customizer/site-identity.php';

		add_action( 'after_setup_theme',      array( $this, 'logo' ) );
		add_action( 'customize_register',     array( $this, 'selective_refresh' ), 11 );
		add_action( 'customize_register',     array( $this, 'use_featured_hero_image' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );

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
	 * Add control to use featured images as the hero image.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function use_featured_hero_image( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'use_featured_hero_image',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'use_featured_hero_image',
			array(
				'label'       => esc_html__( 'Use featured image', 'primer' ),
				'description' => esc_html__( 'Allow the featured image on the current post to override the hero image.', 'primer' ),
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

		wp_enqueue_script( 'primer-customize-preview', get_template_directory_uri() . "/assets/js/admin/customizer{$suffix}.js", array( 'customize-preview' ), PRIMER_VERSION, true );

		wp_localize_script( 'primer-customize-preview', 'colorsSettings', array( 'hero_background_selector' => primer_get_hero_image_selector() ) );

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

	/**
	 * Compact CSS output.
	 *
	 * @link  https://github.com/GaryJones/Simple-PHP-CSS-Minification
	 * @since NEXT
	 *
	 * @param  string $css
	 *
	 * @return string
	 */
	public static function compact_css( $css ) {

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove spaces before and after comment
		$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

		// Remove comment blocks, everything between /* and */, unless
		// preserved with /*! ... */ or /** ... */
		$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before (
		$css = preg_replace( '/(?<!@media|not|only|and) (\()/', '$1', $css );

		// Remove space before , ; { } ) >
		$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Converts all zeros value into short-hand
		$css = preg_replace( '/0 0 0 0/', '0', $css );

		// Shortern 6-character hex color codes to 3-character where possible
		$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

		return trim( $css );

	}

}

new Primer_Customizer;
