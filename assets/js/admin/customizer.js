/* global jQuery, colorsSettings */
/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $, api ) {

	var $style     = $( '#primer-colors-css' ),
	    $rgbaStyle = $( '#primer-colors-css-rgba' ),
	    $body      = $( 'body' );

	if ( ! $style.length ) {

		$style = $( 'head' ).append( '<style type="text/css" id="primer-colors-css" />' ).find( '#primer-colors-css' );

	}

	if ( ! $rgbaStyle.length ) {

		$rgbaStyle = $( 'head' ).append( '<style type="text/css" id="primer-colors-css-rgba" />' ).find( '#primer-colors-css-rgba' );

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

			$body.toggleClass( 'custom-background-image', '' !== to );

		} );

	} );

	// Color scheme.
	api.bind( 'preview-ready', function() {

		api.preview.bind( 'primer-update-colors-css', function( css ) {

			$style.html( css );

		} );

		api.preview.bind( 'primer-update-colors-css-rgba', function( rgbaCSS ) {

			$rgbaStyle.html( rgbaCSS );

		} );

	} );

	// Custom layouts.
	api( 'layout', function( value ) {

		value.bind( function( to ) {

			var classes = $body.prop( 'class' ).replace( /layout-[a-zA-Z0-9_-]*/g, '' );

			$body.prop( 'class', $.trim( classes ) ).addClass( 'layout-' + to );

		} );

	} );

	api( 'page_width', function( value ) {

		value.bind( function( to ) {

			switch ( to ) {

				case 'fixed' :

					$( 'body' ).removeClass( 'no-max-width' );

					break;

				case 'fluid' :

					$( 'body' ).addClass( 'no-max-width' );

					break;

			}

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

	api( 'hero_background_color', function( value ) {

		value.bind( function( to ) {

			var $selector = $( colorsSettings.hero_background_selector ),
			    color     = 'rgb(' + hex2rgb( to ) + ')',
			    alpha     = api( 'hero_image_color_overlay' )();

			updateRgbaColor( color, alpha, $selector );

		} );

	} );

	api( 'hero_image_color_overlay', function( value ) {

		value.bind( function( alpha ) {

			var $selector = $( colorsSettings.hero_background_selector ),
			    color     = 'rgb(' + hex2rgb( api( 'hero_background_color' )() ) + ')';

			updateRgbaColor( color, alpha, $selector );

		} );

	} );

	function updateRgbaColor( color, alpha, $selector ) {

		alpha = alpha * 0.01;

		if ( -1 === color.indexOf( 'a' ) ) {

			color = color.replace( ')', ',)' ).replace( 'rgb', 'rgba' );

		}

		$selector.css( 'color', color.replace( /^(.*,).*(\).*)$/, '$1' + alpha + '$2' ) );

	}

	// Convert a HEX color to RGB.
	function hex2rgb( hex ) {

		hex = hex.replace( '#', '' );

		var r   = parseInt( hex.substring( 0, 2 ), 16 ),
		    g   = parseInt( hex.substring( 2, 4 ), 16 ),
		    b   = parseInt( hex.substring( 4, 6 ), 16 );

		return r + ', ' + g + ', ' + b;

	}

} )( jQuery, wp.customize );
