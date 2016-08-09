<?php
/**
 * Template part for displaying the post meta inside The Loop.
 *
 * @package Primer
 */
?>

<div class="entry-meta">

	<span class="posted-meta">

		<?php printf( esc_html_x( '%1$s by %2$s', '1. post date, 2. author name', 'primer' ), primer_posted_on(), get_the_author_link() ); ?>

	</span>

	<span class="comments-number">

		<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>

			 &mdash;

			<a href="<?php echo get_comments_link(); ?>">

				<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'primer' ), esc_html__( '1 Comment', 'primer' ), esc_html_x( '% Comments', 'number of comments', 'primer' ) ); ?></span>

			</a>

		<?php endif; ?>

	</span>

</div><!-- .entry-meta -->
