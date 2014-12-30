<?php
/**
 * The sidebar containing the alternate widget area.
 *
 * @package Basis
 */

/**
 * Get the activate theme layout.
 */
$layout = theme_layouts_get_layout();

if ( ! is_active_sidebar( 'sidebar-2' ) || ( $layout !== 'layout-three-column-default' && $layout !== 'layout-three-column-center' && $layout !== 'layout-three-column-reversed' ) ) {
	return;
}
?>

<div id="tertiary" class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'sidebar-2' ); ?>

</div><!-- #tertiary -->