<?php

// Take a SQL backup first.
exec( 'wp db export ' . TESTS_DIR . '/_data/dump.sql' );

// Install a few things.
exec( 'wp core language install es_ES' );
exec( 'wp plugin install monster-widget --activate' );

// Generate some dummy data.
exec( 'wp post generate --count=50' );
exec( 'wp post create --post_type=page --post_title="Front Page"' );
exec( 'wp post create --post_type=page --post_title="Blog"' );
exec( 'wp post create --post_type=page --post_title="Contact"' );
exec( 'wp post create ' TESTS_DIR . '/_data/html-elements.txt --post_type=page --post_title="HTML Elements"' );

// Set various options.
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', get_page_by_path( 'front-page' )->ID );
update_option( 'page_for_posts', get_page_by_path( 'blog' )->ID );
update_option( 'page_for_posts', get_page_by_path( 'blog' )->ID );
update_option( 'permalink_structure', '/%postname%/' );
