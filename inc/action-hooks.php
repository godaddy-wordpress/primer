<?php
/**
 * Custom actions for this theme.
 *
 * @package Primer
 */

/**
 * Display site title in the header.
 *
 * @action primer_header
 *
 * @since 1.0.0
 */
function primer_add_site_title(){

	get_template_part( 'templates/parts/site-title' );

}
add_action( 'primer_header', 'primer_add_site_title', 5 );

/**
 * Display primary navigation menu after the header.
 *
 * @action primer_after_header
 *
 * @since 1.0.0
 */
function primer_add_primary_navigation(){

	get_template_part( 'templates/parts/primary-navigation' );

}
add_action( 'primer_after_header', 'primer_add_primary_navigation', 20 );

/**
 * Display widget areas in the footer.
 *
 * @action primer_footer
 *
 * @since 1.0.0
 */
function primer_add_footer_widgets(){

	get_template_part( 'templates/parts/footer-widgets' );

}
add_action( 'primer_footer', 'primer_add_footer_widgets', 5 );

/**
 * Display site info after the footer.
 *
 * @action primer_after_footer
 *
 * @since 1.0.0
 */
function primer_add_site_info(){

	get_template_part( 'templates/parts/site-info' );

}
add_action( 'primer_after_footer', 'primer_add_site_info', 20 );
