<?php
/**
 * The template part for displaying the post title.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basis
 */
?>
<header class="entry-header">
	<div class="entry-header-row">
		<div class="entry-header-column">
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				$format = get_post_format( get_the_ID() );
				if ( false === $format ) {
					$format = 'standard';
				}
				echo '<span class="post-format">' . $format . '</span>';
				?>
				<?php basis_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" rel="permalink"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></a>
		</div><!-- .entry-header-column -->
	</div><!-- .entry-header-row -->
</header><!-- .entry-header -->