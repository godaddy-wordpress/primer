<?php
/**
 * Template part for displaying the post content inside The Loop.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="entry-content">

	<?php

	the_content( __( 'Read More <span class="meta-nav">&rarr;</span>', 'primer' ) );

	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'primer' ),
			'after'  => '</div>',
		)
	);

	?>

</div><!-- .entry-content -->
