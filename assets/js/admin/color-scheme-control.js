/* global colorSchemes */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api, $ ) {

	var cssTemplate      = wp.template( 'primer-color-scheme-css' ),
	    rgbaTemplate     = wp.template( 'primer-color-scheme-css-rgba' ),
	    colorSettings    = [],
			schemeisChanging = false;

	// Grab array keys from the default scheme.
	_.each( colorSchemes.default.colors, function( color, setting ) {

		colorSettings.push( setting );

	} );

	api.controlConstructor.select = api.Control.extend( {

		ready: function() {

			if ( 'color_scheme' !== this.id ) {

				return false;

			}

			// Update all swatches when the color scheme changes.
			this.setting.bind( 'change', function( scheme ) {

				if ( '_custom' === scheme ) {

					return;

				}

				$( '#customize-control-color_scheme select option[value="_custom"]' ).remove();

				schemeisChanging = true;

				_.each( colorSchemes[ scheme ].colors, function( color, setting ) {

					api( setting ).set( color );

					api.control( setting ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

				} );

				schemeisChanging = false;

			} );

		}

	} );

	// Generate the CSS for the current color scheme.
	function updateCSS() {

		var color_scheme = api( 'color_scheme' ),
		    scheme       = color_scheme();

		if ( ! schemeisChanging ) {

			scheme = 'default';

			$( '#customize-control-color_scheme select' ).append( $( '<option></option>' ).val('_custom' ).html( colorSchemes.custom.label ) );

			api( 'color_scheme' ).set( '_custom' );

		}

		var colors     = _.object( colorSettings, colorSchemes[ scheme ].colors ),
		    rgbaColors = {};

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {

			var hex = api( setting )();

			colors[ setting ]     = hex;
			rgbaColors[ setting ] = hex2rgb( hex );

		} );

		api.previewer.send( 'primer-update-color-scheme-css', cssTemplate( colors ) );
		api.previewer.send( 'primer-update-color-scheme-css-rgba', rgbaTemplate( rgbaColors ) );

	}

	// Convert a HEX color to RGB.
	function hex2rgb( hex ) {

		hex = hex.replace( '#', '' );

		var r   = parseInt( hex.substring( 0, 2 ), 16 ),
		    g   = parseInt( hex.substring( 2, 4 ), 16 ),
		    b   = parseInt( hex.substring( 4, 6 ), 16 );

		return r + ', ' + g + ', ' + b;

	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {

		api( setting, function( setting ) {

			setting.bind( updateCSS );

		} );

	} );

} )( wp.customize, jQuery );
