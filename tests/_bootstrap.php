<?php
// This is global bootstrap for autoloading

// So we know this is only a test
define( 'DOING_TESTS', true );

// Find the ABSPATH
$abspath = explode( 'wp-content', getcwd() );

// Load WordPress
require_once $abspath[0] . 'wp-load.php';

// Switch theme
switch_theme( 'primer' );

// Make sure these are installed for our tests
exec( 'wp core language install es_ES' );
exec( 'wp plugin install monster-widget --activate' );
