<?php
/**
 * Displays the site header.
 *
 * @package Primer
 */

/**
 * Filter the hero element style attribute.
 *
 * @since 1.0.0
 *
 * @var string
 */
$hero_style = (string) apply_filters( 'primer_hero_style_attr', '' );
?>

<div class="hero"<?php if ( $hero_style ) : ?> style="<?php echo $hero_style; // xss ok ?>"<?php endif; ?>>

	<?php
	/**
	 * Fires inside the `.hero` element.
	 *
	 * @since 1.0.0
	 */
	do_action( 'primer_hero' );
	?>

</div>
