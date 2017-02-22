<?php
/**
 * Displays the site header.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="hero">

	<div class="hero-inner">

		<?php

		/**
		 * Fires inside the `.hero` element.
		 *
		 * @hooked primer_add_hero_content - 10
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_hero' );

		?>

	</div>

</div>
