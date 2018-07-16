/**
 * Customizer Font Select Preview
 *
 * @since 1.8.3
 */
( function( $ ) {

	var PrimerFonts = function( element, options ) {

		this.element          = element;
		this.customSelectLink = null;
		this.customDropdown   = null;

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

			this.element.find( 'option' ).each( function() {

				var selected = $( this ).is( ':selected' ) ? ' class="primer-font-active"' : '';

				primerFilterOptionsHTML += '<li class="' + self.fontNameToClass( $( this ).text() ) + '" data-value="' + $( this ).attr( 'value' ) + '"' + selected +'>' + $( this ).text() + '</li>';

			} );

			this.element.after( '<a href="#" class="primer-font-select">' + '<span class="primer-filter-text"></span>' + '</a>' + '<ul class="primer-font-options">' + primerFilterOptionsHTML + '</ul>' );

			this.customSelectLink = this.element.next( '.primer-font-select' );

			this.customDropdown = this.customSelectLink.next( '.primer-font-options' );

			// Populate the fields with correct values on load.
			if ( $selectedOption.length ) {

				var selectedValue = $selectedOption.text().replace( / *\([^)]*\) */g, '' );

				this.customSelectLink.find( '.primer-filter-text' ).text( selectedValue );

				$dropdownSelectedOption = this.customDropdown.find( 'li[data-value="' + selectedValue + '"]' );

				this.customSelectLink.find( '.primer-filter-text' ).addClass( $dropdownSelectedOption.attr( 'class' ) ).data( 'gf-class', $dropdownSelectedOption.attr( 'class' ) );

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

				return;

			}

			this.customDropdown.show().addClass( 'primer-font-open' );

			$( event.target ).hide();

		},

		/**
		 * Select a font.
		 *
		 * @param string event The event taking place.
		 */
		selectFont: function( event ) {

			var optionText    = $( event.target ).text().replace( / *\([^)]*\) */g, '' ),
			    $mainText     = this.customSelectLink.find( '.primer-filter-text' ),
			    $activeSelect = this.element.find( 'option[value="' + optionText + '"]' ),
			    mainTextClass = $mainText.data( 'gf-class' );

			$( event.target ).siblings().removeClass( 'primer-font-active' );

			$mainText.removeClass( mainTextClass ).addClass( $( event.target ).attr( 'class' ) ).data( 'gf-class', $( event.target ).attr( 'class' ) );

			$( event.target ).addClass( 'primer-font-active' );

			this.closeDropdown();

			if ( ! $activeSelect.length ) {

				this.element.val( 'none' ).trigger( 'change' );

			} else {

				this.element.val( optionText ).trigger( 'change' );

			}

		},

		/**
		 * Close the font select dropdown.
		 */
		closeDropdown: function() {

			this.customSelectLink.find( '.primer-filter-text' ).show();

			this.customDropdown.hide().removeClass( 'primer-font-open' );

		},

		/**
		 * Convert a font name to a class.
		 *
		 * @param  string text The text to convert.
		 *
		 * @return string      Font name slugified and prefixed with 'primer-font-'
		 */
		fontNameToClass: function( text ) {

			text = text.replace( / *\([^)]*\) */g, '' );

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

	$( document ).ready( function() {

		var customFontSections = [
			'site_title_font',
			'navigation_font',
			'heading_font',
			'primary_font',
			'secondary_font',
		];

		for ( var i = 0, l = customFontSections.length; i < l; i++ ) {

			$( 'select[data-customize-setting-link="' + customFontSections[i] + '"]' ).primerFonts( {} );

		}

	} );

} )( jQuery );
