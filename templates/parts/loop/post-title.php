<?php
/**
 * The template part for displaying the post title.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package basis
 */
?>
<header class="entry-header">
	<div class="entry-header-row">
		<div class="entry-header-column">

			<?php do_action( 'basis_before_post_title' ); ?>

			<?php $tag = is_single() ? 'h1' : 'h2'; ?>
			<<?php echo $tag; ?> class="entry-title">
				<?php if( ! is_singular() ): ?>
					<a href="<?php the_permalink(); ?>" rel="permalink">
				<?php endif; ?>

				<?php the_title(); ?>

				<?php if( ! is_singular() ): ?>
					</a>
				<?php endif; ?>
			</<?php echo $tag; ?>>

			<?php do_action( 'basis_after_post_title' ); ?>

		</div><!-- .entry-header-column -->
	</div><!-- .entry-header-row -->
</header><!-- .entry-header -->
