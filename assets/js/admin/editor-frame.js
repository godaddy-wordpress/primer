( function( $ ) {

	var primerLayouts = primerEditorFrame.layouts;

	var primerBlockEditor = {

		toggleWidth: function() {

			if ( window.matchMedia( "(min-width: 961px)" ).matches ) {

				return $( 'body' ).removeClass( primerLayouts.join( ' ' ) ).addClass( $( 'input[name="primer-layout"]:checked' ).val() );

			}

			$( 'body' ).removeClass( primerLayouts.join( ' ' ) );

		},

	};

	$( window ).ready( primerBlockEditor.toggleWidth );
	$( window ).resize( primerBlockEditor.toggleWidth );
	$( 'body' ).on( 'change', $( 'input[name="primer-layout"]' ), primerBlockEditor.toggleWidth );

} )( jQuery );
