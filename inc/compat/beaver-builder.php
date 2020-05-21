<?php
/**
 * Beaver Builder compatibility.
 *
 * @package    Compatibility
 * @subpackage BeaverBuilder
 * @category   Core
 * @author     GoDaddy
 * @since      1.0.0
 */

/**
 * Use full-width layout by default on Page Builder posts.
 *
 * @action add_post_meta
 * @uses   [update_post_meta](https://codex.wordpress.org/Function_Reference/update_post_meta) To update the `primer_layout` meta value.
 * @global $primer_customizer_layouts
 * @since  1.0.0
 *
 * @param  int    $post_id    Post ID to retreive the layout for.
 * @param  string $meta_key   Key of the custom field to be added.
 * @param  mixed  $meta_value Value of the custom field to be added.
 */
function primer_bb_layout( $post_id, $meta_key, $meta_value ) {

	if ( '_fl_builder_draft' !== $meta_key ) {

		return;

	}

	global $primer_customizer_layouts;

	if ( isset( $primer_customizer_layouts->layouts['one-column-wide'] ) ) {

		update_post_meta( $post_id, 'primer_layout', 'one-column-wide' );

	}

}
add_action( 'add_post_meta', 'primer_bb_layout', 10, 3 );

/**
 * Add color scheme targets for Beaver Builder elements.
 *
 * @action primer_colors
 * @uses   primer_array_replace_recursive To recursively replace existing styles.
 * @since  1.0.0
 *
 * @param  array $colors Original Primer_Customizer_Colors color array.
 *
 * @return array Returns the CSS replacements for beaver builder elements.
 */
function primer_bb_colors( $colors ) {

	// @codingStandardsIgnoreStart
	$bb_colors = array(
		'primary_text_color' => array(
			'css' => array(
				'.fl-callout-text,
				.fl-rich-text' => array(
					'color' => '%1$s',
				),
			),
		),
		'button_color' => array(
			'css' => array(
				'a.fl-button,
				a.fl-button:visited,
				.content-area .fl-builder-content a.fl-button,
				.content-area .fl-builder-content a.fl-button:visited' => array(
					'background-color' => '%1$s',
					'border-color'     => '%1$s',
				),
			),
			'rgba_css' => array(
				'a.fl-button:hover,
				a.fl-button:active,
				a.fl-button:focus,
				a.fl-button:visited:hover,
				a.fl-button:visited:active,
				a.fl-button:visited:focus,
				.content-area .fl-builder-content a.fl-button:hover,
				.content-area .fl-builder-content a.fl-button:active,
				.content-area .fl-builder-content a.fl-button:focus,
				.content-area .fl-builder-content a.fl-button:visited:hover,
				.content-area .fl-builder-content a.fl-button:visited:active,
				.content-area .fl-builder-content a.fl-button:visited:focus' => array(
					'background-color' => 'rgba(%1$s, 0.8)',
					'border-color'     => 'rgba(%1$s, 0.8)',
				),
			),
		),
		'button_text_color' => array(
			'css' => array(
				'a.fl-button
				a.fl-button:hover,
				a.fl-button:active,
				a.fl-button:focus,
				a.fl-button:visited,
				a.fl-button:visited:hover,
				a.fl-button:visited:active,
				a.fl-button:visited:focus,
				.content-area .fl-builder-content a.fl-button,
				.content-area .fl-builder-content a.fl-button *,
				.content-area .fl-builder-content a.fl-button:visited,
				.content-area .fl-builder-content a.fl-button:visited *' => array(
					'color' => '%1$s',
				),
			),
		),
	);
	// @codingStandardsIgnoreEnd

	return primer_array_replace_recursive( $colors, $bb_colors );

}
add_filter( 'primer_colors', 'primer_bb_colors' );

/**
 * Display some elements conditionally on the Beaver Builder front page (Primer only).
 *
 * @action template_redirect
 * @since  1.8.0
 */
function primer_bb_elements() {

	if ( is_front_page() && (bool) get_post_meta( get_queried_object_id(), '_fl_builder_enabled', true ) ) {

		remove_action( 'primer_after_header', 'primer_add_page_title', 12 );

	}

}
add_action( 'template_redirect', 'primer_bb_elements' );

/**
 * Filter the site title HTML wrapper on the Beaver Builder front page.
 *
 * @filter primer_the_site_title_args
 * @since  1.8.0
 *
 * @param  array $args The site title args.
 *
 * @return array
 */
function primer_bb_the_site_title_wrapper( $args ) {

	if ( is_front_page() && (bool) get_post_meta( get_queried_object_id(), '_fl_builder_enabled', true ) ) {

		$args['wrapper'] = 'h1';

	}

	return $args;

}
add_filter( 'primer_the_site_title_args', 'primer_bb_the_site_title_wrapper' );
