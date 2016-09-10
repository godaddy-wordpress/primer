<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#404-php
 *
 * @package Primer
 * @since   1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

		<section class="error-404 not-found">

			<header class="page-header">

				<h1 class="page-title"><?php esc_html_e( "Oops! That page can't be found.", 'primer' ); ?></h1>

			</header><!-- .page-header -->

			<div class="page-content">

				<p><?php esc_html_e( 'It looks like nothing was found at this location. Please try searching below:', 'primer' ); ?></p>

				<?php get_search_form(); ?>

			</div><!-- .page-content -->

		</section><!-- .error-404 -->

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>
