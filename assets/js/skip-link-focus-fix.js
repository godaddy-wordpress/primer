( function() {

	'use strict';

	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    isIE     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( isWebkit || isOpera || isIE ) && document.getElementById && window.addEventListener ) {

		window.addEventListener( 'hashchange', function() {

			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {

				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {

					element.tabIndex = -1;

				}

				element.focus();

			}

		}, false );

	}

} )();
