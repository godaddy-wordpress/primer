<?php
/**
 * Template part for displaying the post footer inside The Loop.
 *
 * @package Primer
 * @since   1.0.0
 */
?>

<footer class="entry-footer">

	<div class="entry-footer-right">

		<?php edit_post_link( esc_html__( 'Edit', 'primer' ), '<span class="edit-link">', '</span>' ); ?>

	</div>

	<?php if ( 'post' === get_post_type() ) : ?>

		<?php $category_list = get_the_category_list( esc_html_x( ', ', 'separator for items in a list', 'primer' ) ); ?>

		<?php if ( $category_list && primer_has_active_categories() ) : ?>

			<span class="cat-links">

				<?php printf( esc_html_x( 'Posted in: %s', 'category list', 'primer' ), $category_list ); ?>

			</span>

		<?php endif; ?>

		<?php $tag_list = get_the_tag_list( '', esc_html_x( ', ', 'separator for items in a list', 'primer' ) ); ?>

		<?php if ( $tag_list ) : ?>

			<span class="tags-links">

				<?php printf( esc_html_x( 'Filed under: %s', 'tag list', 'primer' ), $tag_list ); ?>

			</span>

		<?php endif; ?>

	<?php endif; ?>

</footer><!-- .entry-footer -->
