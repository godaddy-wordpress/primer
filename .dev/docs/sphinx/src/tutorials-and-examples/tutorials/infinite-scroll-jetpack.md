## Infinite Scroll - Jetpack

In this tutorial we're going to setup the blog page to use infinite scroll through the [Jetpack](https://wordpress.org/plugins/jetpack/) module.

This tutorial assumes that you have the Primer theme, or one of it's child themes, installed and you have installed and setup [Jetpack](https://wordpress.org/plugins/jetpack/).

### Let's Begin

```php
<?php
/**
 * Plugin Name: Primer - Jetpack Blog Infinite Scroll
 * Description: Enable Jetpack infinite scroll support within Primer.
 * Author: GoDaddy
 */

/**
 * Jetpack development mode.
 *
 * Note: Required for infinite scroll to work on localhost.
 */
add_filter( 'jetpack_development_mode', '__return_true' );

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
