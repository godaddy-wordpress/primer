<?php
/**
 * Displays the site header.
 *
 * @package Primer
 */
?>

<?php if ( primer_has_header_image() ) : ?>

	<div class="hero" style="background-image: url('<?php echo esc_url( primer_get_header_image() ); ?>');"></div>

<?php endif; ?>
