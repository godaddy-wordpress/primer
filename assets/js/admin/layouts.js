/* global jQuery */
window.wp = window.wp || {};

( function( $ ) {

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
				.prop( 'checked', true )
				.trigger( 'change' );

		} );

		$( 'input[name="primer-layout"]' ).change( function() {
			toggleEditorWidth( $( this ).val() );
		} );

	} );

	$( document ).on( 'DOMContentLoaded', function() {
		toggleEditorWidth( primerLayouts.selected );
	} );

} )( jQuery );

function toggleEditorWidth( pageWidth ) {

	pageWidth = pageWidth.indexOf( 'wide' ) >= 0 ? 'wide' : ( pageWidth.indexOf( 'narrow' ) >= 0 || pageWidth.indexOf( 'three-column' ) >= 0 ? 'narrow' : 'default' );

	$( '.edit-post-visual-editor, .edit-post-text-editor' )
		.removeClass( 'default wide narrow' )
		.addClass( pageWidth );

}
