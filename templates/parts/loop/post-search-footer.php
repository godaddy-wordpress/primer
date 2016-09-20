<?php
/**
 * Template part for displaying the post footer on search results inside The Loop.
 *
 * @package Primer
 * @since   1.0.0
 */
?>

<footer class="entry-footer">

	<?php if ( 'post' == get_post_type() ) : ?>

		<?php $category_list = get_the_category_list( esc_html_x( ', ', 'separator for items in a list', 'the-primer' ) ); ?>

		<?php if ( $category_list && primer_has_active_categories() ) : ?>

			<span class="cat-links">

				<?php printf( esc_html_x( 'Posted in: %s', 'category list', 'the-primer' ), $category_list ); ?>

			</span>

		<?php endif; ?>

		<?php $tag_list = get_the_tag_list( '', esc_html_x( ', ', 'separator for items in a list', 'the-primer' ) ); ?>

		<?php if ( $tag_list ) : ?>

			<span class="tags-links">

				<?php printf( esc_html_x( 'Filed under: %s', 'tag list', 'the-primer' ), $tag_list ); ?>

			</span>

		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>

		<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'the-primer' ), esc_html__( '1 Comment', 'the-primer' ), esc_html_x( '% Comments', 'number of comments', 'the-primer' ) ); ?></span>

	<?php endif; ?>

	<?php edit_post_link( esc_html__( 'Edit', 'the-primer' ), '<span class="edit-link">', '</span>' ); ?>

</footer><!-- .entry-footer -->
