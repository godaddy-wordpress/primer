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

		reset_submenu_toggles();

	}

	function reset_submenu_toggles() {

		$nav_menu.find( '.menu-item-has-children' ).removeClass( 'open' );

	}

	function expand( e ) {

		e.preventDefault();

		var $menu_item = $( this ).parent( '.menu-item-has-children' );

		if ( ! $menu_item ) {

			return;

		}

		$menu_item.toggleClass( 'open' );

	}

	function position() {

		var $this    = $( this ),
		    $submenu = $this.children( '.sub-menu' ).first();


		if ( isOffScreen( $submenu ) || $submenu.parents( '.bump' ).length ) {

			$submenu.siblings( 'a' ).andSelf().addClass( 'bump' );

			$submenu.css({
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

		$nav_menu.find( '.expand' ).on( 'click', expand );

	});

})( jQuery );
