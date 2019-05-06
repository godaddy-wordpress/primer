<?php
/**
 * Gutenberg compatibility.
 *
 * @package    Compatibility
 * @subpackage Gutenberg
 * @category   Core
 * @author     GoDaddy
 * @since      1.8.5
 */

/**
 * Enable Gutenberg features.
 *
 * @since 1.8.5
 */
function primer_gutenberg_theme_support() {

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide alignment.
	add_theme_support( 'align-wide' );

	// Enqueue editor styles if the block editor exists.
	if ( function_exists( 'register_block_type' ) ) {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		add_theme_support( 'editor-styles' );

		// Load regular editor styles into the new block-based editor.
		add_editor_style( "assets/css/admin/editor-blocks{$suffix}.css" );

	}

}
add_action( 'after_setup_theme', 'primer_gutenberg_theme_support' );

/**
 * Enqueue supplemental block editor styles.
 */
function primer_editor_frame_styles() {

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( Primer_Customizer::$stylesheet . '-editor-frame', get_template_directory_uri() . "/assets/css/admin/editor-frame{$suffix}.css", array(), PRIMER_VERSION, 'all' );

}
add_action( 'enqueue_block_editor_assets', 'primer_editor_frame_styles' );
