<?php
/**
 * Displays the primary navigation.
 *
 * @package Primer
 */
?>

<div class="main-navigation-container">

	<div class="menu-toggle" id="menu-toggle">

		<div></div>
		<div></div>
		<div></div>

	</div><!-- #menu-toggle -->

	<nav id="site-navigation" class="main-navigation" role="navigation">

		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

	</nav><!-- #site-navigation -->

</div>
