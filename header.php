<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Basis
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php do_action( 'basis_body_inside' ); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'basis' ); ?></a>

	<?php do_action( 'basis_header_before' ); ?>

	<header id="masthead" class="site-header" role="banner">

		<?php do_action( 'basis_header' ); ?>

	</header><!-- #masthead -->

	<?php do_action( 'basis_header_after' ); ?>

	<div id="content" class="site-content">
