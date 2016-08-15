<?php
/**
 * Displays the social navigation.
 *
 * @package Primer
 */
?>

<div class="social-menu">

	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'social',
			'depth'          => 1,
			'fallback_cb'    => false,
		)
	);
	?>

</div><!-- .social-menu -->
