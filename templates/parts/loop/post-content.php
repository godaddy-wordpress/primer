<?php
/**
 * The template part for displaying the post content.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basis
 */
?>
<div class="entry-content">
	<?php the_content( __( 'Read More <span class="meta-nav">&rarr;</span>', 'basis' ) ); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'basis' ),
			'after'  => '</div>',
		) );
	?>
</div><!-- .entry-content -->