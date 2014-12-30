<?php
/**
 * The template part for displaying general content.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basis
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'templates/parts/loop/post', 'thumbnail' ); ?>

	<?php get_template_part( 'templates/parts/loop/post', 'title' ); ?>

	<?php get_template_part( 'templates/parts/loop/post', 'content' ); ?>

	<?php get_template_part( 'templates/parts/loop/post', 'footer' ); ?>

</article><!-- #post-## -->