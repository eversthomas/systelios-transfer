/* Setzt den Fokus auf die Fehlerübersicht, damit Screenreader und Tastatur sie sofort erreichen. */
( function () {
	'use strict';
	var fehler = document.getElementById( 'stt-kontakt-fehler' );
	if ( fehler ) {
		fehler.focus();
	}
}() );
