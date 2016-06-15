<?php
/**
 * The template used for displaying page content within the loop.
 *
 * @package Primer
 */
?>
<div class="page-content">
	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'primer' ),
			'after'  => '</div>',
		) );
	?>
</div><!-- .page-content -->
