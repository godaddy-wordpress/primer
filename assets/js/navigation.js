/* global jQuery */

( function( $ ) {

	var $navMenu    = false,
	    $menuToggle = false;

	function toggle() {

		$menuToggle.add( $navMenu ).toggleClass( 'open' );

	}

	function expand( e ) {

		e.preventDefault();

		var $menuItem = $( this ).parent( '.menu-item-has-children' );

		if ( ! $menuItem ) {

			return;

		}

		$menuItem.toggleClass( 'open' );

	}

	$( document ).ready( function() {

		$navMenu    = $( '#site-navigation' );
		$menuToggle = $( '#menu-toggle' );

		if ( ! $navMenu || ! $menuToggle ) {

			return;

		}

		$menuToggle.on( 'click', toggle );

		$navMenu.find( '.expand' ).on( 'click', expand );

		$( document ).on( 'wp-custom-header-video-loaded', function() {

			$( '.site-header' ).addClass( 'video-header' );

		} );

	} );

} )( jQuery );
