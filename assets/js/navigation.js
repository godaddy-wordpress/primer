/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */

( function( $ ) {

	$( document ).ready( function() {

		var $nav_menu    = $( '#site-navigation' ),
				$menu_toggle = $( '#menu-toggle' ),
				open         = false;

		if ( ! $nav_menu || ! $menu_toggle ) {

			return;

		}

		$menu_toggle.click( function() {

			open = ! open;

			$menu_toggle.toggleClass( 'open' );

			$nav_menu.css( 'display', ( open ) ? 'block' : 'none' );

		});

		$nav_menu.find( '.menu-item-has-children' ).hover( function() {

			var $this              = $( this ),
					$submenu           = $this.children( '.sub-menu' ).eq( 0 ),
					submenu_position   = $submenu.offset(),
					submenu_width      = $submenu.width(),
					window_width       = $( window ).width(),
					$parent_menu_items = $this.parents( 'ul' ).length,
					$how_far_back      = 0;

			if ( ( submenu_position.left + submenu_width ) > window_width || $submenu.parents( '.bump' ).length ) {

				if ( $parent_menu_items > 1 ) {

					$how_far_back = submenu_width;

				}

				$submenu.addClass( 'bump' ).css({
					'left'  : 'auto',
					'right' : $how_far_back
				});

			}

		});

	});

})( jQuery );
