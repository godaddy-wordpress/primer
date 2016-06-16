<?php
/**
 * The template used for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Primer
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class() ?>>

	<?php get_template_part( 'templates/parts/loop/post', 'thumbnail' ) ?>

	<?php get_template_part( 'templates/parts/loop/page', 'title' ) ?>

	<?php get_template_part( 'templates/parts/loop/page', 'content' ) ?>

	<?php get_template_part( 'templates/parts/loop/page', 'footer' ) ?>

</article><!-- #post-## -->
