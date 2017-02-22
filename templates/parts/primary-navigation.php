<?php
/**
 * Displays the primary navigation.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="main-navigation-container">

	<?php

	/**
	 * Fires inside the `<div class="main-navigation-container">` element.
	 *
	 * @hooked primer_add_mobile_menu - 10
	 *
	 * @since 1.0.0
	 */
	do_action( 'primer_before_site_navigation' );

	?>

	<nav id="site-navigation" class="main-navigation">

		<?php

		/**
		 * Fires inside the `<nav id="site-navigation" class="main-navigation">` element.
		 *
		 * @hooked primer_add_primary_menu - 10
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_site_navigation' );

		?>

	</nav><!-- #site-navigation -->

	<?php

	/**
	 * Fires after the `<nav id="site-navigation" class="main-navigation">` element.
	 *
	 * @since 1.0.0
	 */
	do_action( 'primer_after_site_navigation' );

	?>

</div>
