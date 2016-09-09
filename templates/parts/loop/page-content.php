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
	 */
	do_action( 'primer_after_content' );

	?>

</div><!-- .page-content -->
