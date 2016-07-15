/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	var style = $( '#primer-color-scheme-css' ),
	    api   = wp.customize;

	if ( ! style.length ) {

		style = $( 'head' ).append( '<style type="text/css" id="primer-color-scheme-css" />' ).find( '#primer-color-scheme-css' );

	}

	// Site title.
	api( 'blogname', function( value ) {

		value.bind( function( to ) {

			$( '.site-title a' ).text( to );

		} );

	} );

	// Site tagline.
	api( 'blogdescription', function( value ) {

		value.bind( function( to ) {

			$( '.site-description' ).text( to );

		} );

	} );

	// Custom background image.
	api( 'background_image', function( value ) {

		value.bind( function( to ) {

			$( 'body' ).toggleClass( 'custom-background-image', '' !== to );

		} );

	} );

	// Color scheme.
	api.bind( 'preview-ready', function() {

		api.preview.bind( 'update-color-scheme-css', function( css ) {

			style.html( css );

		} );

	} );

	// Header text color.
	api( 'header_textcolor', function( value ) {

		value.bind( function( to ) {

			if ( 'blank' === to ) {

				$( '.site-title, .site-description' )
					.css( {
						'clip': 'rect(1px, 1px, 1px, 1px)',
						'position': 'absolute'
					} );

			} else {

				$( '.site-title, .site-description' )
					.css( {
						'clip': 'auto',
						'position': 'relative'
					} );

			}

		} );

	} );

} )( jQuery );
