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
 * @filter theme_mod_layout
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
 * @since 1.0.0
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
 *
 * @param  array $classes
 *
 * @return array
 *
 * @since 1.0.0
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
				.woocommerce a.button,
				.woocommerce a.button.alt,
				.woocommerce #respond input#submit,
				.woocommerce .product span.onsale,
				#woocommerce-cart-menu-item .widget_shopping_cart p.buttons a,
				#woocommerce-cart-menu-item .widget_shopping_cart p.buttons a:visited,
				ul.products a.button,
				ul.products a.button:visited' => array(
					'background-color' => '%1$s',
					'border-color'     => '%1$s',
				),
			),
			'rgba_css' => array(
				'.woocommerce button.button.alt:hover, .woocommerce button.button.alt:active, .woocommerce button.button.alt:focus,
				.woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce a.button:focus,
				.woocommerce a.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce a.button.alt:focus,
				.woocommerce #respond input#submit:hover,
				#woocommerce-cart-menu-item .widget_shopping_cart p.buttons a:hover,
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
 * Load a custom template for WooCommerce 404 pages
 *
 * @param  string $original_template The original template to load.
 *
 * @return string
 */
function primer_wc_404_template( $original_template ) {

	if ( is_404() ) {

		return get_stylesheet_directory() . '/templates/parts/404-woocommerce.php';

	}

	return $original_template;

}
add_filter( 'template_include', 'primer_wc_404_template' );

/**
 * Display Promoted Products
 */
if ( ! function_exists( 'primer_wc_promoted_products' ) ) {
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @param integer $per_page total products to display.
	 * @param integer $columns columns to arrange products in to.
	 * @param boolean $recent_fallback Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 *
	 * @uses  wc_get_featured_product_ids()
	 * @uses  wc_get_product_ids_on_sale()
	 *
	 * @return void
	 */
	function primer_wc_promoted_products( $per_page = '4', $columns = '4', $recent_fallback = true ) {

		if ( wc_get_featured_product_ids() ) {

			echo '<h2>' . esc_html__( 'Featured Products', 'primer' ) . '</h2>';

			echo do_shortcode( "[featured_products per_page='{$per_page}' columns='{$columns}']" );

			return;

		} elseif ( wc_get_product_ids_on_sale() ) {

			echo '<h2>' . esc_html__( 'On Sale Now', 'primer' ) . '</h2>';

			echo do_shortcode( "[sale_products per_page='{$per_page}' columns='{$columns}']" );

			return;

		}

		echo '<h2>' . esc_html__( 'New In Store', 'primer' ) . '</h2>';

		echo do_shortcode( "[recent_products per_page='{$per_page}' columns='{$columns}']" );

	}

}

/**
 * Add custom 'cart' menu item when woocommerce is active
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
 * Generate the custom woocommerce menu item
 *
 * @param  array $items
 * @param  array $args
 *
 * @return mixed
 */
function primer_wc_cart_menu( $items, $args ) {

	if ( ! apply_filters( 'primer_wc_cart_menu', true ) ) {

		return $items;

	}

	global $woocommerce;

	$cart_total      = is_customize_preview() ? '0.00' : $woocommerce->cart->get_cart_total();
	$cart_item_count = is_customize_preview() ? 0 : (int) $woocommerce->cart->get_cart_contents_count();
	$product_count   = sprintf( _n( '%s item', '%s items', $cart_item_count, 'primer' ), $cart_item_count );

	$empty_class = ( 0 < $cart_item_count ) ? '' : ' empty-cart';

	$sub_menu = ( 0 < $cart_item_count ) ? sprintf(
		'<ul class="sub-menu"><li id="woocommerce-cart-menu-item" class="menu-item woocommerce-cart-menu-item%1$s">%2$s</li></ul>',
		esc_attr( $empty_class ),
		get_the_widget( 'WC_Widget_Cart' )
	) : '';

	$cart_menu = sprintf(
		'<li id="woocommerce-cart-menu-item" class="menu-item-has-children menu-item menu-item-type-nav_menu_item menu-item-object-cart woocommerce-cart-menu-item"><a><span class="cart-preview-total"><span class="woocommerce-price-amount amount">%1$s</span></span><span class="cart-preview-count">%2$s</span></a><a class="expand" href="#"></a>%3$s</li>',
		$cart_total,
		esc_attr( $product_count ),
		$sub_menu
	);

	return $items . $cart_menu;

}
