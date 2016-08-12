<?php
/**
 * Displays the site header.
 *
 * @package Primer
 */
?>

<?php if ( primer_has_hero_image() && is_front_page() && is_active_sidebar( 'hero' ) ) : ?>

	<div class="hero">

		<?php dynamic_sidebar( 'hero' ); ?>

	</div>

<?php endif; ?>
