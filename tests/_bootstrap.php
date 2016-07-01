<?php

// Load WordPress first.
if ( ! defined( 'ABSPATH' ) ) {

	$abspath = explode( 'wp-content', __DIR__ );

	require_once $abspath[0] . 'wp-load.php';

}

// Define constants.
define( 'DOING_TESTS', true );
define( 'TESTS_DIR', __DIR__ );

// Activate the theme.
switch_theme( 'primer' );
