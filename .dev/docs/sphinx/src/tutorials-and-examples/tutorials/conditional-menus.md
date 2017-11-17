## Conditionally Displaying Menus

On some sites you may want to display a different navigation when a user is logged in vs not logged in. For logged in users this can be a navigation with an 'Account' link, and for non-logged in users this can be a navigation with a 'Login' link.

### Creating the Menus

You'll first want to create the menus that you want to display to each user. You can name them accordingly so you know which menu is displayed to which users. (eg: Logged In Menu, Logged Out Menu etc.).

As you create each menu, keep note of the menu ID in the URL. You will see something along the lines of `menu=4` where `4` is the menu ID for the current menu you are editing.

The logged out menu ID is not as important as this is the default menu and not something we'll have to reference. However, the other IDs are important in the next steps, so keep them handy or remember how to reference them.

### Create the MU Plugin

Next you'll want to go through the steps found in our [How to create a must-use plugin](/mu-plugin.html) tutorial.

Once you have your must use plugin setup, you can continue to the code snippet below.

### The Code

The code snippet found below will alter the menu for logged in users. Non-logged in users will still see the default menu you have setup in your header.

The ID inside of the code snippet below should match the ID of the menu you want to display to logged in users. This is the ID that we took note of in the first step. If you need help retrieving the menu IDs, re-read through the steps above.

You'll want to swap out the menu ID (that you took note of before) in the code snippet below. Swap out `4` with the ID of your Logged In Menu.

```php
/**
 * Display a custom menu for logged in users.
 *
 * @return mixed Markup for the nav menu.
 */
function primer_logged_in_nav_menu() {

	if ( ! is_user_logged_in() ) {

		return;

	}

	remove_action( 'primer_site_navigation', 'primer_add_primary_menu' );

	add_action( 'primer_site_navigation', function() {
		wp_nav_menu(
			array(
				'menu'   => 4,
				'walker' => new Primer_Walker_Nav_Menu,
			)
		);
	} );

}
add_action( 'template_redirect', 'primer_logged_in_nav' );
```

Save the code in the MU plugin and take a look at your site when logged in vs not. You should see your two different menus displaying based on the logged in state.

### Additional Notes

It's important to note that the code snippet above is not limited to displaying menus for logged in users. You can alter the code snippet above to display different menus for different user roles or capabilities.

If you wanted to display different menus for administrators and editors you can do so in the following manner:

```php
/**
 * Display a custom menu for logged in users.
 *
 * @return mixed Markup for the nav menu.
 */
function primer_logged_in_nav_menu() {

	if ( ! is_user_logged_in() ) {

		return;

	}

	remove_action( 'primer_site_navigation', 'primer_add_primary_menu' );

	// Administrators
	if ( current_user_can( 'manage_options' ) ) {

		add_action( 'primer_site_navigation', function() {
			wp_nav_menu(
				array(
					'menu'   => 4,
					'walker' => new Primer_Walker_Nav_Menu,
				)
			);
		} );

		return;

	}

	// Editors
	if ( current_user_can( 'edit_posts' ) ) {

		add_action( 'primer_site_navigation', function() {
			wp_nav_menu(
				array(
					'menu'   => 5,
					'walker' => new Primer_Walker_Nav_Menu,
				)
			);
		} );

		return;

	}

	// All other users
	add_action( 'primer_site_navigation', function() {
		wp_nav_menu(
			array(
				'menu'   => 7,
				'walker' => new Primer_Walker_Nav_Menu,
			)
		);
	} );

}
add_action( 'template_redirect', 'primer_logged_in_nav' );
```
