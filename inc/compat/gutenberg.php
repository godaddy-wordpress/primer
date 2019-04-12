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

	// Load regular editor styles into the new block-based editor.
	// add_theme_support( 'editor-styles' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide alignment.
	add_theme_support( 'align-wide' );

}
add_action( 'after_setup_theme', 'primer_gutenberg_theme_support' );

/**
 * Enqueue styles for Gutenberg editor.
 *
 * @since 1.8.5
 */
function primer_gutenberg_editor_assets() {

	global $post;

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'primer-block-editor-style', get_theme_file_uri( "assets/css/admin/blocks-style{$suffix}.css" ), true, defined( 'PRIMER_CHILD_VERSION' ) ? PRIMER_CHILD_VERSION : PRIMER_VERSION, 'all' );
}
add_action( 'enqueue_block_editor_assets', 'primer_gutenberg_editor_assets' );
