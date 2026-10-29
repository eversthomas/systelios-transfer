/* editor.js – Anpassungen im Block-Editor (Beschriftung, Block-Stile). */
( function ( wp ) {
	'use strict';

	// Textauszug heißt bei Seiten „Einleitung (Seitenkopf)“.
	wp.i18n.setLocaleData(
		{
			Excerpt: [ 'Einleitung (Seitenkopf)' ],
			'Write an excerpt (optional)': [ 'Einleitung für den Seitenkopf (optional)' ],
		},
		'default'
	);

	// Doppelte Block-Stile des Kerns entfernen; das Theme bietet eigene (bloecke.php).
	wp.domReady( function () {
		wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
		wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );
	} );
}( window.wp ) );
