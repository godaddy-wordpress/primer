<?php
/**
 * Custom class that adds some markup before the nav menu.
 *
 * @class      Primer_Walker_Nav_Menu
 * @package    Classes
 * @subpackage Navigation
 * @category   Class
 * @author     GoDaddy
 * @since      1.0.0
 * @extends    Walker_Nav_Menu
 * @see        primer_add_primary_menu()
 */
class Primer_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		_deprecated_function( __METHOD__, '1.8', 'primer_add_primary_nav_sub_menu_buttons' );

		$indent = str_repeat( "\t", $depth );

		$output .= "\n{$indent}<a class=\"expand\" href=\"#\"></a>\n{$indent}<ul class=\"sub-menu\">\n";

	}

}
