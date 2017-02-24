<?php
/**
 * The template for displaying numbered pagination on WooCommerce catalog pages.
 *
 * @link https://docs.woocommerce.com/document/template-structure/
 *
 * @package Primer
 * @since   NEXT
 */

global $wp_query;

if ( empty( $wp_query->max_num_pages ) || (int) $wp_query->max_num_pages < 2 ) {

	return;

}

$current = max( 1, get_query_var( 'paged' ) );
$total   = absint( $wp_query->max_num_pages );

/**
 * Filter the WooCommerce product pagination args.
 *
 * @since NEXT
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

?>

<nav class="navigation pagination woocommerce-pagination">

	<h2 class="screen-reader-text"><?php printf( esc_html_x( 'Page %1$d of %2$d', '1. current page number, 2. total number of pages', 'primer' ), $current, $total ); // xss ok. ?></h2>

	<div class="nav-links">

		<?php echo paginate_links( $args ); // xss ok. ?>

	</div>

</nav>
