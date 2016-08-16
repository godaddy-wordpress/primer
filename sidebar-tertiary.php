<?php
/**
 * The sidebar containing the alternate widget area.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#sidebar-php
 *
 * @package Primer
 * @since 1.0.0
 */

$layouts = array(
	'three-column-default',
	'three-column-center',
	'three-column-reversed',
);

if ( ! primer_layout_has_sidebar() || ! is_active_sidebar( 'sidebar-2' ) || ! in_array( primer_get_layout(), $layouts ) ) {

	return;

}

?>

<div id="tertiary" class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'sidebar-2' ); ?>

</div><!-- #tertiary -->
