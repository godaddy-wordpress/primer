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

			<?php get_template_part( 'templates/parts/social-navigation' ); ?>

			<div class="site-info-text"><?php

				$theme_name = get_option( 'current_theme' );

				printf(
					esc_html_x( '%1$s theme by %2$s', '1. theme name link, 2. theme author link', 'primer' ),
					sprintf(
						'<a href="https://wordpress.org/themes/%s/" rel="designer">%s</a>',
						sanitize_key( $theme_name ),
						esc_html( $theme_name )
					),
					'<a href="https://www.godaddy.com/" rel="designer">GoDaddy</a>'
				);

			?></div><!-- .site-info-text -->

		</div><!-- .site-info-inner -->

	</div><!-- .site-info -->

</div><!-- .site-info-wrapper -->
