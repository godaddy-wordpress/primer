/* global jQuery, primer_layouts_transport */
window.wp = window.wp || {};

( function( $ ) {

	var api = wp.customize;

	if ( typeof api !== 'undefined' ) {

		filter_api_preview_transport();

	}

	/**
	 * Filter api transport in depending on which layout the user clicks on.
	 */
	function filter_api_preview_transport() {

		var oldApiSetting = api.Setting;

		api.Setting = api.Setting.extend( {

			preview: function() {

				if ( 'layout' !== this.id ) {

					oldApiSetting.prototype.preview.apply( this, arguments );

					return;

				}

				var to        = arguments[0],
				    from      = arguments[1],
				    layouts   = primer_layouts_transport,
				    transport = this.transport;

				/**
				 * If we have a difference in transport strategy, refresh
				 */
				if ( layouts[ to ] !== layouts[ from ] ) {

					this.transport = 'refresh';

				}

				oldApiSetting.prototype.preview.apply( this, arguments );

				this.transport = transport;

			}

		} );

	}

	$( document ).ready( function() {

		$( 'input[name="primer-layout-override"]' ).change( function() {

			if ( '1' === $( this ).val() ) {

				$( '.primer-layout ul li' )
					.removeClass( 'disabled' )
					.addClass( 'active' )
					.find( 'input' )
					.prop( 'disabled', false );

				return;

			}

			$( '.primer-layout ul li' )
				.addClass('disabled')
				.find(':not(.global)')
				.removeClass( 'active' )
				.addClass( 'disabled' )
				.find( 'input' )
				.prop( 'disabled', true );

			$( '.primer-layout ul li.global input' )
				.prop( 'checked', true );

		} );

	} );

} )( jQuery );
