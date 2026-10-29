/* menue.js – mobiles Vollbild-Menü: aria-expanded, Escape schließt, Fokus bleibt im Menü, Rest wird inert. */
( function () {
	'use strict';

	var knopf = document.querySelector( '.menueknopf' );
	var menue = document.getElementById( 'mobilmenue' );
	if ( ! knopf || ! menue ) {
		return;
	}

	var zu = menue.querySelector( '.mobilmenue__zu' );
	var wurzel = document.documentElement;
	var breite = window.matchMedia( '(min-width: 1060px)' );

	function rest() {
		return Array.prototype.filter.call( document.body.children, function ( el ) {
			return el !== menue && el.tagName !== 'SCRIPT';
		} );
	}

	function fokussierbar() {
		return menue.querySelectorAll( 'a[href], button:not([disabled])' );
	}

	function oeffnen() {
		menue.hidden = false;
		knopf.setAttribute( 'aria-expanded', 'true' );
		wurzel.classList.add( 'menue-offen' );
		rest().forEach( function ( el ) {
			el.inert = true;
		} );
		zu.focus();
	}

	function schliessen( fokusZurueck ) {
		menue.hidden = true;
		knopf.setAttribute( 'aria-expanded', 'false' );
		wurzel.classList.remove( 'menue-offen' );
		rest().forEach( function ( el ) {
			el.inert = false;
		} );
		if ( fokusZurueck ) {
			knopf.focus();
		}
	}

	knopf.addEventListener( 'click', oeffnen );
	zu.addEventListener( 'click', function () {
		schliessen( true );
	} );

	menue.addEventListener( 'keydown', function ( ereignis ) {
		if ( 'Escape' === ereignis.key ) {
			schliessen( true );
			return;
		}
		if ( 'Tab' !== ereignis.key ) {
			return;
		}
		var liste = fokussierbar();
		var erstes = liste[ 0 ];
		var letztes = liste[ liste.length - 1 ];
		if ( ereignis.shiftKey && document.activeElement === erstes ) {
			ereignis.preventDefault();
			letztes.focus();
		} else if ( ! ereignis.shiftKey && document.activeElement === letztes ) {
			ereignis.preventDefault();
			erstes.focus();
		}
	} );

	// Verweise auf Sprungmarken derselben Seite schließen das Menü.
	menue.addEventListener( 'click', function ( ereignis ) {
		var link = ereignis.target.closest( 'a[href^="#"]' );
		if ( link ) {
			schliessen( false );
		}
	} );

	// Wird das Fenster breit genug, ist das Vollbild-Menü überflüssig.
	var beiBreite = function ( e ) {
		if ( e.matches && ! menue.hidden ) {
			schliessen( false );
		}
	};
	if ( breite.addEventListener ) {
		breite.addEventListener( 'change', beiBreite );
	}
}() );
