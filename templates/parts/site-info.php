<?php
/**
 * Displays the footer site info.
 *
 * @package basis
 */
?>

<div class="site-info-wrapper">
	<div class="site-info">
		<div class="site-info-inner">

			<div class="site-info-text">
				<?php printf( __( 'Built on %1$s by %2$s.', 'basis' ), 'the <a href="https://basiswp.com" rel="designer">Basis Theme</a>', '<a href="https://upthemes.com/" rel="designer">UpThemes</a>' ); ?>
			</div><!-- .site-info-text -->
			
			<?php if( has_nav_menu( 'social' ) ): ?>
				<div class="social-menu">
					<?php wp_nav_menu(
						array(
							'theme_location' => 'social',
							'depth'          => 1,
							'fallback_cb'    => false
						) ); ?>
				</div><!-- .social-menu -->
			<?php endif; ?>

		</div><!-- .site-info-inner -->
	</div><!-- .site-info -->
</div><!-- .site-info-wrapper -->
