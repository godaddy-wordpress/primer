<?php
/**
 * Additional site identity customizer options.
 *
 * @package Primer
 * @since   1.4.2
 */

class Primer_Site_Identity_Options {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		add_filter( 'primer_author_credit', array( $this, 'toggle_footer_site_credits' ) );

		add_action( 'customize_register', array( $this, 'customize_register' ) );

	}

	/**
	 * Toggle the visibility of the site credits in the footer.
	 *
	 * @action primer_author_credit
	 * @since 1.4.2
	 *
	 * @return boolean true|false based on site option
	 */
	public function toggle_footer_site_credits() {

		if ( get_theme_mod( 'primer_footer_credits_visibility' ) ) {

			return true;

		}

		return false;

	}

	/**
	 * Register additional site identity options.
	 *
	 * @action customize_register
	 * @since  1.4.2
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'primer_footer_credits_visibility',
			array(
				'default' => 1,
			)
		);

		$wp_customize->add_control(
			'page_width',
			array(
				'label'       => esc_html__( 'Display theme author credits', 'primer' ),
				'section'     => 'title_tagline',
				'settings'    => 'primer_footer_credits_visibility',
				'type'        => 'checkbox',
			)
		);

	}

}

$GLOBALS['primer_site_identity_options'] = new Primer_Site_Identity_Options;
