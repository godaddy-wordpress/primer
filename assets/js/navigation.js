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

		nav_menu.style.display = ( 'none' === nav_menu.style.display || ! nav_menu.offsetHeight ) ? 'block' : 'none';

	}

}

window.onresize = function() {

	var nav_menu = document.getElementById( 'site-navigation' );

	if ( this.innerWidth < 600 ) {

		nav_menu.style.display = 'none';

		return;

	}

	if ( 'none' === nav_menu.style.display ) {

		nav_menu.style.display = 'block';

	}

}
