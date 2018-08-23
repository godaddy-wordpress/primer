<?php
/**
 * The template for displaying reseller store single posts.
 *
 * Replaces /single.php and /content.php templates.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Primer
 * @since   NEXT
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"> <!-- single -->

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'rstore-product product' ); ?>> <!-- content -->

				<?php

				/**
				 * Fires inside the `article` element, before the content.
				 *
				 * @hooked primer_wc_shop_messages - 10
				 *
				 * @since NEXT
				 */
				do_action( 'primer_before_post_content' );

				?>
				<?php get_template_part( 'templates/parts/loop/post', 'thumbnail' ); ?>
				<div class="product-header">
					<?php get_template_part( 'templates/parts/loop/post', 'title' ); ?>
					<?php rstore_price( $post->ID, true ); ?>
					<?php rstore_add_to_cart_form( $post->ID, true ); ?>
				</div>
				<div class="product-tabs">
					<div class="product-description">
						<?php get_template_part( 'templates/parts/loop/post', 'content' ); ?>
					</div>
				</div>
				<?php get_template_part( 'templates/parts/loop/post', 'footer' ); ?>

				<?php

				/**
				 * Fires inside the `article` element, after the content.
				 *
				 * @since NEXT
				 */
				do_action( 'primer_after_post_content' );

				?>
			</article><!-- #content -->

			<?php primer_post_nav(); ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>

				<?php comments_template(); ?>

		<?php endif; ?>

		<?php endwhile; ?>

	</main><!-- #single -->
</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>
