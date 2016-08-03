<?php
/**
 * Template Name: Page Builder (No Header)
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/page-templates/
 *
 * @package Primer
 */

get_header() ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post() ?>

			<?php the_content() ?>

		<?php endwhile; ?>

		<?php primer_paging_nav() ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ) ?>

	<?php endif; ?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_footer() ?>
