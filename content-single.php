<?php
/**
 * The template part for displaying single post content.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basis
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'basis_article_header' ); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'basis' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="entry-footer-right">
			<?php edit_post_link( __( 'Edit', 'basis' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'basis' ) );
				if ( $categories_list && basis_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in: %1$s', 'basis' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'basis' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Filed under: %1$s', 'basis' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
