<?php
/**
 * Displays the primary navigation.
 *
 * @package Primer
 */
?>

<div class="main-navigation-container">

	<nav id="site-navigation" class="main-navigation" role="navigation">

		<div class="menu-toggle" id="menu-toggle">
			<div></div>
			<div></div>
			<div></div>
		</div>

		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ) ?>

	</nav><!-- #site-navigation -->

</div>
