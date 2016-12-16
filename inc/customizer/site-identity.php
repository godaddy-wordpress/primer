<?php
/**
 * Additional site identity customizer options.
 *
 * @package Primer
 * @since   NEXT
 */

class Primer_Site_Identity_Options {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Filter the site identity settings display.
		 *
		 * @since NEXT
		 *
		 * @var bool
		 */
		if ( ! (bool) apply_filters( 'primer_show_site_identity_settings', true ) ) {

			return;

		}

		add_filter( 'primer_author_credit', array( $this, 'toggle_primer_author_credit' ) );

		add_action( 'customize_register', array( $this, 'customize_register' ) );

	}

	/**
	 * Toggle the visibility of the site credits in the footer.
	 *
	 * @filter primer_author_credit
	 * @since  NEXT
	 *
	 * @return bool
	 */
	public function toggle_primer_author_credit() {

		$show_author_credit = get_theme_mod( 'show_author_credit' );

		return ! empty( $show_author_credit );

	}

	/**
	 * Register additional site identity options.
	 *
	 * @action customize_register
	 * @since  NEXT
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'show_author_credit',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'page_width',
			array(
				'label'    => esc_html__( 'Display theme author credit', 'primer' ),
				'section'  => 'title_tagline',
				'settings' => 'show_author_credit',
				'type'     => 'checkbox',
				'priority' => 40,
			)
		);

	}

}

$GLOBALS['primer_site_identity_options'] = new Primer_Site_Identity_Options;
