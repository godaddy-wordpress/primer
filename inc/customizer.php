<?php
/**
 * Customizer support.
 *
 * @package Primer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function primer_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

}
add_action( 'customize_register', 'primer_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function primer_customize_preview_js() {

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'primer_customizer', get_template_directory_uri() . "/assets/js/customizer{$suffix}.js", array( 'customize-preview' ), PRIMER_VERSION, true );

}
add_action( 'customize_preview_init', 'primer_customize_preview_js' );
