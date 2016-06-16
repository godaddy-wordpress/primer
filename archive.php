<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Primer
 */

get_header() ?>

<section id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="archive-header">

			<h1 class="archive-title"><?php the_archive_title() ?></h1>

			<?php if ( get_the_archive_description() ) : ?>

				<div class="archive-description"><?php the_archive_description() ?></div>

			<?php endif; ?>

		</header><!-- .page-header -->

		<?php while ( have_posts() ) : the_post() ?>

			<?php get_template_part( 'content', get_post_format() ) ?>

		<?php endwhile; ?>

		<?php primer_paging_nav() ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ) ?>

	<?php endif; ?>

	</main><!-- #main -->

</section><!-- #primary -->

<?php get_sidebar() ?>

<?php get_sidebar( 'tertiary' ) ?>

<?php get_footer() ?>
