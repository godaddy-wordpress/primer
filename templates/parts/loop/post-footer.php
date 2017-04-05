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

		<?php $category_list = get_the_category_list( /* translators: separator for items in a list */ esc_html__( ', ', 'primer' ) ); ?>

		<?php if ( $category_list && primer_has_active_categories() ) : ?>

			<span class="cat-links">

				<?php printf( /* translators: category list */ esc_html__( 'Posted in: %s', 'primer' ), $category_list ); // xss ok. ?>

			</span>

		<?php endif; ?>

		<?php $tag_list = get_the_tag_list( '', /* translators: separator for items in a list */ esc_html__( ', ', 'primer' ) ); ?>

		<?php if ( $tag_list ) : ?>

			<span class="tags-links">

				<?php printf( /* translators: tag list */ esc_html__( 'Filed under: %s', 'primer' ), $tag_list ); // xss ok. ?>

			</span>

		<?php endif; ?>

	<?php endif; ?>

</footer><!-- .entry-footer -->
