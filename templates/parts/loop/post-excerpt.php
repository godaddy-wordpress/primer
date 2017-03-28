<?php
/**
 * Template part for displaying the post excerpt inside The Loop.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="entry-summary">

	<?php the_excerpt(); ?>

	<p><a class="button" href="<?php the_permalink(); ?>" aria-label="<?php printf( esc_attr_x( 'Continue reading %s', 'post title', 'primer' ), get_the_title() ); ?>"><?php printf( esc_html_x( 'Continue Reading %s', 'right arrow (LTR) / left arrow (RTL)', 'primer' ), is_rtl() ? '&larr;' : '&rarr;' ); ?></a></p>

</div><!-- .entry-summary -->
