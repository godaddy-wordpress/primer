<?php
/**
 * WooCommerce compatibility.
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Enable support for WooCommerce.
 *
 * @action after_setup_theme
 * @link   https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 * @since  1.0.0
 */
function primer_wc_setup() {

	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'primer_wc_setup' );

/**
 * Remove the default WooCommerce page wrapper.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end' );

/**
 * Markup for page wrapper start.
 *
 * @action woocommerce_before_main_content
 * @since  1.0.0
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
 * @since  1.0.0
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
 * @since  1.0.0
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
 * @since  1.0.0
 *
 * @param  string $layout
 *
 * @return string
 */
function primer_wc_shop_layout( $layout ) {

	if ( is_shop() ) {

		remove_filter( 'primer_current_layout', __FUNCTION__ ); // Prevent infinite loop

		$layout = primer_get_layout( wc_get_page_id( 'shop' ) );

	}

	return $layout;

}
add_filter( 'primer_current_layout', 'primer_wc_shop_layout' );

/**
 * Filter the WooCommerce shop page title.
 *
 * @filter primer_the_page_title
 * @since  1.0.0
 *
 * @param  string $title
 *
 * @return string
 */
function primer_wc_shop_title( $title ) {

	if ( is_shop() ) {

		add_filter( 'woocommerce_page_title', '__return_null' );

		$title = get_the_title( wc_get_page_id( 'shop' ) );

	}

	return $title;

}
add_filter( 'primer_the_page_title', 'primer_wc_shop_title' );

/**
 * Filter the number of WooCommerce shop columns
 *
 * @filter loop_shop_columns
 * @filter woocommerce_related_products_columns
 * @filter woocommerce_upsells_products_columns
 * @global WP_Post $post
 * @since  1.0.0
 *
 * @param  int $columns
 *
 * @return int
 */
function primer_wc_shop_columns( $columns ) {

	global $post;

	$page_id = ( is_shop() ) ? wc_get_page_id( 'shop' ) : $post->ID;

	if ( 0 === strpos( primer_get_layout( absint( $page_id ) ), 'three-column-' ) ) {

		add_filter( 'post_class', 'primer_wc_product_classes' );

		$columns = 2;

	}

	return $columns;

}
add_filter( 'loop_shop_columns',                    'primer_wc_shop_columns' );
add_filter( 'woocommerce_related_products_columns', 'primer_wc_shop_columns' );
add_filter( 'woocommerce_upsells_products_columns', 'primer_wc_shop_columns' );

/**
 * Filter the WooCommerce product class.
 *
 * @filter primer_wc_product_classes
 * @global WP_Post $post
 * @global array   $woocommerce_loop
 * @since  1.0.0
 *
 * @param  array $classes
 *
 * @return array
 */
function primer_wc_product_classes( $classes ) {

	global $post, $woocommerce_loop;

	/**
	 * Check if on the WooCommerce shop page, and the post type is 'product'
	 *
	 * @var bool
	 */
	$is_product = ( is_shop() && 'product' === $post->post_type );

	/**
	 * Check if on single product page, in upsell or related product loop
	 * and the post type is 'product'
	 *
	 * @var bool
	 */
	$is_upsell_or_related = (
		is_single()
		&&
		isset( $woocommerce_loop['name'] )
		&&
		'product' === $post->post_type
		&&
		( 'related' === $woocommerce_loop['name'] || 'up-sells' === $woocommerce_loop['name'] )
	);

	if ( $is_product ||  $is_upsell_or_related ) {

		$classes[] = 'primer-2-column-product';

	}

	return $classes;

}

/**
 * Add color scheme targets for WooCommerce elements.
 *
 * @filter primer_colors
 * @since  1.0.0
 *
 * @param  array $colors
 *
 * @return array
 */
function primer_wc_colors( $colors ) {

	$wc_colors = array(
		'button_color' => array(
			'css' => array(
				'.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce a.button,
				.woocommerce a.button.alt,
				.woocommerce #respond input#submit,
				.woocommerce .product span.onsale,
				#primer-cart-menu-item .widget_shopping_cart p.buttons a,
				#primer-cart-menu-item .widget_shopping_cart p.buttons a:visited,
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
				#primer-cart-menu-item .widget_shopping_cart p.buttons a:hover,
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
	);

	return primer_array_replace_recursive( $colors, $wc_colors );

}
add_filter( 'primer_colors', 'primer_wc_colors' );

/**
 * Add font type targets for WooCommerce elements.
 *
 * @filter primer_font_types
 * @since  1.0.0
 *
 * @param  array $font_types
 *
 * @return array
 */
function primer_wc_font_types( $font_types ) {

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

	return primer_array_replace_recursive( $font_types, $wc_font_types );

}
add_filter( 'primer_font_types', 'primer_wc_font_types' );

/**
 * Load a custom template for WooCommerce 404 pages.
 *
 * @filter template_include
 * @since  NEXT
 *
 * @param  string $default The default 404 template.
 *
 * @return string
 */
function primer_wc_404_template( $default ) {

	return ( is_404() && locate_template( 'templates/parts/404-woocommerce.php' ) ) ? get_template_part( 'templates/parts/404', 'woocommerce' ) : $default;

}
add_filter( 'template_include', 'primer_wc_404_template' );

if ( ! function_exists( 'primer_wc_promoted_products' ) ) {

	/**
	 * Display promoted products.
	 *
	 * Check for featured products then on-sale products and use the appropiate
	 * shortcode. If neither exist, the default fallback is to display recently
	 * added products.
	 *
	 * @since NEXT
	 * @uses  wc_get_featured_product_ids()
	 * @uses  wc_get_product_ids_on_sale()
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
		 * @since NEXT
		 *
		 * @var int
		 */
		$per_page = (int) apply_filters( 'primer_wc_promoted_products_per_page', $per_page ); // Can be negative

		/**
		 * Filter the number of columns to display promoted products in.
		 *
		 * Default: `4`
		 *
		 * @since NEXT
		 *
		 * @var int
		 */
		$columns = absint( apply_filters( 'primer_wc_promoted_products_columns', $columns ) );

		if ( wc_get_featured_product_ids() ) {

			echo '<h2>' . esc_html__( 'Featured Products', 'primer' ) . '</h2>';

			echo do_shortcode( "[featured_products per_page='{$per_page}' columns='{$columns}']" ); // xss ok

			return;

		}

		if ( wc_get_product_ids_on_sale() ) {

			echo '<h2>' . esc_html__( 'On Sale Now', 'primer' ) . '</h2>';

			echo do_shortcode( "[sale_products per_page='{$per_page}' columns='{$columns}']" ); // xss ok

			return;

		}

		if ( ! $recent_fallback ) {

			return;

		}

		echo '<h2>' . esc_html__( 'New In Store', 'primer' ) . '</h2>';

		echo do_shortcode( "[recent_products per_page='{$per_page}' columns='{$columns}']" ); // xss ok

	}

}

if ( ! function_exists( 'primer_wc_best_selling_products' ) ) {

	/**
	 * Display best-selling products.
	 *
	 * @since NEXT
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
		 * @since NEXT
		 *
		 * @var int
		 */
		$per_page = (int) apply_filters( 'primer_wc_best_selling_products_per_page', $per_page ); // Can be negative

		/**
		 * Filter the number of columns to display best-selling products in.
		 *
		 * Default: `4`
		 *
		 * @since NEXT
		 *
		 * @var int
		 */
		$columns  = absint( apply_filters( 'primer_wc_best_selling_products_columns', $columns ) );

		echo do_shortcode( "[best_selling_products per_page='{$per_page}' columns='{$columns}']" ); // xss ok

	}

}

/**
 * Add a custom "Cart" menu item when WooCommerce is active.
 *
 * @filter wp_get_nav_menu_items
 * @since  NEXT
 *
 * @param  array  $items
 * @param  object $menu
 *
 * @return array  $items
 */
function primer_wc_generate_cart_menu_item( $items, $menu ) {

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
 * @filter wp_nav_menu_{$menu->slug}_items
 * @global WooCommerce $woocommerce
 * @since  NEXT
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
	 * @since NEXT
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

	$sub_menu = ( $woocommerce->cart->get_cart_contents_count() ) ? sprintf(
		'<ul class="sub-menu">
			<li id="primer-cart-menu-item" class="menu-item primer-cart-menu-item empty-cart">%1$s</li>
		</ul>',
		primer_get_the_widget( 'WC_Widget_Cart' )
	) : '';

	$cart_menu = sprintf(
		'<li id="primer-cart-menu-item" class="%1$s menu-item menu-item-type-nav_menu_item menu-item-object-cart primer-cart-menu-item">
			<a>
				<span class="cart-preview-total">
					<span class="woocommerce-price-amount amount">%2$s</span>
				</span>
				<span class="cart-preview-count">%3$s</span>
			</a>
			<a class="expand" href="#"></a>
			%4$s
		</li>',
		( $woocommerce->cart->get_cart_contents_count() ) ? 'menu-item-has-children' : '',
		$woocommerce->cart->get_cart_total(),
		esc_html( sprintf( _n( '%s item', '%s items', $woocommerce->cart->get_cart_contents_count(), 'primer' ), $woocommerce->cart->get_cart_contents_count() ) ),
		$sub_menu
	);

	return $items . $cart_menu;

}

/**
 * Empty the cart total during Customize preview.
 *
 * @filter woocommerce_cart_contents_total
 * @since  NEXT
 *
 * @return string
 */
function primer_wc_customize_preview_cart_contents_total() {

	return wc_price( 0 );

}
