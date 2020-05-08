<?php
/**
 * Additional site identity customizer options.
 *
 * @class    Primer_Site_Identity_Options
 * @package  Classes/Customizer
 * @category Class
 * @author   GoDaddy
 * @since    1.5.0
 */
class Primer_Site_Identity_Options {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Filter the site identity settings display.
		 *
		 * @since 1.5.0
		 *
		 * @var bool
		 */
		if ( ! (bool) apply_filters( 'primer_show_site_identity_settings', true ) ) {

			return;

		}

		add_filter( 'primer_privacy_policy_link', array( $this, 'toggle_primer_privacy_link' ) );

		add_filter( 'primer_author_credit', array( $this, 'toggle_primer_author_credit' ) );

		add_action( 'customize_register', array( $this, 'customize_register' ) );

	}

	/**
	 * Toggle the visibility of the site credits in the footer.
	 *
	 * @filter primer_author_credit
	 * @since  1.5.0
	 *
	 * @return bool Returns true when `show_author_credit` theme mod is set.
	 */
	public function toggle_primer_author_credit() {

		$show_author_credit = get_theme_mod( 'show_author_credit', true );

		return ! empty( $show_author_credit );

	}

	/**
	 * Toggle the visibility of the privacy policy link in the footer.
	 *
	 * @filter primer_privacy_policy_link
	 * @since  1.8.3
	 *
	 * @return bool Returns true when `show_privacy_policy` theme mod is set.
	 */
	public function toggle_primer_privacy_link() {

		$show_privacy_policy = get_theme_mod( 'show_privacy_policy', true );

		return ! empty( $show_privacy_policy );

	}

	/**
	 * Register additional site identity options.
	 *
	 * @action customize_register
	 * @see    WP_Customize_Manager
	 *
	 * @since  1.5.0
	 *
	 * @param  WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'copyright_text',
			array(
				'sanitize_callback'    => 'wp_kses_post',
				'sanitize_js_callback' => 'wp_kses_post',
				'default'              => sprintf(
					/* translators: 1. copyright symbol, 2. year, 3. site title */
					esc_html__( 'Copyright %1$s %2$d %3$s', 'primer' ),
					'&copy;',
					gmdate( 'Y' ),
					get_bloginfo( 'blogname' )
				),
			)
		);

		$wp_customize->add_control(
			'copyright_text',
			array(
				'label'    => esc_html__( 'Footer Copyright Text', 'primer' ),
				'section'  => 'title_tagline',
				'settings' => 'copyright_text',
				'type'     => 'text',
				'priority' => 40,
			)
		);

		$wp_customize->add_setting(
			'show_author_credit',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'show_author_credit',
			array(
				'label'    => esc_html__( 'Display theme author credit', 'primer' ),
				'section'  => 'title_tagline',
				'settings' => 'show_author_credit',
				'type'     => 'checkbox',
				'priority' => 50,
			)
		);

		$wp_customize->add_setting(
			'show_privacy_policy',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'show_privacy_policy',
			array(
				'label'    => esc_html__( 'Display privacy policy link', 'primer' ),
				'section'  => 'title_tagline',
				'settings' => 'show_privacy_policy',
				'type'     => 'checkbox',
				'priority' => 50,
			)
		);

	}

}

$GLOBALS['primer_site_identity_options'] = new Primer_Site_Identity_Options();
