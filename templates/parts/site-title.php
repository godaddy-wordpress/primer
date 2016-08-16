<?php
/**
 * Displays the site title.
 *
 * @package Primer
 */
?>

<div class="site-title-wrapper">

	<?php if ( $has_logo = has_custom_logo() ) : ?>

		<?php the_custom_logo(); ?>

	<?php endif; ?>

	<?php if ( (bool) apply_filters( 'primer_print_site_title_text', true, $has_logo ) ) : ?>

	<h1 class="site-title">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

	</h1>

	<div class="site-description"><?php bloginfo( 'description' ); ?></div>

	<?php endif; ?>

</div><!-- .site-title-wrapper -->
