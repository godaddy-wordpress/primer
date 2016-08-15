<?php
/**
 * Displays the primary navigation.
 *
 * @package Primer
 */
?>

<div class="main-navigation-container">

	<?php
	/**
	 * Fires inside the `<div class="main-navigation-container">` element.
	 */
	do_action( 'primer_before_site_navigation' );
	?>

	<nav id="site-navigation" class="main-navigation" role="navigation">

		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

	</nav><!-- #site-navigation -->

</div>
