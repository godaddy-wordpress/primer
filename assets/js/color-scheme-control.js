/* global colorSchemes, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {

	var cssTemplate   = wp.template( 'primer-color-scheme' ),
	    colorSettings = [];

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

				_.each( colorSchemes[ scheme ].colors, function( color, setting ) {

					api( setting ).set( color );

					api.control( setting ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', color )
						.wpColorPicker( 'defaultColor', color );

				} );

			} );

		}

	} );

	// Generate the CSS for the current color scheme.
	function updateCSS() {

		var scheme = api( 'color_scheme' )(),
		    colors = _.object( colorSettings, colorSchemes[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {

			colors[ setting ] = api( setting )();

		} );

		api.previewer.send( 'update-color-scheme-css', cssTemplate( colors ) );

	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {

		api( setting, function( setting ) {

			setting.bind( updateCSS );

		} );

	} );

} )( wp.customize );
