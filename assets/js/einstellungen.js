/**
 * Einstellungen: Logo je Haus der Wirkungsfamilie aus der Mediathek wählen.
 * Vanilla-JS, nutzt den Medien-Dialog von WordPress (wp.media).
 */
( function () {
	'use strict';
	var text = window.sttEinstellungen || {};
	var dialog = null;
	var zelle = null;

	function setzen( id, url ) {
		zelle.querySelector( '.stt-logo-id' ).value = id || 0;
		var vorschau = zelle.querySelector( '.stt-logo-vorschau' );
		vorschau.textContent = '';
		if ( url ) {
			var bild = document.createElement( 'img' );
			bild.src = url;
			bild.alt = '';
			bild.style.maxWidth = '120px';
			bild.style.maxHeight = '48px';
			vorschau.appendChild( bild );
		}
		zelle.querySelector( '.stt-logo-entfernen' ).hidden = ! id;
	}

	document.addEventListener( 'click', function ( e ) {
		var waehlen = e.target.closest( '.stt-logo-waehlen' );
		var entfernen = e.target.closest( '.stt-logo-entfernen' );
		if ( entfernen ) {
			zelle = entfernen.closest( '.stt-logo-wahl' );
			setzen( 0, '' );
			return;
		}
		if ( ! waehlen || ! window.wp || ! wp.media ) {
			return;
		}
		zelle = waehlen.closest( '.stt-logo-wahl' );
		if ( ! dialog ) {
			dialog = wp.media( { title: text.titel, button: { text: text.knopf }, library: { type: 'image' }, multiple: false } );
			dialog.on( 'select', function () {
				var bild = dialog.state().get( 'selection' ).first().toJSON();
				var url = bild.sizes && bild.sizes.medium ? bild.sizes.medium.url : bild.url;
				setzen( bild.id, url );
			} );
		}
		dialog.open();
	} );
}() );
