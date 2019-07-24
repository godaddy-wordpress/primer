<?php
/**
 * Display the mobile menu
 *
 * @todo Should this not use a <button> instead of a <div>?
 *
 * @package Primer
 * @since   1.0.0
 */

?>

<div class="menu-toggle" id="menu-toggle" role="button" tabindex="0"
	<?php if ( primer_is_amp() ) : ?>
		on="tap:menu-toggle.toggleClass(class='open'),site-navigation.toggleClass(class='open')"
	<?php endif; ?>
>
	<div></div>
	<div></div>
	<div></div>
</div><!-- #menu-toggle -->
