<?php
/**
 * Displays the social navigation.
 *
 * @package Primer
 */
?>

<?php if ( has_nav_menu( 'footer' ) ) : ?>

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

<?php endif; ?>
