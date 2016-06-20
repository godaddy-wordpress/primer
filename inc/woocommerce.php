<?php

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
 * Filter the theme layout for the WooCommerce shop page.
 *
 * @param  string $theme_layout
 *
 * @return string
 */
function primer_woo_shop_theme_layout( $theme_layout ) {

	if ( ! function_exists( 'is_shop' ) || ! is_shop() ) {

		return $theme_layout;

	}

	return get_post_layout( wc_get_page_id( 'shop' ) );

}
add_filter( 'theme_mod_theme_layout', 'primer_woo_shop_theme_layout' );
