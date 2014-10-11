<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Basis
 */

global $authordata;

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php if(is_single()) { ?>
	<div class="widget widget_author">
		<h6 class="widget-title">About the Author</h6>
		<?php echo get_avatar(get_the_author_meta('user_email'), $size = '96'); ?>
		<div class="author-name">
			<a href="><?php the_author_meta('user_url'); ?>"><?php the_author_meta('display_name'); ?></a>
		</div>
		<p><?php the_author_meta('description'); ?></p>
		<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>">View Posts &rarr;</a>
	</div>
	<?php } ?>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
