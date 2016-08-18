/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */

( function( $ ) {

	$( document ).ready( function() {

		var $nav_menu    = $( '#site-navigation' ),
		    $menu_toggle = $( '#menu-toggle' );

		if ( ! $nav_menu || ! $menu_toggle ) {

			return;

		}

		$menu_toggle.click( function() {

			$menu_toggle.add( $nav_menu ).toggleClass( 'open' );

		});

		$nav_menu.find( '.menu-item-has-children' ).on( 'hover', menuPosition );

		function menuPosition() {

			var $this              = $( this ),
			    $submenu           = $this.children( '.sub-menu' ).first(),
			    submenu_position   = $submenu.offset().left,
			    submenu_width      = $submenu.width();


			if ( ( submenu_position + submenu_width ) > $( window ).width() || $submenu.parents( '.bump' ).length ) {

				$submenu.addClass( 'bump' ).css({
					'left'  : 'auto',
					'right' : ( $this.parents( 'ul' ).length > 1 ) ? submenu_width : 0
				});

			}

			$this.off( 'hover', menuPosition );

		}

	});

})( jQuery );
