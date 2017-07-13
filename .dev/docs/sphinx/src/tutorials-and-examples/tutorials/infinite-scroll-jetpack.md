## Infinite Scroll - Jetpack

In this tutorial we're going to setup the blog page to use infinite scroll through the [Jetpack](https://wordpress.org/plugins/jetpack/) module.

This tutorial assumes that you have the Primer theme (or one of it's [child themes](https://godaddy.github.io/wp-primer-theme/child-themes.html)) installed and you have installed and setup the [Jetpack](https://wordpress.org/plugins/jetpack/) plugin.

### Tutorial


#### Step 1) MU Plugin

First thing we'll need to do is setup an MU plugin where we can add our custom code to. We also have documentation on setting up an MU plugin, so if you are unfamiliar with the process please [visit the documentation](https://godaddy.github.io/wp-primer-theme/tutorials-and-examples/tutorials/mu-plugin.html#how-to-create-a-must-use-plugin) and follow along. Once your MU plugin is setup, you can continue below.

#### Step 2) Local Development Environments

If you are developing on a localhost installation, some of the  [Jetpack](https://wordpress.org/plugins/jetpack/) modules will be disabled. One of the modules disabled is 'Infinite Scroll'. To enable the modules on a localhost install, [Jetpack](https://wordpress.org/plugins/jetpack/) requires us to enable *development mode*.

If you are working on a localhost install you'll first want to add the following code to the MU plugin you have setup.

```php
/**
 * Jetpack development mode.
 *
 * Note: Required for infinite scroll to work on localhost.
 */
add_filter( 'jetpack_development_mode', '__return_true' );
```

#### Step 3) Enable Primer Theme Support

The next thing that we have to do is add theme support for 'infinite-scroll'. If you are interested in learning more about some of the parameters that infinite scroll supports, feel free to visit the [Jetpack Documentation](https://jetpack.com/support/infinite-scroll/).

Add the following to your MU plugin to enable infinite scroll theme support in Primer.

```php
/**
 * Add theme support for infinite scroll.
 *
 * @uses add_theme_support
 * @return void
 */
function primer_infinite_scroll_init() {

	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'wrapper'        => '.post',
		'footer_widgets' => array(
			'footer-1',
			'footer-2',
			'footer-3',
		),
	) );

}
add_action( 'after_setup_theme', 'primer_infinite_scroll_init' );
```

Once you've added the above into your MU plugin, feel free to save the file and check your site. Things should be working at this point, so when you visit your blog posting page as you scroll down you should see additional items loading. You will also notice that the URL of the page will change.

The last thing we'll need to do is clean up the appearance of the theme a bit, so infinite scroll fits better into Primer.

#### Step 4) Style Tweaks

Finally, we are going to clean up the styles a bit. Ideally this woudld be done inside of an external stylesheet, but to for brevity we are demonstrating how to load the styles right into the head of the site.

The following code will remove the pagination links at the bottom of the blog page and, to make things look a little cleaner, we'll center the spinner that displays while additional posts are loading.

Add the following snippet to the bottom of your MU plugin.

```php
/**
 * Hide the blog page pagination links and style the infinite loader.
 *
 * @return void
 */
function hide_blog_pagination() {

	if ( ! is_home() ) {

		return;

	}

	?>

	<style>
	body.blog .navigation.pagination {
		display: none;
	}

	span.infinite-loader {
		width: 34px;
		margin: 1.5em auto;
	}
	</style>

	<?php

}
add_action( 'wp_enqueue_scripts', 'hide_blog_pagination' );
```

And that's it! Feel free to save the MU plugin and check your blog page. Things should now look great and function properly!

For the entire MU plugin code, in full, please see the next section.

#### Full Primer - Jetpack Blog Infinite Scroll Plugin Code

Here is the entire MU plugin code that we have put together in this tutorial. Feel free to copy this right into your own MU plugin file to get things up and running quickly.

```php
<?php
/**
 * Plugin Name: Primer - Jetpack Blog Infinite Scroll
 * Description: Enable Jetpack infinite scroll support within Primer.
 * Author: GoDaddy
 */

/**
 * Add theme support for infinite scroll.
 *
 * @uses add_theme_support
 * @return void
 */
function primer_infinite_scroll_init() {

	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'wrapper'        => '.post',
		'posts_per_page' => 2,
		'footer_widgets' => array(
			'footer-1',
			'footer-2',
			'footer-3',
		),
	) );

}
add_action( 'after_setup_theme', 'primer_infinite_scroll_init' );

/**
 * Hide the blog page pagination links and style the infinite loader.
 *
 * @return void
 */
function hide_blog_pagination() {

	if ( ! is_home() ) {

		return;

	}

	?>

	<style>
	body.blog .navigation.pagination {
		display: none;
	}

	span.infinite-loader {
		width: 34px;
		margin: 1.5em auto;
	}
	</style>

	<?php

}
add_action( 'wp_enqueue_scripts', 'hide_blog_pagination' );
```

#### Download Full MU Plugin

If you are uncomfortable editing code, or just want to get things up and running quickly, feel free to download the MU Plugin using the link below.

<a href="https://raw.githubusercontent.com/godaddy/wp-primer-theme/tree/develop/.dev/docs/sphinx/tutorial-assets/downloads/primer-jetpack-infinite-scroll-mu-plugin.zip" download>Download Primer Infinite Scroll - Jetpack Plugin</a>
