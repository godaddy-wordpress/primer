<?php
/**
 * Displays the site header.
 *
 * @package Primer
 */
?>

<?php if ( primer_has_hero_image() ) : ?>

	<div class="hero" style="background-image: url('<?php echo esc_url( primer_get_hero_image() ); ?>');">

		<?php
		/**
		 * Fires inside the `.hero` element.
		 *
		 * @since 1.0.0
		 */
		do_action( 'primer_hero' );
		?>

	</div>

<?php endif; ?>
