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

	global $primer_customizer_layouts;

	add_action( 'admin_body_class', 'primer_block_editor_body_classes' );

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( Primer_Customizer::$stylesheet . '-editor-frame', get_template_directory_uri() . "/assets/css/admin/editor-frame{$suffix}.css", array(), PRIMER_VERSION, 'all' );
	wp_enqueue_script( Primer_Customizer::$stylesheet . '-editor-frame', get_template_directory_uri() . "/assets/js/admin/editor-frame{$suffix}.js", array( 'jquery' ), PRIMER_VERSION, true );

	wp_localize_script(
		Primer_Customizer::$stylesheet . '-editor-frame',
		'primerEditorFrame',
		[
			'layouts' => array_keys( $primer_customizer_layouts->__get( 'layouts' ) ),
		]
	);

}
add_action( 'enqueue_block_editor_assets', 'primer_editor_frame_styles' );

/**
 * Append the page template onto the block editor body class
 *
 * @param  string $classes Admin body classes.
 *
 * @return string          Altered admin body classes.
 */
function primer_block_editor_body_classes( $classes ) {

	global $post;

	return $classes . ' ' . primer_get_layout( $post->ID );

}
