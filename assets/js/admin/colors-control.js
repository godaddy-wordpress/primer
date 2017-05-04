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

	/**
	 * Pull primary color from the selected image
	 * and  set it as the 'hero_background_color'.
	 *
	 * @uses  ColorThief
	 *
	 * @since NEXT
	 */
	function dynamicHeroBackgroundColor() {

		var $targetimage = $( '.current' ).find( 'img' ),
		    colorThief   = new ColorThief(),
		    rbgArr       = colorThief.getColor( $targetimage[0] ),
		    color        = convertColor( 'hex', 'rgb( ' + rbgArr[0] + ', ' + rbgArr[1] + ', ' + rbgArr[2] + ' )' );

		api( 'hero_background_color' ).set( color );

		wp.media.frame.off( 'cropped',     dynamicHeroBackgroundColor );
		wp.media.frame.off( 'skippedcrop', dynamicHeroBackgroundColor );

	}

	$( document ).on( 'click', '#header_image-button', function() {

		wp.media.frame.on( 'cropped',      dynamicHeroBackgroundColor );
		wp.media.frame.on( 'skippedcrop',  dynamicHeroBackgroundColor );

	} );

	api.HeaderTool.CurrentView = api.HeaderTool.CurrentView.extend( {

		setPlaceholder: function() {

			if ( ! $( '.current' ).find( 'img' ).length || 0 === $( '.current' ).find( 'img' ).width() ) {

				return;

			}

			dynamicHeroBackgroundColor( wp.customize );

		}

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
			rgbaColors[ setting ] = convertColor( 'rgb', hex );

		} );

		if ( _.isEqual( colors, colorSchemes[ scheme ].colors ) ) {

			api( 'color_scheme' ).set( scheme );

		}

		api.previewer.send( 'primer-update-colors-css', cssTemplate( colors ) );
		api.previewer.send( 'primer-update-colors-css-rgba', rgbaTemplate( rgbaColors ) );

	}


	/**
	 * Convert an rgb to hex, or hex to rgb
	 *
	 * @param  string returnType The type to return. rgb|hex.
	 * @param  string value      The value to convert. #123456|rbg(0,0,0)
	 *
	 * @return string            The converted hex/rgb value.
	 */
	function convertColor( returnType, value ) {

		if ( 'rgb' === returnType ) {

			hex = value.replace( '#', '' );

			var r   = parseInt( hex.substring( 0, 2 ), 16 ),
			    g   = parseInt( hex.substring( 2, 4 ), 16 ),
			    b   = parseInt( hex.substring( 4, 6 ), 16 );

			return r + ', ' + g + ', ' + b;

		}

		var rgb   = value.match( /^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i );

		return ( rgb && rgb.length === 4 ) ? '#' +
		        ( '0' + parseInt( rgb[1], 10 ).toString( 16 ) ).slice( -2 ) +
		        ( '0' + parseInt( rgb[2], 10 ).toString( 16 ) ).slice( -2 ) +
		        ( '0' + parseInt( rgb[3], 10 ).toString( 16 ) ).slice( -2 ) : false;

	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {

		api( setting, function( setting ) {

			setting.bind( updateCSS );

		} );

	} );

} )( wp.customize, jQuery );
