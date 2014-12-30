<?php
/**
 * Displays the footer site info.
 *
 * @package Basis
 */
?>

<div class="site-info-wrapper">
	<div class="site-info">
		<div class="site-info-inner">

			<div class="site-info-text">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'basis' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'basis' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'basis' ), 'Basis', '<a href="https://upthemes.com/" rel="designer">UpThemes</a>' ); ?>
			</div><!-- .site-info-text -->

			<div class="social-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'social' ) ); ?>
			</div><!-- .social-menu -->

		</div><!-- .site-info-inner -->
	</div><!-- .site-info -->
</div><!-- .site-info-wrapper -->