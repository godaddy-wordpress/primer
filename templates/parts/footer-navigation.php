<?php
/**
 * Displays the footer navigation.
 *
 * @package Primer
 */
?>

<nav class="footer-menu" role="navigation">

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
