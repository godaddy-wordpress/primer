<?php
/**
 * Template part for displaying the page content inside The Loop.
 *
 * @package Primer
 * @since   1.0.0
 */
?>

<div class="page-content">

	<?php

	/**
	 * Fires inside the `.page-content` element, before the content.
	 *
	 * @hooked the_primer_woo_shop_messages - 10
	 *
	 * @since 1.0.0
	 */
	do_action( 'the_primer_before_page_content' );

	the_content();

	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'the-primer' ),
			'after'  => '</div>',
		)
	);

	/**
	* Fires inside the `.page-content` element, after the content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'the_primer_after_page_content' );

	?>

</div><!-- .page-content -->
