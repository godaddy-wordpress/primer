<?php
/**
 * The template part for displaying the post footer.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Primer
 */
?>
<footer class="entry-footer">
	<div class="entry-footer-right">
		<?php edit_post_link( __( 'Edit', 'primer' ), '<span class="edit-link">', '</span>' ); ?>
	</div>

	<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'primer' ) );
			if ( $categories_list && primer_categorized_blog() ) :
		?>
		<span class="cat-links">
			<?php printf( __( 'Posted in: %1$s', 'primer' ), $categories_list ); ?>
		</span>
		<?php endif; // End if categories ?>

		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'primer' ) );
			if ( $tags_list ) :
		?>
		<span class="tags-links">
			<?php printf( __( 'Filed under: %1$s', 'primer' ), $tags_list ); ?>
		</span>
		<?php endif; // End if $tags_list ?>
	<?php endif; // End if 'post' == get_post_type() ?>
</footer><!-- .entry-footer -->
