<?php
/**
 * Template part for displaying the page content inside The Loop.
 *
 * @package Primer
 */
?>

<div class="page-content">

	<?php

	/**
	 * primer_before_content hook.
	 *
	 * @hooked primer_woo_shop_message - 10
	 *
	 * @since 1.0.0
	 */
	do_action( 'primer_before_content' );

	the_content();

	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'primer' ),
			'after'  => '</div>',
		)
	);

	/**
	 * primer_after_content hook.
	 *
	 * @since 1.0.0
	 */
	do_action( 'primer_after_content' );

	?>

</div><!-- .page-content -->
