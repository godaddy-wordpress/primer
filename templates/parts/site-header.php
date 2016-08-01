<?php
/**
 * Displays the site header.
 *
 * @package Primer
 */
?>

<?php if ( get_header_image() ) : ?>

	<div class="header-image">

		<img src="<?php header_image() ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ) ?>">

	</div><!-- .header-image -->

<?php endif; ?>
