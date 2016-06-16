<?php
/**
 * Displays the site title.
 *
 * @package Primer
 */
?>

<div class="site-title-wrapper">

	<div class="site-title-wrapper-inner">

		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></h1>

		<div class="site-description"><?php bloginfo( 'description' ) ?></div>

	</div><!-- .site-info-inner -->

</div><!-- .site-title-wrapper -->
