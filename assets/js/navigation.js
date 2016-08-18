/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */

( function( $ ) {

	var $nav_menu    = false,
	    $menu_toggle = false;

	function toggle() {

		$menu_toggle.add( $nav_menu ).toggleClass( 'open' );

	}

	function position() {

		var $this    = $( this ),
		    $submenu = $this.children( '.sub-menu' ).first();


		if ( isOffScreen( $submenu ) || $submenu.parents( '.bump' ).length ) {

			$submenu.addClass( 'bump' ).css({
				'left'  : 'auto',
				'right' : ( $this.parents( 'ul' ).length > 1 ) ? $submenu.width() : 0
			});

		}

		$this.off( 'hover', position );

	}

	function isOffScreen( $submenu ) {

		var submenu_position   = $submenu.offset().left,
		    submenu_width      = $submenu.width();

		return ( submenu_position + submenu_width ) > $( window ).width();

	}

	$( document ).ready( function() {

		$nav_menu    = $( '#site-navigation' );
		$menu_toggle = $( '#menu-toggle' );

		if ( ! $nav_menu || ! $menu_toggle ) {

			return;

		}

		$menu_toggle.on( 'click', toggle );

		$nav_menu.find( '.menu-item-has-children' ).on( 'hover', position );

	});

})( jQuery );
