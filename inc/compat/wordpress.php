<?php
/**
 * WordPress backwards compatibility.
 *
 * Prevents Primer from running on older WordPress versions since
 * this theme is not meant to be backward compatible beyond two
 * major versions and relies on many newer functions and markup.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Switch to the default theme immediately.
 *
 * @since 1.0.0
 */
function primer_switch_theme() {

	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'primer_upgrade_notice' );

}
add_action( 'after_setup_theme', 'primer_switch_theme', 1 );

/**
 * Return the required WordPress version upgrade message.
 *
 * @since 1.0.0
 *
 * @return string
 */
function primer_get_wp_upgrade_message() {

	/**
	 * Filter the required WordPress version upgrade message.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return (string) apply_filters( 'primer_required_wp_version_message',
		sprintf(
			__( 'Primer requires at least WordPress version %1$s. You are running version %2$s. Please upgrade and try again.', 'primer' ),
			PRIMER_MIN_WP_VERSION,
			get_bloginfo( 'version' )
		)
	);

}

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to
 * activate Primer on older WordPress versions.
 *
 * @since 1.0.0
 */
function primer_upgrade_notice() {

	printf( '<div class="error"><p>%s</p></div>', primer_get_wp_upgrade_message() );

}

/**
 * Prevents the Customizer from being loaded on older WordPress versions.
 *
 * @action load-customize.php
 * @since  1.0.0
 */
function primer_customize() {

	wp_die( primer_get_wp_upgrade_message(), '', array( 'back_link' => true ) );

}
add_action( 'load-customize.php', 'primer_customize' );

/**
 * Prevents the Theme Preview from being loaded on older WordPress versions.
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
