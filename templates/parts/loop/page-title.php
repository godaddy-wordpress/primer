<?php
/**
 * The template used for displaying page title within the loop.
 *
 * @package Primer
 */
?>
<header class="page-header">
	<?php $tag = is_singular() ? 'h1' : 'h2'; ?>
	<<?php echo $tag; ?> class="page-title">

		<?php if( ! is_singular() ): ?>
			<a href="<?php the_permalink(); ?>" rel="permalink">
		<?php endif; ?>

		<?php the_title(); ?>

		<?php if( ! is_singular() ): ?>
			</a>
		<?php endif; ?>

	</<?php echo $tag; ?>>
</header><!-- .entry-header -->
