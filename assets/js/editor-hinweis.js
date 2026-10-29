/* editor-hinweis.js – Hinweis im Block-Editor bei Seiten, die noch den mitgelieferten Inhalt zeigen. */
( function ( wp, daten ) {
	'use strict';

	if ( ! daten ) {
		return;
	}

	wp.domReady( function () {
		wp.data.dispatch( 'core/notices' ).createWarningNotice( daten.text, {
			id: 'stt-fallback-hinweis',
			isDismissible: false,
			actions: [ { label: daten.knopf, url: daten.url } ],
		} );
	} );
}( window.wp, window.sttHinweis ) );
