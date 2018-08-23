<?php
/**
 * The template for displaying reseller store posts in a list.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Primer
 * @since   NEXT
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'rstore-list-product' ); ?>>

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
	<div class="product-summary">
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a class="link" href="<?php the_permalink(); ?>" aria-label="<?php printf( /* translators: post title */ esc_attr__( 'More info %s', 'primer' ), get_the_title() ); ?>"><?php printf( /* translators: right arrow (LTR) / left arrow (RTL) */ esc_html__( 'More Info %s', 'primer' ), is_rtl() ? '&larr;' : '&rarr;' ); ?></a>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php

	get_template_part( 'templates/parts/loop/post', 'footer' );

	/**
	 * Fires inside the `article` element, after the content.
	 *
	 * @since NEXT
	 */
	do_action( 'primer_after_post_content' );

	?>

</article><!-- #post-## -->
