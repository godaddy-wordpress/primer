/* global jQuery, primer_hero_text_widget */

( function( $ ) {

	var link = {

		init: function( input ) {

			if ( ! ( $ && $.ui && $.ui.autocomplete ) ) {

				return;

			}

			var $input = $( input ),
			    cache, last;

			$input.on( 'keydown', function() {

				$input.removeAttr( 'aria-activedescendant' );

			} )
			.autocomplete( {

				source: function( request, response ) {

					if ( last === request.term ) {

						response( cache );

						return;

					}

					if ( /^https?:/.test( request.term ) || request.term.indexOf( '.' ) !== -1 ) {

						return response();

					}

					$.post(
						window.ajaxurl,
						{
							action: 'wp-link-ajax',
							page: 1,
							search: request.term,
							_ajax_linking_nonce: primer_hero_text_widget._ajax_linking_nonce
						},
						function( data ) {

							cache = data;
							response( data );

						},
						'json'
					);

					last = request.term;

				},
				focus: function( event, ui ) {

					$input.attr( 'aria-activedescendant', 'mce-wp-autocomplete-' + ui.item.ID );

					/*
					 * Don't empty the URL input field, when using the arrow keys to
					 * highlight items. See api.jqueryui.com/autocomplete/#event-focus
					 */
					event.preventDefault();

				},
				select: function( event, ui ) {

					$input.val( ui.item.permalink );

					// This is for the customizer.
					$input.trigger( 'change' );

					return false;

				},
				open: function() {

					$input.attr( 'aria-expanded', 'true' );

				},
				close: function() {

					$input.attr( 'aria-expanded', 'false' );

				},
				minLength: 2,
				position: {

					my: 'left top+2'

				}

			} ).autocomplete( 'instance' )._renderItem = function( ul, item ) {

				return $( '<li role="option" id="primer-hero-autocomplete-' + item.ID + '">' )
				       .append( '<span>' + item.title + '</span>&nbsp;<span style="float:right">' + item.info + '</span>' )
				       .appendTo( ul );

			};

			$input.attr( {
				'role': 'combobox',
				'aria-autocomplete': 'list',
				'aria-expanded': 'false',
				'aria-owns': $input.autocomplete( 'widget' ).attr( 'id' )
			} )
			.on( 'focus', function() {

				var inputValue = $input.val();

				/*
				 * Don't trigger a search if the URL field already has a link or is empty.
				 * Also, avoids screen readers announce `No search results`.
				 */
				if ( inputValue && ! /^https?:/.test( inputValue ) ) {

					$input.autocomplete( 'search' );

				}

			} )
			// Returns a jQuery object containing the menu element.
			.autocomplete( 'widget' )
			.attr( 'role', 'listbox' )
			.removeAttr( 'tabindex' ) // Remove the `tabindex=0` attribute added by jQuery UI.
			/*
			 * Looks like Safari and VoiceOver need an `aria-selected` attribute. See ticket #33301.
			 * The `menufocus` and `menublur` events are the same events used to add and remove
			 * the `ui-state-focus` CSS class on the menu items. See jQuery UI Menu Widget.
			 */
			.on( 'menufocus', function( event, ui ) {

				ui.item.attr( 'aria-selected', 'true' );

			} )
			.on( 'menublur', function() {

				/*
				 * The `menublur` event returns an object where the item is `null`
				 * so we need to find the active item with other means.
				 */
				$( this ).find( '[aria-selected="true"]' ).removeAttr( 'aria-selected' );

			} );

		} // end init.

	};

	function addAutocomplete() {

		$( '.primer-hero-text-widget input.link' ).each( function() {

			link.init( this );

		} );

	}

	$( document ).ready( addAutocomplete );
	$( document ).on( 'primer.widgets.change', addAutocomplete );

} )( jQuery );
