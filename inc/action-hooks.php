<?php
/**
 * This file contains many of the hook-ups for parts of our theme.
 *
 * @package basis
 */

/**
 * Adds the site title to the header.
 *
 * Grabs the template part for the site title and attaches it.
 * to the header.
 *
 * @uses get_template_part() http://codex.wordpress.org/Function_Reference/get_template_part
 */
function basis_add_site_title(){

	get_template_part( 'templates/parts/site-title' );

}

add_action( 'basis_header', 'basis_add_site_title', 5 );

/**
 * Adds the primary navigation to the header.
 *
 * Grabs the template part for the site title and attaches it.
 * to the header.
 *
 * @uses get_template_part() http://codex.wordpress.org/Function_Reference/get_template_part
 */
function basis_add_primary_navigation(){

	get_template_part( 'templates/parts/primary-navigation' );

}

add_action( 'basis_header_after', 'basis_add_primary_navigation', 20 );

/**
 * Adds the footer widgets to the footer.
 *
 * @uses get_template_part() http://codex.wordpress.org/Function_Reference/get_template_part
 */
function basis_add_footer_widgets(){

	get_template_part( 'templates/parts/footer-widgets' );

}

add_action( 'basis_footer', 'basis_add_footer_widgets', 5 );

/**
 * Adds the footer text to the footer.
 *
 * @uses get_template_part() http://codex.wordpress.org/Function_Reference/get_template_part
 */
function basis_add_site_info(){

	get_template_part( 'templates/parts/site-info' );

}

add_action( 'basis_after_footer', 'basis_add_site_info', 20 );

