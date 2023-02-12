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

	<?php

	if ( have_posts() ) :

		while ( have_posts() ) :

			the_post();

			get_template_part( 'content', 'search' );

		endwhile;

		primer_pagination();

		else :

			get_template_part( 'content', 'none' );

	endif;

		?>

	</main><!-- #main -->

</section><!-- #primary -->

<?php

get_sidebar();

get_sidebar( 'tertiary' );

get_footer();

?>
