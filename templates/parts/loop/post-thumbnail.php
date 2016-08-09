<?php
/**
 * Template part for displaying the post thumbnail inside The Loop.
 *
 * @package Primer
 */
?>

<?php if ( has_post_thumbnail() ) : ?>

	<div class="featured-image">

		<?php the_post_thumbnail( 'primer-featured' ); ?>

	</div><!-- .featured-image -->

<?php endif; ?>
