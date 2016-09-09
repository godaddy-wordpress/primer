<?php

/**
 * Enable support for WooCommerce.
 *
 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @action after_setup_theme
 */
function primer_woocommerce_setup() {

	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'primer_woocommerce_setup' );

/**
 * Remove the default WooCommerce page wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Markup for page wrapper start.
 *
 * @action woocommerce_before_main_content
 */
function primer_woo_wrapper_start() {

	?>
	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<article class="primer-woocommerce hentry">
	<?php

}
add_action( 'woocommerce_before_main_content', 'primer_woo_wrapper_start', 10 );

/**
 * Markup for page wrapper end.
 *
 * @action woocommerce_after_main_content
 */
function primer_woo_wrapper_end() {

	?>
	</article></main></div>
	<?php

}
add_action( 'woocommerce_after_main_content', 'primer_woo_wrapper_end', 10 );

/**
 * Filter the layout for the WooCommerce shop page.
 *
 * @param  string $layout
 *
 * @return string
 */
function primer_woo_shop_layout( $layout ) {

	if ( function_exists( 'wc_get_page_id' ) && function_exists( 'is_shop' ) && is_shop() ) {

		remove_filter( 'theme_mod_layout', __FUNCTION__ ); // Prevent infinite loop

		$layout = primer_get_layout( wc_get_page_id( 'shop' ) );

	}

	return $layout;

}
add_filter( 'theme_mod_layout', 'primer_woo_shop_layout' );

/**
 * Filter the number of WooCommerce shop columns
 *
 * @filter primer_woo_shop_columns
 *
 * @param  integer $number_columns
 *
 * @return integer
 *
 * @since 1.0.0
 */
function primer_woo_shop_columns( $number_columns ) {

	// If the layout is not a three-column layout, abort
	if ( strpos( primer_woo_shop_layout( primer_get_layout() ), 'three-column-' ) === false ) {

		return $number_columns;

	}

	// Add the 2 column layout class
	add_filter( 'post_class', 'primer_woo_product_classes' );

	return 2;

}
add_filter( 'loop_shop_columns', 'primer_woo_shop_columns' );
add_filter( 'woocommerce_related_products_columns', 'primer_woo_shop_columns' );
add_filter( 'woocommerce_upsells_products_columns', 'primer_woo_shop_columns' );

/**
 * Filter the WooCommerce product class.
 *
 * @filter primer_woo_product_classes
 *
 * @param  array $classes
 *
 * @return array
 *
 * @since 1.0.0
 */
function primer_woo_product_classes( $classes ) {

	global $post, $woocommerce_loop;

	if ( function_exists( 'is_shop' ) && is_shop() && 'product' === $post->post_type ) {

		$classes[] = 'primer-2-column-product';

	}

	if ( is_single() && ( isset( $woocommerce_loop['name'] ) && ( 'related' === $woocommerce_loop['name'] || 'up-sells' === $woocommerce_loop['name'] ) ) && 'product' === $post->post_type ) {

		$classes[] = 'primer-2-column-product';

	}

	return $classes;

}
