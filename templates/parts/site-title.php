<?php
/**
 * Displays the site title.
 *
 * @package ascension
 */
?>

<div class="site-title-wrapper">

	<div class="site-title-wrapper-inner">

		<?php if( has_custom_logo() ): ?>

			<?php the_custom_logo(); ?>

		<?php else: ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>

		<?php endif; ?>

	</div><!-- .site-info-inner -->

</div><!-- .site-title-wrapper -->
