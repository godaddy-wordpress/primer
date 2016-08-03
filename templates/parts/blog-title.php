<?php
/**
 * Template part for displaying the blog title.
 *
 * @package Primer
 */
?>

<div class="page-title-container">

	<header class="page-header">

		<?php
		/**
		 * Fires before the blog title element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_before_blog_title' );
		?>

			<h1 class="page-title"><?php esc_html_e( 'Blog', 'primer' ) ?></h1>

		<?php
		/**
		 * Fires after the blog title element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_after_blog_title' );
		?>

	</header><!-- .entry-header -->

</div><!-- .page-title-container -->