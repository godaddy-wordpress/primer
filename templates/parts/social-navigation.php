<?php
/**
 * Displays the social navigation.
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<nav class="social-menu">

	<?php

	wp_nav_menu(
		array(
			'theme_location' => 'social',
			'depth'          => 1,
			'fallback_cb'    => false,
		)
	);

	?>

</nav><!-- .social-menu -->
