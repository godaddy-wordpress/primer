/**
 * Customizer Font Select Preview
 *
 * @since NEXT
 */
( function( $ ) {

	var PrimerFonts = function( element, options ) {

		this.element             = element;
		this.customSelectLink  = null;
		this.customDropdown     = null;

		this.options = jQuery.extend( {}, this.defaults, options );

		this.createDropdown();

	};

	PrimerFonts.prototype = {

		/**
		 * Render the dropdown.
		 */
		createDropdown: function() {

			var primerFilterOptionsHTML  = '',
			    self                     = this,
			    $selectedOption          = this.element.find( ':selected' ),
			    $dropdownSelectedOption;

			this.element.hide().addClass( 'primer-font-select' );

			this.element.change( $.proxy( self.changeFont, self ) );

			this.element.find( 'option' ).each( function() {

				var selected = $( this ).is( ':selected' ) ? ' class="primer-font-active"' : '';

				primerFilterOptionsHTML += '<li class="' + self.fontNameToClass( $( this ).text() ) + '" data-value="' + $( this ).attr( 'value' ) + '"' + selected +'>' + $( this ).text() + '</li>';

			} );

			this.element.after( '<a href="#" class="primer-font-select">' + '<span class="primer-filter-text"></span>' + '</a>' + '<ul class="primer-font-options">' + primerFilterOptionsHTML + '</ul>' );

			this.customSelectLink = this.element.next( '.primer-font-select' );

			this.customDropdown = this.customSelectLink.next('.primer-font-options');

			if ( $selectedOption.length ) {

				this.customSelectLink.find( '.primer-filter-text' ).text( $selectedOption.text() );

				$dropdownSelectedOption = this.customDropdown.find( 'li[data-value="' + $selectedOption.text() + '"]' );

				this.customSelectLink.find( '.primer-filter-text' ).addClass( $dropdownSelectedOption.attr( 'class' ) ).data( 'gf-class', $dropdownSelectedOption.attr('class') );

				$dropdownSelectedOption.addClass( 'primer-font-active' );

			}

			this.customSelectLink.click( $.proxy( self.openDropdown, self ) );

			this.customDropdown.find( 'li' ).click( $.proxy( self.selectFont, self ) );

		},

		/**
		 * Open the font select.
		 *
		 * @param string event The event taking place.
		 */
		openDropdown: function( event ) {

			if ( this.customDropdown.hasClass( 'primer-font-open' ) ) {

				return false;

			}

			this.customDropdown.show().addClass( 'primer-font-open' );

			$( event.target ).hide();

			return false;

		},

		/**
		 * Select a font.
		 *
		 * @param string event The event taking place.
		 */
		selectFont: function( event ) {

			var $mainText     = this.customSelectLink.find( '.primer-filter-text' ),
			    $activeSelect = this.element.find( 'option[value="' + $( event.target ).text() + '"]' ),
			    mainTextClass = $mainText.data( 'gf-class' );

			if ( $( event.target ).hasClass( 'primer-font-active' ) ) {

				this.closeDropdown();

				return false;

			}

			$( event.target ).siblings().removeClass( 'primer-font-active' );

			$mainText.removeClass( mainTextClass ).addClass( $( event.target ).attr( 'class' ) ).data( 'gf-class', $( event.target ).attr( 'class' ) );

			$( event.target ).addClass( 'primer-font-active' );

			this.closeDropdown();

			if ( ! $activeSelect.length ) {

				this.element.val( 'none' ).trigger( 'change' );

			} else {

				this.element.val( $( event.target ).text() ).trigger( 'change' );

			}

			return false;

		},

		/**
		 * Close the font select dropdown.
		 */
		closeDropdown: function() {

			this.customSelectLink.find( '.primer-filter-text' ).show();

			this.customDropdown.hide().removeClass( 'primer-font-open' );

		},

		/**
		 * Select a different font.
		 */
		changeFont: function() {

			var self               = this,
			    activeFontValue    = self.element.find( 'option:selected' ).val(),
			    $option            = this.customDropdown.find( 'li[data-value="' + activeFontValue + '"]' ),
			    $mainText          = self.customSelectLink.find( '.primer-filter-text' );

			// Set the correct dropdown values on initial load.
			if ( this.customDropdown.find( 'li.primer-font-active' ).data( 'value' ) !== activeFontValue ) {

				this.customDropdown.find( 'li' ).removeClass( 'primer-font-active' );

				$mainText.removeClass( $mainText.data( 'gf-class' ) ).addClass( $option.attr( 'class' ) ).data( 'gf-class', $option.attr( 'class' ) );

				$option.addClass( 'primer-font-active' );

			}

		},

		/**
		 * Convert a font name to a class.
		 *
		 * @param  string text The text to convert.
		 *
		 * @return string      Font name slugified and prefixed with 'primer-font-'
		 */
		fontNameToClass: function( text ) {

			return 'primer-font-' + text.replace( / /g,'-' ).toLowerCase();

		}

	};

	/**
	 * Convert a dropdown into a custom font preview dropdown.
	 *
	 * @param  object options Otions.
	 *
	 * @return object
	 */
	$.fn.primerFonts = function( options ) {

		new PrimerFonts( this, options );

		return this;

	};

	// Initialize font dropdowns.
	$( document ).ready( function() {

		var fontNames = [
			'site_title_font',
			'navigation_font',
			'heading_font',
			'primary_font',
			'secondary_font',
		];

		for ( var i = 0, l = fontNames.length; i < l; i++ ) {

			$( 'select[data-customize-setting-link="' + fontNames[i] + '"]' ).primerFonts( {} );

		}

	} );

} )( jQuery );
