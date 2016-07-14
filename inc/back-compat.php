<?php
/**
 * Primer back compat functionality.
 *
 * Prevents Primer from running on WordPress versions prior to 4.1, since
 * this theme is not meant to be backward compatible beyond that and relies
 * on many newer functions and markup changes introduced in 4.1.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Prevent switching to Primer on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since 1.0.0
 */
function primer_switch_theme() {

	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'primer_upgrade_notice' );

}
add_action( 'after_switch_theme', 'primer_switch_theme' );

/**
 * Return the required WordPress version upgrade message.
 *
 * @since 1.0.0
 *
 * @return string
 */
function primer_get_wp_upgrade_message() {

	/**
	 * Filter the required WordPress version.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	$required_wp_version = (string) apply_filters( 'primer_required_wp_version', '4.1' );

	/**
	 * Filter the required WordPress version upgrade message.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return (string) apply_filters( 'primer_required_wp_version_message',
		sprintf(
			__( 'Primer requires at least WordPress version %s. You are running version %s. Please upgrade and try again.', 'primer' ),
			$required_wp_version
			get_bloginfo( 'version' )
		)
	);

}

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Primer on WordPress versions prior to 4.1.
 *
 * @since 1.0.0
 */
function primer_upgrade_notice() {

	printf( '<div class="error"><p>%s</p></div>', primer_get_wp_upgrade_message() );

}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.1.
 *
 * @action load-customize.php
 * @since  1.0.0
 */
function primer_customize() {

	wp_die( primer_get_wp_upgrade_message(), '', array( 'back_link' => true ) );

}
add_action( 'load-customize.php', 'primer_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.1.
 *
 * @action template_redirect
 * @since  1.0.0
 */
function primer_preview() {

	if ( isset( $_GET['preview'] ) ) {

		wp_die( primer_get_wp_upgrade_message() );

	}

}
add_action( 'template_redirect', 'primer_preview' );
