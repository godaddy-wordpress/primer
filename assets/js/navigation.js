/* global jQuery */

( function( $ ) {

	var $navMenu    = false,
	    $menuToggle = false,
	    $submenu    = false;

	function toggle() {

		$menuToggle.add( $navMenu ).toggleClass( 'open' );

		resetSubmenuToggles();

	}

	function resetSubmenuToggles() {

		$navMenu.find( '.menu-item-has-children' ).removeClass( 'open' );

	}

	function expand( e ) {

		e.preventDefault();

		var $menuItem = $( this ).parent( '.menu-item-has-children' );

		if ( ! $menuItem ) {

			return;

		}

		$menuItem.toggleClass( 'open' );

	}

	function position() {

		var $this = $( this );

		$submenu = $this.children( '.sub-menu' ).first();

		if ( isOffScreen( $submenu ) || $submenu.parents( '.bump' ).length ) {

			$submenu.siblings( 'a' ).andSelf().addClass( 'bump' );

			$submenu.css( {
				'left'  : 'auto',
				'right' : ( $this.parents( 'ul' ).length > 1 ) ? $submenu.width() : 0
			} );

		}

		$this.on( 'mouseleave', function() {

			$submenu.removeAttr( 'style' );

		} );

	}

	function isOffScreen( $submenu ) {

		var submenuPosition = $submenu.offset().left,
		    submenuWidth    = $submenu.width();

		return ( submenuPosition + submenuWidth ) > $( window ).width();

	}

	$( document ).ready( function() {

		$navMenu    = $( '#site-navigation' );
		$menuToggle = $( '#menu-toggle' );

		if ( ! $navMenu || ! $menuToggle ) {

			return;

		}

		$menuToggle.on( 'click', toggle );

		$navMenu.find( '.menu-item-has-children' ).on( 'hover', position );

		$navMenu.find( '.expand' ).on( 'click', expand );

		$( document ).on( 'wp-custom-header-video-loaded', function() {

			$( '.site-header' ).addClass( 'video-header' );

		} );

	} );

} )( jQuery );
