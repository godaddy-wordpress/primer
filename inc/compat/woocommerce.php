<?php
/**
 * WooCommerce compatibility.
 *
 * @package    Compatibility
 * @subpackage WooCommerce
 * @category   Core
 * @author     GoDaddy
 * @since      1.0.0
 */

/**
 * Enable support for WooCommerce.
 *
 * @action after_setup_theme
 * @uses   [add_theme_support](https://developer.wordpress.org/reference/functions/add_theme_support/) To enable WooCommerce support.
 *
 * @link   https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @since  1.0.0
 */
function primer_wc_setup() {

	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'primer_wc_setup' );

/**
 * Add body class to indicate when WooCommerce is localized.
 *
 * @filter body_class
 *
 * @since  1.6.0
 *
 * @param  array $classes Array of body classes.
 *
 * @return array
 */
function primer_wc_l10n_body_class( array $classes ) {

	global $l10n;

	if ( ! empty( $l10n['woocommerce'] ) ) {

		$classes[] = 'primer-woocommerce-l10n';

	}

	return $classes;

}
add_filter( 'body_class', 'primer_wc_l10n_body_class' );

/**
 * Remove the default WooCommerce page wrapper.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

/**
 * Markup for page wrapper start.
 *
 * @action woocommerce_before_main_content
 *
 * @since  1.0.0
 *
 * @return mixed Returns the opening WooCommerce content wrappers.
 */
function primer_wc_wrapper_start() {

	?>
	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<article class="primer-woocommerce hentry">
	<?php

}
add_action( 'woocommerce_before_main_content', 'primer_wc_wrapper_start' );

/**
 * Markup for page wrapper end.
 *
 * @action woocommerce_after_main_content
 *
 * @since  1.0.0
 *
 * @return mixed Returns the closing WooCommerce content wrappers.
 */
function primer_wc_wrapper_end() {

	?>
	</article></main></div>
	<?php

}
add_action( 'woocommerce_after_main_content', 'primer_wc_wrapper_end' );

/**
 * Add tertiary sidebar to WooCommerce templates.
 *
 * @action woocommerce_sidebar
 * @uses   [get_sidebar](https://developer.wordpress.org/reference/functions/get_sidebar/) To display the sidebar.
 *
 * @since  1.0.0
 */
function primer_wc_sidebar() {

	get_sidebar( 'tertiary' );

}
add_action( 'woocommerce_sidebar', 'primer_wc_sidebar' );

/**
 * Display WooCommerce messages above post and page content.
 *
 * @action primer_before_post_content
 * @action primer_before_page_content
 * @uses   [is_checkout](https://docs.woocommerce.com/wc-apidocs/function-is_checkout.html) To confirm user is not on the checkout page.
 *
 * @since  1.0.0
 *
 * @return mixed Returns `[woocommerce_message]` shortcode if not on the checkout page.
 */
function primer_wc_shop_messages() {

	if ( function_exists( 'is_checkout' ) && ! is_checkout() ) {

		echo wp_kses_post( do_shortcode( '[woocommerce_messages]' ) );

	}

}
add_action( 'primer_before_post_content', 'primer_wc_shop_messages' );
add_action( 'primer_before_page_content', 'primer_wc_shop_messages' );

/**
 * Filter the layout for the WooCommerce shop page.
 *
 * @filter primer_current_layout
 * @uses   primer_get_layout To retreive the page layout.
 *
 * @since  1.0.0
 *
 * @param  string $layout The default layout for the page.
 *
 * @return mixed  string  Returns the shop page layout.
 */
function primer_wc_shop_layout( $layout ) {

	if ( is_shop() ) {

		remove_filter( 'primer_current_layout', __FUNCTION__ ); // Prevent infinite loop.

		$layout = primer_get_layout( wc_get_page_id( 'shop' ) );

	}

	return $layout;

}
add_filter( 'primer_current_layout', 'primer_wc_shop_layout' );

/**
 * Filter the WooCommerce shop page title.
 *
 * @filter primer_the_page_title
 * @uses   [get_the_title](https://developer.wordpress.org/reference/functions/get_the_title/) To retreive the shop page title.
 *
 * @since  1.0.0
 *
 * @param  string $title  The page title.
 *
 * @return string Returns the shop page title.
 */
function primer_wc_shop_title( $title ) {

	if ( is_shop() ) {

		add_filter( 'woocommerce_page_title', '__return_null' );

		$title = get_the_title( wc_get_page_id( 'shop' ) );

	}

	if ( is_product() ) {

		$labels = get_post_type_labels( get_post_type_object( 'product' ) );
		$title  = ! empty( $labels->singular_name ) ? $labels->singular_name : $title;

	}

	return $title;

}
add_filter( 'primer_the_page_title', 'primer_wc_shop_title' );

/**
 * Filter the WooCommerce shop page title element.
 *
 * @filter primer_the_page_title_args
 *
 * @since  1.8.0
 *
 * @param  array $args The page title args.
 *
 * @return array
 */
function primer_wc_product_page_title_wrapper( $args ) {

	if ( is_product() ) {

		$args['wrapper'] = 'h2';

	}

	return $args;

}
add_filter( 'primer_the_page_title_args', 'primer_wc_product_page_title_wrapper' );

/**
 * Change the number of shop columns based on the Primer layout.
 *
 * @filter loop_shop_columns
 * @filter woocommerce_related_products_columns
 * @filter woocommerce_upsells_products_columns
 *
 * @global WP_Post $post
 *
 * @uses   [is_shop](https://docs.woocommerce.com/wc-apidocs/function-is_shop.html) To check the if on the WooCommerce shop page.
 * @uses   [wc_get_page_id](https://docs.woocommerce.com/wc-apidocs/function-wc_get_page_id.html) To retreive the WooCommerce page id.
 * @uses   primer_get_layout To check if the current page is three columns.
 *
 * @since  1.0.0
 *
 * @param  int $columns The default number of columns.
 *
 * @return int The number of columns to use.
 */
function primer_wc_shop_columns( $columns ) {

	if ( 0 === strpos( primer_get_layout( absint( wc_get_page_id( 'shop' ) ) ), 'three-column-' ) ) {

		add_filter( 'post_class', 'primer_wc_product_classes' );

		$columns = 2;

	}

	return $columns;

}
add_filter( 'loop_shop_columns', 'primer_wc_shop_columns' );
add_filter( 'woocommerce_related_products_columns', 'primer_wc_shop_columns' );
add_filter( 'woocommerce_upsells_products_columns', 'primer_wc_shop_columns' );

/**
 * Add post class to support 2-column product layouts in Primer.
 *
 * @filter post_class
 *
 * @global WP_Post $post
 * @global array   $woocommerce_loop
 *
 * @since  1.0.0
 *
 * @param  array $classes Array of body classes.
 *
 * @return array Returns the array of body classes.
 */
function primer_wc_product_classes( $classes ) {

	global $post, $woocommerce_loop;

	// Check if we are on a single product page.
	$is_product = ( is_shop() && 'product' === $post->post_type );

	// Check if we are in an upsell or related product loop.
	$is_upsell_or_related = (
		is_single()
		&&
		isset( $woocommerce_loop['name'] )
		&&
		'product' === $post->post_type
		&&
		( 'related' === $woocommerce_loop['name'] || 'up-sells' === $woocommerce_loop['name'] )
	);

	if ( $is_product || $is_upsell_or_related ) {

		$classes[] = 'primer-2-column-product';

	}

	return $classes;

}

/**
 * Add color scheme targets for WooCommerce elements.
 *
 * @filter primer_colors
 * @uses   primer_array_replace_recursive To replace items in the colors array with new values.
 *
 * @since  1.0.0
 *
 * @param  array $colors Original Primer_Customizer_Colors color array.
 *
 * @return array Returns the CSS replacements for WooCommerce elements.
 */
function primer_wc_colors( $colors ) {

	// @codingStandardsIgnoreStart
	$wc_colors = array(
		'primary_text_color' => array(
			'css' => array(
				'ul.cart_list li.mini_cart_item a:nth-child(2)' => array(
					'color' => '%1$s',
				),
			),
			'rgba_css' => array(
				'ul.cart_list li.mini_cart_item a:nth-child(2):hover' => array(
					'color' => 'rgba(%1$s, 0.8)',
				),
			),
		),
		'link_color' => array(
			'css' => array(
				'.woocommerce .star-rating' => array(
					'color' => '%1$s',
				),
			),
		),
		'button_color' => array(
			'css' => array(
				'.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce a.button,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt.disabled,
				.woocommerce button.button.alt.disabled:hover,
				.woocommerce #respond input#submit,
				.woocommerce .product span.onsale,
				.primer-wc-cart-menu .widget_shopping_cart p.buttons a,
				.primer-wc-cart-menu .widget_shopping_cart p.buttons a:visited,
				ul.products a.button,
				ul.products a.button:visited' => array(
					'background-color' => '%1$s',
					'border-color'     => '%1$s',
				),
			),
			'rgba_css' => array(
				'.woocommerce button.button.alt:hover, .woocommerce button.button.alt:active, .woocommerce button.button.alt:focus,
				.woocommerce input.button.alt:hover, .woocommerce input.button.alt:active, .woocommerce input.button.alt:focus,
				.woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce a.button:focus,
				.woocommerce a.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce a.button.alt:focus,
				.woocommerce #respond input#submit:hover,
				.primer-wc-cart-menu .widget_shopping_cart p.buttons a:hover,
				a.button:hover,
				ul.products .button:hover, ul.products .button:active, ul.products .button:focus' => array(
					'background-color' => 'rgba(%1$s, 0.8)',
					'border-color'     => 'rgba(%1$s, 0.8)',
				),
			),
		),
		'button_text_color' => array(
			'css' => array(
				'.woocommerce button.button.alt, .woocommerce button.button.alt:hover,
				.woocommerce input.button.alt, .woocommerce input.button.alt:hover,
				.woocommerce a.button, .woocommerce a.button:visited, .woocommerce a.button:hover, .woocommerce a.button:visited:hover,
				.woocommerce a.button.alt, .woocommerce a.button.alt:visited, .woocommerce a.button.alt:hover, .woocommerce a.button.alt:visited:hover,
				.woocommerce #respond input#submit, .woocommerce #respond input#submit:hover,
				.woocommerce .product span.onsale' => array(
					'color' => '%1$s',
				),
			),
		),
		'background_color' => array(
			'css' => array(
				'li.primer-wc-cart-menu .primer-wc-cart-sub-menu' => array(
					'background-color' => '%1$s',
				),
			),
		),
	);
	// @codingStandardsIgnoreEnd

	return primer_array_replace_recursive( $colors, $wc_colors );

}
add_filter( 'primer_colors', 'primer_wc_colors' );

/**
 * Add font type targets for WooCommerce elements.
 *
 * @filter primer_font_types
 * @uses   primer_array_replace_recursive To replace items in the font types array with new values.
 *
 * @since  1.0.0
 *
 * @param  array $font_types Original Primer_Customizer_Fonts font type array.
 *
 * @return array Returns an array of font alterations for WooCommerce elements.
 */
function primer_wc_font_types( $font_types ) {

	// @codingStandardsIgnoreStart
	$wc_font_types = array(
		'navigation_font' => array(
			'css' => array(
				'.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce a.button' => array(
					'font-family' => '"%1$s", sans-serif',
				),
			),
		),
	);
	// @codingStandardsIgnoreEnd

	return primer_array_replace_recursive( $font_types, $wc_font_types );

}
add_filter( 'primer_font_types', 'primer_wc_font_types' );

/**
 * Change the theme overrides path for WooCommerce templates.
 *
 * @filter woocommerce_template_path
 *
 * @since  1.6.0
 *
 * @return string
 */
function primer_wc_template_path() {

	return 'templates/woocommerce/';

}
add_filter( 'woocommerce_template_path', 'primer_wc_template_path' );

/**
 * Load a custom template for WooCommerce 404 pages.
 *
 * @filter template_include
 *
 * @since  1.5.0
 *
 * @param  string $template The path of the template to include.
 *
 * @return string
 */
function primer_wc_404_template( $template ) {

	return ( is_404() && locate_template( 'templates/woocommerce/404.php' ) ) ? get_template_part( 'templates/woocommerce/404' ) : $template;

}
add_filter( 'template_include', 'primer_wc_404_template' );

/**
 * Add a custom "Cart" menu item when WooCommerce is active.
 *
 * @filter wp_get_nav_menu_items
 *
 * @since  1.5.0
 *
 * @param  array  $items An array of menu item post objects.
 * @param  object $menu  The menu object.
 *
 * @return array
 */
function primer_wc_generate_cart_menu_item( $items, $menu ) {

	if ( ! primer_child_compat( 'wc__cart_menu_item', true ) ) {

		return $items;

	}

	$theme_locations = get_nav_menu_locations();

	if ( empty( $theme_locations['primary'] ) ) {

		return $items;

	}

	$nav_obj = wp_get_nav_menu_object( $theme_locations['primary'] );

	if ( $menu->term_id !== $theme_locations['primary'] || is_admin() ) {

		return $items;

	}

	add_filter( "wp_nav_menu_{$nav_obj->slug}_items", 'primer_wc_cart_menu', 10, 2 );

	return $items;

}
add_filter( 'wp_get_nav_menu_items', 'primer_wc_generate_cart_menu_item', 20, 2 );

/**
 * Append a WooCommerce cart item to a navigation menu.
 *
 * @filter wp_nav_menu_{$menu}_items
 *
 * @global WooCommerce $woocommerce
 *
 * @since  1.5.0
 *
 * @param  string   $items The HTML list content for the menu items.
 * @param  stdClass $args  An object containing wp_nav_menu() arguments.
 *
 * @return string
 */
function primer_wc_cart_menu( $items, $args ) {

	/**
	 * Filter whether to display the WooCommerce cart menu item.
	 *
	 * Default: `true`
	 *
	 * @since 1.5.0
	 *
	 * @var bool
	*/
	if ( ! (bool) apply_filters( 'primer_wc_show_cart_menu', true ) ) {

		return $items;

	}

	if ( is_customize_preview() ) {

		add_filter( 'woocommerce_cart_contents_count', '__return_zero' );

		add_filter( 'woocommerce_cart_contents_total', 'primer_wc_customize_preview_cart_contents_total' );

	}

	global $woocommerce;

	$sub_menu = '';
	$classes  = array( 'menu-item', 'menu-item-type-nav_menu_item', 'menu-item-object-cart' );

	if ( $woocommerce->cart->get_cart_contents_count() ) {

		$sub_menu = sprintf(
			'<ul class="sub-menu primer-wc-cart-sub-menu">
				<li class="primer-wc-cart-sub-menu-item">%s</li>
			</ul>',
			primer_get_the_widget( 'WC_Widget_Cart' )
		);

		$classes[] = 'menu-item-has-children';

	}

	$cart_menu_item = sprintf(
		'<li class="primer-wc-cart-menu primer-wc-cart-menu-item %s">
			<a>
				<span class="cart-preview-total">
					<span class="woocommerce-price-amount amount">%s</span>
				</span>
				<span class="cart-preview-count">%s</span>
			</a>
			%s
			%s
		</li>',
		implode( ' ', array_map( 'esc_attr', $classes ) ),
		$woocommerce->cart->get_cart_total(),
		esc_html(
			sprintf(
				/* translators: WooCommerce shopping cart item count. */
				_n( '%d item', '%d items', $woocommerce->cart->get_cart_contents_count(), 'primer' ),
				$woocommerce->cart->get_cart_contents_count()
			)
		),
		$woocommerce->cart->get_cart_contents_count() ? '<a class="expand" href="#"></a>' : '',
		$sub_menu
	);

	return $items . $cart_menu_item;

}

/**
 * Empty the cart total during Customize preview.
 *
 * @filter woocommerce_cart_contents_total
 * @uses   [wc_price](https://docs.woocommerce.com/wc-apidocs/function-wc_price.html) To format the price with a currency symbol.
 *
 * @since  1.5.0
 *
 * @return string
 */
function primer_wc_customize_preview_cart_contents_total() {

	return wc_price( 0 );

}

if ( ! function_exists( 'primer_wc_promoted_products' ) ) {

	/**
	 * Display promoted products.
	 *
	 * Check for featured products then on-sale products and use the appropiate
	 * shortcode. If neither exist, the default fallback is to display recently
	 * added products.
	 *
	 * @since 1.5.0
	 *
	 * @uses  [wc_get_featured_product_ids](https://docs.woocommerce.com/wc-apidocs/function-wc_get_featured_product_ids.html) To retreive the products that are featured.
	 * @uses  [wc_get_product_ids_on_sale](https://docs.woocommerce.com/wc-apidocs/function-wc_get_product_ids_on_sale.html) To retreive the products that are on sale.
	 *
	 * @param int  $per_page        (optional) Total number of promoted products to display. Defaults to `4`.
	 * @param int  $columns         (optional) Number of columns to display promoted products in. Defaults to `4`.
	 * @param bool $recent_fallback (optional) Whether to display recent products as a fallback when there are no featured or on-sale products. Defaults to `true`.
	 */
	function primer_wc_promoted_products( $per_page = 4, $columns = 4, $recent_fallback = true ) {

		/**
		 * Filter the total number of promoted products to display.
		 *
		 * Default: `4`
		 *
		 * @since 1.5.0
		 *
		 * @var int
		 */
		$per_page = (int) apply_filters( 'primer_wc_promoted_products_per_page', $per_page ); // Can be negative.

		/**
		 * Filter the number of columns to display promoted products in.
		 *
		 * Default: `4`
		 *
		 * @since 1.5.0
		 *
		 * @var int
		 */
		$columns = absint( apply_filters( 'primer_wc_promoted_products_columns', $columns ) );

		if ( wc_get_featured_product_ids() ) {

			echo '<h2>' . esc_html__( 'Featured Products', 'primer' ) . '</h2>';

			echo do_shortcode( "[featured_products per_page='{$per_page}' columns='{$columns}']" );

			return;

		}

		if ( wc_get_product_ids_on_sale() ) {

			echo '<h2>' . esc_html__( 'On Sale Now', 'primer' ) . '</h2>';

			echo do_shortcode( "[sale_products per_page='{$per_page}' columns='{$columns}']" );

			return;

		}

		if ( ! $recent_fallback ) {

			return;

		}

		echo '<h2>' . esc_html__( 'New In Store', 'primer' ) . '</h2>';

		echo do_shortcode( "[recent_products per_page='{$per_page}' columns='{$columns}']" );

	}

} // End if.

if ( ! function_exists( 'primer_wc_best_selling_products' ) ) {

	/**
	 * Display best-selling products.
	 *
	 * @since 1.5.0
	 *
	 * @param int $per_page (optional) Total number of best-selling products to display. Defaults to `4`.
	 * @param int $columns  (optional) Number of columns to display best-selling products in. Defaults to `4`.
	 */
	function primer_wc_best_selling_products( $per_page = 4, $columns = 4 ) {

		/**
		 * Filter the total number of best-selling products to display.
		 *
		 * Default: `4`
		 *
		 * @since 1.5.0
		 *
		 * @var int
		 */
		$per_page = (int) apply_filters( 'primer_wc_best_selling_products_per_page', $per_page ); // Can be negative.

		/**
		 * Filter the number of columns to display best-selling products in.
		 *
		 * Default: `4`
		 *
		 * @since 1.5.0
		 *
		 * @var int
		 */
		$columns = absint( apply_filters( 'primer_wc_best_selling_products_columns', $columns ) );

		echo do_shortcode( "[best_selling_products per_page='{$per_page}' columns='{$columns}']" );

	}

} // End if.

/**
 * Prevent WooCommerce product image from loading as the header image
 *
 * @return boolean False if a WooCommerce product, else true
 *
 * @since 1.7.0
 */
function primer_wc_product_header_image() {

	/**
	 * Filter whether the WooCommerce product should be used as the header image
	 *
	 * @since 1.7.0
	 */
	return apply_filters( 'primer_wc_product_header_image', ! is_product() );

}
add_filter( 'primer_use_featured_hero_image', 'primer_wc_product_header_image' );

/**
 * Override the queried object with the proper archive page post ID
 *
 * @param object $queried_object Global queried object.
 *
 * @return object|integer
 *
 * @since 1.8.9
 */
function primer_wc_header_image_object( $queried_object ) {

	return is_shop() ? wc_get_page_id( 'shop' ) : $queried_object;

}
add_filter( 'primer_hero_image_queried_object', 'primer_wc_header_image_object' );
