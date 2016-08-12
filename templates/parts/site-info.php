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

			<div class="site-info-text">

				<?php do_action( 'primer_site_info' ); ?>

			</div><!-- .site-info-text -->

		</div><!-- .site-info-inner -->

	</div><!-- .site-info -->

</div><!-- .site-info-wrapper -->
