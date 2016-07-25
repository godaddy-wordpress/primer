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

				<?php printf( esc_html_x( '%1$s theme by %2$s', '1. theme name link, 2. theme author link', 'primer' ), '<a href="https://wordpress.org/themes/primer/" rel="designer">Primer</a>', '<a href="https://www.godaddy.com/" rel="designer">GoDaddy</a>' ) ?>

			</div><!-- .site-info-text -->

			<?php get_template_part( 'templates/parts/social-navigation' ); ?>

		</div><!-- .site-info-inner -->

	</div><!-- .site-info -->

</div><!-- .site-info-wrapper -->
