<?php
/**
 * Additional header media customizer options.
 *
 * @class    Primer_Header_Media_Options
 * @package  Classes/Customizer
 * @category Class
 * @author   GoDaddy
 * @since    NEXT
 */
class Primer_Header_Media_Options {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		add_action( 'customize_register', array( $this, 'customize_register' ) );

	}

	/**
	 * Register additional header media options.
	 *
	 * @action customize_register
	 * @see    WP_Customize_Manager
	 *
	 * @since  NEXT
	 *
	 * @param  WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'full_width_header_video',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'full_width_header_video',
			array(
				'label'           => esc_html__( 'Full Width Video Header', 'primer' ),
				'section'         => 'header_image',
				'settings'        => 'full_width_header_video',
				'type'            => 'checkbox',
				'priority'        => 11,
				'active_callback' => 'is_front_page',
			)
		);

	}

}

$GLOBALS['primer_header_media_options'] = new Primer_Header_Media_Options;
