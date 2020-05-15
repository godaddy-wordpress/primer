<?php
/**
 * Additional static front page customizer options.
 *
 * @class    Primer_Static_Front_Page_Options
 * @package  Classes/Customizer
 * @category Class
 * @author   GoDaddy
 * @since    1.5.0
 */
class Primer_Static_Front_Page_Options {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		add_action( 'customize_register', array( $this, 'customize_register' ) );

	}

	/**
	 * Register additional static front page options.
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
			'front_page_title',
			array(
				'default'              => '',
				'sanitize_callback'    => 'sanitize_text_field',
				'sanitize_js_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			'front_page_title',
			array(
				'label'           => esc_html__( 'Front page title', 'primer' ),
				'section'         => 'static_front_page',
				'settings'        => 'front_page_title',
				'type'            => 'text',
				'active_callback' => array( $this, 'latest_posts_on_front_page' ),
			)
		);

	}

	/**
	 * Check whether the front page is set to display the latest posts.
	 *
	 * @since 1.5.0
	 *
	 * @return bool
	 */
	public function latest_posts_on_front_page() {

		return ( 'posts' === get_option( 'show_on_front' ) );

	}

}

$GLOBALS['primer_static_front_page_options'] = new Primer_Static_Front_Page_Options();
