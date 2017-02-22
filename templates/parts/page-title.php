<?php
/**
 * Displays page titles.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="page-title-container">

	<header class="page-header">

		<?php

		/**
		 * Fires before the page title element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_before_page_title' );

		?>

		<h1 class="page-title"><?php primer_the_page_title(); ?></h1>

		<?php

		/**
		 * Fires after the page title element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_after_page_title' );

		?>

	</header><!-- .entry-header -->

</div><!-- .page-title-container -->
