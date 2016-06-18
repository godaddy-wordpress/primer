<?php
/**
 * Displays the footer site info.
 *
 * @package Primer
 */
?>

<div class="site-info-wrapper">

	<div class="site-info">

		<div class="site-info-inner">

			<div class="site-info-text">

				<?php printf( _x( 'Built with %1$s by %2$s.', '1. theme name link, 2. theme author link', 'primer' ), '<a href="https://wordpress.org/themes/primer/" rel="designer">Primer</a>', '<a href="https://www.godaddy.com/" rel="designer">GoDaddy</a>' ) ?>

			</div><!-- .site-info-text -->

			<?php if ( has_nav_menu( 'social' ) ) : ?>

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

			<?php endif; ?>

		</div><!-- .site-info-inner -->

	</div><!-- .site-info -->

</div><!-- .site-info-wrapper -->
