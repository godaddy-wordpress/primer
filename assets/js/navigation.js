/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
window.onload = function() {

	var nav_menu    = document.getElementById( 'site-navigation' ),
	    menu_toggle = document.getElementById( 'menu-toggle' );

	if ( ! nav_menu || ! menu_toggle ) {

		return;

	}

	menu_toggle.onclick = function() {

		nav_menu.style.display = ( ! nav_menu.style.display || 'none' === nav_menu.style.display ) ? 'block' : 'none';

	}

}

window.onresize = function() {

	if ( window.innerWidth < 600 ) {

		return;

	}

	var nav_menu = document.getElementById( 'site-navigation' );

	if ( 'none' === nav_menu.style.display ) {

		nav_menu.style.display = 'block';

	}

}
