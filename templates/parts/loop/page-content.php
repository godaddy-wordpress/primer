<?php
/**
 * The template used for displaying page content within the loop.
 *
 * @package Basis
 */
?>
<div class="entry-content">
	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'basis' ),
			'after'  => '</div>',
		) );
	?>
</div><!-- .entry-content -->