<?php
/**
 * WooCommerce compatibility.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Enable support for WooCommerce.
 *
 * @action after_setup_theme
 * @link   https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 * @since  1.0.0
 */
function primer_wc_setup() {

	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'primer_wc_setup' );

/**
 * Remove the default WooCommerce page wrapper.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end' );

/**
 * Markup for page wrapper start.
 *
 * @action woocommerce_before_main_content
 * @since  1.0.0
 */
function primer_wc_wrapper_start() {

	?>
	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<article class="primer-woocommerce hentry">
	<?php

}
add_action( 'woocommerce_before_main_content', 'primer_wc_wrapper_start' );

/**
 * Markup for page wrapper end.
 *
 * @action woocommerce_after_main_content
 * @since  1.0.0
 */
function primer_wc_wrapper_end() {

	?>
	</article></main></div>
	<?php

}
add_action( 'woocommerce_after_main_content', 'primer_wc_wrapper_end' );

/**
 * Add tertiary sidebar to WooCommerce templates.
 *
 * @action woocommerce_sidebar
 * @since  1.0.0
 */
function primer_wc_sidebar() {

	get_sidebar( 'tertiary' );

}
add_action( 'woocommerce_sidebar', 'primer_wc_sidebar' );

/**
 * Display WooCommerce messages above post and page content.
 *
 * @action primer_before_post_content
 * @action primer_before_page_content
 * @since  1.0.0
 */
function primer_wc_shop_messages() {

	if ( function_exists( 'is_checkout' ) && ! is_checkout() ) {

		echo wp_kses_post( do_shortcode( '[woocommerce_messages]' ) );

	}

}
add_action( 'primer_before_post_content', 'primer_wc_shop_messages' );
add_action( 'primer_before_page_content', 'primer_wc_shop_messages' );

/**
 * Filter the layout for the WooCommerce shop page.
 *
 * @filter theme_mod_layout
 * @since  1.0.0
 *
 * @param  string $layout
 *
 * @return string
 */
function primer_wc_shop_layout( $layout ) {

	if ( is_shop() ) {

		remove_filter( 'primer_current_layout', __FUNCTION__ ); // Prevent infinite loop

		$layout = primer_get_layout( wc_get_page_id( 'shop' ) );

	}

	return $layout;

}
add_filter( 'primer_current_layout', 'primer_wc_shop_layout' );

/**
 * Filter the WooCommerce shop page title.
 *
 * @filter primer_the_page_title
 * @since  1.0.0
 *
 * @param  string $title
 *
 * @return string
 */
function primer_wc_shop_title( $title ) {

	if ( is_shop() ) {

		add_filter( 'woocommerce_page_title', '__return_null' );

		$title = get_the_title( wc_get_page_id( 'shop' ) );

	}

	return $title;

}
add_filter( 'primer_the_page_title', 'primer_wc_shop_title' );

/**
 * Filter the number of WooCommerce shop columns
 *
 * @filter loop_shop_columns
 * @filter woocommerce_related_products_columns
 * @filter woocommerce_upsells_products_columns
 * @since 1.0.0
 *
 * @param  int $columns
 *
 * @return int
 */
function primer_wc_shop_columns( $columns ) {

	global $post;

	$page_id = ( is_shop() ) ? wc_get_page_id( 'shop' ) : $post->ID;

	if ( 0 === strpos( primer_get_layout( absint( $page_id ) ), 'three-column-' ) ) {

		add_filter( 'post_class', 'primer_wc_product_classes' );

		$columns = 2;

	}

	return $columns;

}
add_filter( 'loop_shop_columns',                    'primer_wc_shop_columns' );
add_filter( 'woocommerce_related_products_columns', 'primer_wc_shop_columns' );
add_filter( 'woocommerce_upsells_products_columns', 'primer_wc_shop_columns' );

/**
 * Filter the WooCommerce product class.
 *
 * @filter primer_wc_product_classes
 * @global WP_Post $post
 * @global array   $woocommerce_loop
 *
 * @param  array $classes
 *
 * @return array
 *
 * @since 1.0.0
 */
function primer_wc_product_classes( $classes ) {

	global $post, $woocommerce_loop;

	/**
	 * Check if on the WooCommerce shop page, and the post type is 'product'
	 *
	 * @var bool
	 */
	$is_product = ( is_shop() && 'product' === $post->post_type );

	/**
	 * Check if on single product page, in upsell or related product loop
	 * and the post type is 'product'
	 *
	 * @var bool
	 */
	$is_upsell_or_related = (
		is_single()
		&&
		isset( $woocommerce_loop['name'] )
		&&
		'product' === $post->post_type
		&&
		( 'related' === $woocommerce_loop['name'] || 'up-sells' === $woocommerce_loop['name'] )
	);

	if ( $is_product ||  $is_upsell_or_related ) {

		$classes[] = 'primer-2-column-product';

	}

	return $classes;

}

/**
 * Add color scheme targets for WooCommerce elements.
 *
 * @filter primer_colors
 * @since  1.0.0
 *
 * @param  array $colors
 *
 * @return array
 */
function primer_wc_colors( $colors ) {

	$wc_colors = array(
		'button_color' => array(
			'css' => array(
				'.woocommerce button.button.alt,
				.woocommerce a.button,
				.woocommerce a.button.alt,
				.woocommerce #respond input#submit,
				.woocommerce .product span.onsale' => array(
					'background-color' => '%1$s',
					'border-color'     => '%1$s',
				),
			),
			'rgba_css' => array(
				'.woocommerce button.button.alt:hover, .woocommerce button.button.alt:active, .woocommerce button.button.alt:focus,
				.woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce a.button:focus,
				.woocommerce a.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce a.button.alt:focus,
				.woocommerce #respond input#submit:hover' => array(
					'background-color' => 'rgba(%1$s, 0.8)',
					'border-color'     => 'rgba(%1$s, 0.8)',
				),
			),
		),
		'button_text_color' => array(
			'css' => array(
				'.woocommerce button.button.alt, .woocommerce button.button.alt:hover,
				.woocommerce a.button, .woocommerce a.button:visited, .woocommerce a.button:hover, .woocommerce a.button:visited:hover,
				.woocommerce a.button.alt, .woocommerce a.button.alt:visited, .woocommerce a.button.alt:hover, .woocommerce a.button.alt:visited:hover,
				.woocommerce #respond input#submit, .woocommerce #respond input#submit:hover,
				.woocommerce .product span.onsale' => array(
					'color' => '%1$s',
				),
			),
		),
	);

	return primer_array_replace_recursive( $colors, $wc_colors );

}
add_filter( 'primer_colors', 'primer_wc_colors' );
