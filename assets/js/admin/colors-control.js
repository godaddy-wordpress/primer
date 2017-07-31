/* global colorSchemes, jQuery, wp */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api, $ ) {

	var cssTemplate      = wp.template( 'primer-colors-css' ),
	    rgbaTemplate     = wp.template( 'primer-colors-css-rgba' ),
	    colorSettings    = [],
	    oldScheme        = null,
	    schemeIsChanging = false;

	// Grab array keys from the default scheme.
	_.each( colorSchemes.default.colors, function( color, setting ) {

		colorSettings.push( setting );

	} );

	api.controlConstructor.select = api.Control.extend( {

		ready: function() {

			if ( 'color_scheme' !== this.id ) {

				return false;

			}

			var scheme = api( this.id )();

			if ( '_custom' !== scheme ) {

				$( '#customize-control-color_scheme select option[value="_custom"]' ).remove();

			}

			// Update all swatches when the color scheme changes.
			this.setting.bind( 'change', function( scheme ) {

				if ( '_custom' === scheme ) {

					return;

				}

				$( '#customize-control-color_scheme select option[value="_custom"]' ).remove();

				if ( ! $( '#customize-control-display_header_text' ).find( 'input' ).is( ':checked' ) ) {

					delete colorSchemes[ scheme ].colors.header_textcolor;
					delete colorSchemes[ scheme ].colors.tagline_text_color;

				}

				schemeIsChanging = true;

				_.each( colorSchemes[ scheme ].colors, function( color, setting ) {

					var api_setting = api( setting );

					if ( 'undefined' === typeof api_setting ) {

						return;

					}

					api_setting.set( color );

					api.control( setting ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

				} );

				schemeIsChanging = false;

			} );

		}

	} );

	// Generate the CSS for the current color scheme.
	function updateCSS() {

		var color_scheme = api( 'color_scheme' ),
		    scheme       = color_scheme();

		if ( ! schemeIsChanging ) {

			if ( '_custom' !== scheme ) {

				oldScheme = scheme;

				$( '#customize-control-color_scheme select' )
					.append( $( '<option></option>' )
						.val( '_custom' )
						.html( colorSchemes._custom.label )
					);

				api( 'color_scheme' ).set( '_custom' );

			}

			scheme = _.isNull( oldScheme ) ? 'default' : oldScheme;

		}

		var colors     = _.clone( colorSchemes[ scheme ].colors ),
		    rgbaColors = {};

		// Merge in color scheme overrides.
		_.each( colors, function( color, setting ) {

			var hex = api( setting );

			if ( 'undefined' === typeof hex ) {

				return;

			}

			hex = hex();

			colors[ setting ]     = hex;
			rgbaColors[ setting ] = hex2rgb( hex );

		} );

		if ( _.isEqual( colors, colorSchemes[ scheme ].colors ) ) {

			api( 'color_scheme' ).set( scheme );

		}

		api.previewer.send( 'primer-update-colors-css', cssTemplate( colors ) );
		api.previewer.send( 'primer-update-colors-css-rgba', rgbaTemplate( rgbaColors ) );

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
