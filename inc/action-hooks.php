<?php
/**
 * This file contains many of the hook-ups for parts of our theme.
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

	get_template_part( 'parts/header/site-title' );

}

add_action( 'basis_header', 'basis_add_site_title', 1 );

/**
 * Adds the primary navigation to the header.
 *
 * Grabs the template part for the site title and attaches it.
 * to the header.
 *
 * @uses get_template_part() http://codex.wordpress.org/Function_Reference/get_template_part
 */
function basis_add_primary_navigation(){

	get_template_part( 'parts/header/primary-navigation' );

}

add_action( 'basis_header', 'basis_add_primary_navigation', 20 );