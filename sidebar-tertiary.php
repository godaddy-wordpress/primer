<?php
/**
 * The sidebar containing the alternate widget area.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#sidebar-php
 *
 * @package Primer
 */

$layouts = array(
	'layout-three-column-default',
	'layout-three-column-center',
	'layout-three-column-reversed',
);

if ( ! is_active_sidebar( 'sidebar-2' ) || ! in_array( theme_layouts_get_layout(), $layouts ) ) {

	return;

}

?>

<div id="tertiary" class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'sidebar-2' ) ?>

</div><!-- #tertiary -->
