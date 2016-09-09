<?php

/**
 * Enable support for WooCommerce.
 *
 * @action after_setup_theme
 * @link   https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 * @since  1.0.0
 */
function primer_woocommerce_setup() {

	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'primer_woocommerce_setup' );

/**
 * Remove the default WooCommerce page wrapper.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Markup for page wrapper start.
 *
 * @action woocommerce_before_main_content
 * @since  1.0.0
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
 * @since  1.0.0
 */
function primer_woo_wrapper_end() {

	?>
	</article></main></div>
	<?php

}
add_action( 'woocommerce_after_main_content', 'primer_woo_wrapper_end', 10 );

/**
 * Display WooCommerce messages above post and page content.
 *
 * @action primer_before_post_content
 * @action primer_before_page_content
 * @since  1.0.0
 */
function primer_woo_shop_messages() {

	if ( function_exists( 'is_checkout' ) && ! is_checkout() ) {

		echo wp_kses_post( do_shortcode( '[woocommerce_messages]' ) );

	}

}
add_action( 'primer_before_post_content', 'primer_woo_shop_messages' );
add_action( 'primer_before_page_content', 'primer_woo_shop_messages' );

/**
 * Safely check if the current page is the WooCommerce shop.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function primer_is_woo_shop() {

	return ( function_exists( 'is_shop' ) && is_shop() );

}

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
function primer_woo_shop_layout( $layout ) {

	if ( primer_is_woo_shop() && function_exists( 'wc_get_page_id' ) ) {

		remove_filter( 'theme_mod_layout', __FUNCTION__ ); // Prevent infinite loop

		$layout = primer_get_layout( wc_get_page_id( 'shop' ) );

	}

	return $layout;

}
add_filter( 'theme_mod_layout', 'primer_woo_shop_layout' );

/**
 * Filter the layout for the WooCommerce shop page.
 *
 * @filter primer_layout_has_sidebar
 * @since  1.0.0
 *
 * @param  bool $has_sidebar
 *
 * @return bool
 */
function primer_woo_shop_layout_has_sidebar( $has_sidebar ) {

	if ( primer_is_woo_shop() && function_exists( 'wc_get_page_id' ) ) {

		remove_filter( 'primer_layout_has_sidebar', __FUNCTION__ ); // Prevent infinite loop

		$has_sidebar = primer_layout_has_sidebar( primer_get_layout( wc_get_page_id( 'shop' ) ) );

	}

	return $has_sidebar;

}
add_filter( 'primer_layout_has_sidebar', 'primer_woo_shop_layout_has_sidebar' );

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
function primer_woo_shop_title( $title ) {

	if ( primer_is_woo_shop() && function_exists( 'wc_get_page_id' ) ) {

		$title = get_the_title( wc_get_page_id( 'shop' ) );

		add_filter( 'woocommerce_page_title', '__return_null' );

	}

	return $title;

}
add_filter( 'primer_the_page_title', 'primer_woo_shop_title' );
