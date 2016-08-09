<?php
/**
 * Displays the site header.
 *
 * @package Primer
 */
?>

<?php if ( has_header_image() ) : ?>

	<div class="hero" style="background-image: url('<?php header_image(); ?>');"></div>

<?php endif; ?>
