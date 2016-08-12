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

		menu_toggle.classList.toggle('open');
		nav_menu.style.display = ( ! nav_menu.offsetHeight ) ? 'block' : 'none';

	};

};

var width = window.innerWidth;

window.onresize = function() {

	if ( width === window.innerWidth ) {

		return;

	}

	var nav_menu    = document.getElementById( 'site-navigation' ),
	    menu_toggle = document.getElementById( 'menu-toggle' );

	if ( typeof nav_menu !== 'undefined' && typeof menu_toggle !== 'undefined' && menu_toggle.offsetHeight ) {

		nav_menu.style.display = 'none';
		menu_toggle.className  = 'menu-toggle';

		return;

	}

	if ( 'none' === nav_menu.style.display ) {

		nav_menu.style.display = 'block';

	}

};
