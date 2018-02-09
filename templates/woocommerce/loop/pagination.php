<?php
/**
 * The template for displaying numbered pagination on WooCommerce catalog pages.
 *
 * @link https://docs.woocommerce.com/document/template-structure/
 *
 * @package Primer
 * @since   1.6.0
 *
 * @version 3.3.1
 */

global $wp_query;

if ( empty( $wp_query->max_num_pages ) || (int) $wp_query->max_num_pages < 2 ) {

	return;

}

/**
 * Filter the WooCommerce product pagination args.
 *
 * @since 1.6.0
 *
 * @var array
 */
$args = (array) apply_filters( 'primer_wc_pagination_args', array(
	'type'      => 'plain',
	'end_size'  => 1,
	'mid_size'  => 2,
	'prev_text' => __( '&larr; Previous', 'primer' ),
	'next_text' => __( 'Next &rarr;', 'primer' ),
) );

global $post;

$post_type_labels = get_post_type_labels( get_post_type_object( $post->post_type ) );
$post_type_label  = isset( $post_type_labels->singular_name ) ? $post_type_labels->singular_name : $post->post_type;

?>

<nav class="navigation pagination woocommerce-pagination">

	<h2 class="screen-reader-text"><?php printf( /* translators: post type singular label */ esc_html__( '%s navigation', 'primer' ), esc_html( $post_type_label ) ); ?></h2>

	<div class="paging-nav-text"><?php printf( /* translators: 1. current page number, 2. total number of pages */ esc_html__( 'Page %1$d of %2$d', 'primer' ), max( 1, get_query_var( 'paged' ) ), absint( $wp_query->max_num_pages ) ); // xss ok. ?></div>

	<div class="nav-links">

		<?php echo paginate_links( $args ); // xss ok. ?>

	</div>

</nav>
