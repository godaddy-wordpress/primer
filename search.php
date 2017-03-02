<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Primer
 * @since   1.0.0
 */

get_header(); ?>

<section id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post() ?>

			<?php get_template_part( 'content', 'search' ); ?>

		<?php endwhile; ?>

		<?php primer_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

	</main><!-- #main -->

</section><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>
