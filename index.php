<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Primer
 * @since   1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php

	if ( have_posts() ) :

		while ( have_posts() ) :

			the_post();

			get_template_part( 'content', get_post_format() );

		endwhile;

		primer_pagination();

		else :

			get_template_part( 'content', 'none' );

	endif;

		?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php

get_sidebar();

get_sidebar( 'tertiary' );

get_footer();

?>
