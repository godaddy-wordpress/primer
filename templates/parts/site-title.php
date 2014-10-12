<?php
/**
 * Displays the site title.
 *
 * @package Basis
 */
?>

<div class="site-info-container">

	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<div class="site-description"><?php bloginfo( 'description' ); ?></div>

</div><!-- .site-title-wrapper -->