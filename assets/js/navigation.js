/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
jQuery(document).ready(function($) {

	var $nav_menu    = $( '#site-navigation' ),
	    $menu_toggle = $( '#menu-toggle' );

	if ( ! $nav_menu || ! $menu_toggle ) {

		return;

	}

	$menu_toggle.click(function(e) {

		$nav_menu.toggleClass('open');
		$nav_menu.css( 'display', ( ( ! $nav_menu.offsetHeight ) ? 'block' : 'none' ) );

	});

	$nav_menu.find('.menu-item-has-children').hover(function(e) {

		var $submenu           = $(this).contents('.sub-menu').eq(0),
			submenu_orig_pos   = $submenu.css( 'left' ),
			submenu_position   = $submenu.offset(),
			submenu_width      = $submenu.width(),
			window_width       = $(window).width(),
			$parent_menu_items = $(this).parents('ul').length,
			$how_far_back      = 0;

		if( ( submenu_position.left + submenu_width ) > window_width || $submenu.parents('.bump').length ){

			if( $parent_menu_items > 1 )
				$how_far_back = 1 * submenu_width;

			$submenu.addClass('bump').css({
				'left'  : 'auto',
				'right' : $how_far_back,
			});

	    } else {
	    	$submenu.removeClass('bump').removeAttr('style');
	    }
	});

});

jQuery(window).resize(function($) {

	var width = $(window).width();

	if ( width === $(window).width() ) {

		return;

	}

	var $nav_menu    = $( 'site-navigation' ),
	    $menu_toggle = $( 'menu-toggle' );

	if ( $nav_menu && $menu_toggle ) {

		$nav_menu.css ('display', 'none' );
		$menu_toggle.toggleClass( 'menu-toggle' );

		return;

	}

	if ( 'none' === $nav_menu.css( 'display' ) ) {

		$nav_menu.css( 'display', 'block' );

	}

});
