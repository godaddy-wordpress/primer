<?php
/**
 * Displays the site header.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="hero">

	<?php

	/**
	 * Fires inside the `.hero` element but before the `.hero-inner` element.
	 *
	 * @since 1.7.0
	 */
	do_action( 'primer_pre_hero' );

	?>

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
