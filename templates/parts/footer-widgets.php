<?php
/**
 * Displays the footer widget areas.
 *
 * @package Primer
 * @since   1.0.0
 */

if ( $sidebars = primer_get_active_footer_sidebars() ) :

	?>
	<div class="footer-widget-area columns-<?php echo count( $sidebars ); ?>">

	<?php foreach ( $sidebars as $sidebar ) : ?>

		<div class="footer-widget">

			<?php dynamic_sidebar( $sidebar ); ?>

		</div>

	<?php endforeach; ?>

	</div>
	<?php

endif;
