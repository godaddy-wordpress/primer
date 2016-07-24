/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */

window.onload = function() {
	var nav_menu = document.getElementById( 'site-navigation' );
	var menu_toggle = document.getElementById( 'menu-toggle' );

	if ( ! nav_menu || ! menu_toggle )
		return;

	menu_toggle.onclick = function() {
		var nav_menu = document.getElementById( 'site-navigation' );
		nav_menu.style.display = ( ! nav_menu.style.display || nav_menu.style.display == 'none' ) ? 'block' : 'none';
	};
};
