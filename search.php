<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Primer
 */

get_header() ?>

<section id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">

			<h1 class="page-title"><?php printf( esc_html_x( 'Search Results for: %s', 'search term', 'primer' ), sprintf( '<span>%s</span>', get_search_query() ) ) ?></h1>

		</header><!-- .page-header -->

		<?php while ( have_posts() ) : the_post() ?>

			<?php get_template_part( 'content', 'search' ) ?>

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
