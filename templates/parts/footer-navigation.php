<?php
/**
 * Displays the footer navigation.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<nav class="footer-menu">

	<?php

	wp_nav_menu(
		array(
			'theme_location' => 'footer',
			'depth'          => 1,
			'fallback_cb'    => false,
		)
	);

	?>

</nav><!-- .footer-menu -->
