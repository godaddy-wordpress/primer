/**
 * WooCommerce compatibility script
 *
 * @since 1.4.2
 */
jQuery( document ).ready( function( $ ) {

	var hide_primer_woo_menu,
	    cart_container = $( '.site-header-cart.menu' );

	$( '.menu-item-object-cart a' ).hover(

		function() {

			$( '.site-header-cart.menu' ).stop().show();

		}, function() {

			hide_primer_woo_menu = primer_hide_woo_cart_menu();

			$( 'body' ).on( 'mouseenter', '.site-header-cart.menu', function() {

				clearTimeout( hide_primer_woo_menu );

			} );

			$( 'body' ).on( 'mouseleave', '.site-header-cart.menu', function() {

				primer_hide_woo_cart_menu();

			} );

		}

	);

} );

/**
 * Hide the primer woocommerce cart menu
 */
function primer_hide_woo_cart_menu() {

	return setTimeout( function() {

		jQuery( '.site-header-cart.menu' ).stop().hide();

	}, 200);

}
