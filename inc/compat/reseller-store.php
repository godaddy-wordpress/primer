<?php
/**
 * Reseller Store compatibility.
 *
 * Provide compatibility fixes for the reseller store plugin
 *
 * @package    Compatibility
 * @subpackage Reseller_Store
 * @category   Core
 * @author     GoDaddy
 * @since      NEXT
 */

// Tell the plugin to not add the price or cart form to the post.
remove_filter( 'the_content', 'rstore_append_add_to_cart_form' );
remove_filter( 'the_excerpt', 'rstore_append_add_to_cart_form' );


/**
 * Returns true when viewing a single reseller store product.
 *
 * @since  NEXT
 *
 * @return bool
 */
function rstore_single_product() {
	return is_singular( array( 'reseller_product' ) );
}


/**
 * Load a custom template for reseller store product pages.
 *
 * @filter template_include
 * @since  NEXT
 *
 * @param  string $template The path of the template to include.
 *
 * @return string
 */
function rstore_template_single_product( $template ) {

	return ( rstore_single_product() && locate_template( 'templates/reseller-store/single-product.php' ) ) ? get_template_part( 'templates/reseller-store/single-product' ) : $template;

}
add_filter( 'template_include', 'rstore_template_single_product' );


/**
 * Set product image  to thumbnail for Reseller Store Products.
 *
 * @filter primer_featured_image_size
 * @since NEXT
 *
 * @param string $size default value for image size.
 *
 * @return string thumbnail if a Reseller_Store product, else $size
 */
function rstore_featured_image_size( $size ) {

	global $post;

	return apply_filters( 'rstore_is_product', $post ) ? 'thumbnail' : $size;
}
add_filter( 'primer_featured_image_size', 'rstore_featured_image_size' );

/**
 * Prevent Reseller_Store product image from loading as the header image
 *
 * @filter primer_use_featured_hero_image
 * @since NEXT
 *
 * @return boolean False if a Reseller_Store product, else true
 *
 * @param bool $enabled default value for primer_use_featured_hero_image.
 */
function rstore_use_featured_hero_image( $enabled ) {

	return rstore_single_product() ? false : $enabled;

}
add_filter( 'primer_use_featured_hero_image', 'rstore_use_featured_hero_image', 100 );

/**
 * Filter the Reseller_store product page title.
 *
 * @filter primer_the_page_title
 * @uses   [get_the_title](https://developer.wordpress.org/reference/functions/get_the_title/) To retreive the shop page title.
 *
 * @since  NEXT
 *
 * @param  string $title  The page title.
 *
 * @return string Returns the page title.
 */
function rstore_product_page_title( $title ) {

	return rstore_single_product() ? '' : $title;

}
add_filter( 'primer_the_page_title', 'rstore_product_page_title' );
