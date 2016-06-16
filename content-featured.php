<?php
/**
 * Featured article for header area.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Primer
 */

$featured = primer_get_featured_posts();

if ( ! $featured ) {

	return;

}

?>

<div class="featured-content">

	<div class="featured-content-inner">

	<?php foreach ( $featured as $post ) : setup_postdata( $post ) ?>

		<article id="post-<?php the_ID() ?>" <?php post_class() ?>>

			<div class="entry-meta">

				<span class="post-format"><?php _e( 'Featured', 'primer' ) ?></span>

				<span class="entry-date"><?php the_time( get_option( 'date_format' ) ) ?></span>

			</div>

			<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

			<div class="entry-excerpt"><?php the_excerpt() ?></div>

			<a class="read-more" href="<?php the_permalink() ?>"><?php _e( 'Read More', 'primer' ) ?></a>

		</article>

	<?php endforeach; ?>

	</div><!-- .featured-content-inner -->

</div><!-- .featured-content -->
