<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Primer
 * @since   1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<?php

	while ( have_posts() ) :

		the_post();

		get_template_part( 'content' );

		primer_post_nav();

		if ( comments_open() || get_comments_number() ) :

			comments_template();

		endif;

	endwhile;

	?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php

get_sidebar();

get_sidebar( 'tertiary' );

get_footer();

?>
