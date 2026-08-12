/**
 * Client-side, display-only GHS -> USD price toggle.
 * All checkout/order totals still process in GHS regardless of what's
 * shown here — this only rewrites the text of WooCommerce price
 * elements already rendered in GHS.
 */
( function () {
	'use strict';

	if ( typeof morCurrency === 'undefined' ) {
		return;
	}

	var STORAGE_KEY = 'mor_currency_display';
	var PRICE_SELECTOR = '.woocommerce-Price-amount.amount, .amount';

	function parseGhsAmount( text ) {
		var match = text.replace( /,/g, '' ).match( /(\d+(\.\d+)?)/ );
		return match ? parseFloat( match[ 1 ] ) : null;
	}

	function formatUsd( amount ) {
		return morCurrency.usdSymbol + ( amount * parseFloat( morCurrency.rate ) ).toFixed( 2 );
	}

	function collectPriceNodes() {
		var nodes = document.querySelectorAll( PRICE_SELECTOR );
		nodes.forEach( function ( node ) {
			if ( node.dataset.morGhsText ) {
				return; // already indexed
			}
			var value = parseGhsAmount( node.textContent );
			if ( value === null ) {
				return;
			}
			node.dataset.morGhsText = node.textContent;
			node.dataset.morGhsValue = value;
		} );
	}

	function applyDisplay( mode ) {
		collectPriceNodes();
		var nodes = document.querySelectorAll( PRICE_SELECTOR + '[data-mor-ghs-text]' );
		nodes.forEach( function ( node ) {
			if ( 'usd' === mode ) {
				node.textContent = formatUsd( parseFloat( node.dataset.morGhsValue ) );
			} else {
				node.textContent = node.dataset.morGhsText;
			}
		} );

		document.querySelectorAll( '.currency-switcher [data-currency]' ).forEach( function ( btn ) {
			btn.setAttribute( 'aria-pressed', btn.getAttribute( 'data-currency' ) === mode ? 'true' : 'false' );
		} );
	}

	function getStoredMode() {
		try {
			return window.localStorage.getItem( STORAGE_KEY ) || 'ghs';
		} catch ( e ) {
			return 'ghs';
		}
	}

	function setStoredMode( mode ) {
		try {
			window.localStorage.setItem( STORAGE_KEY, mode );
		} catch ( e ) {
			// localStorage unavailable (private mode etc) — display still
			// toggles for the current page view, it just won't persist.
		}
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var mode = getStoredMode();
		applyDisplay( mode );

		document.querySelectorAll( '.currency-switcher [data-currency]' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var newMode = btn.getAttribute( 'data-currency' );
				setStoredMode( newMode );
				applyDisplay( newMode );
			} );
		} );

		// Re-apply after WooCommerce AJAX updates (cart totals, fragments).
		if ( typeof jQuery !== 'undefined' ) {
			jQuery( document.body ).on( 'updated_cart_totals updated_checkout wc_fragments_refreshed', function () {
				applyDisplay( getStoredMode() );
			} );
		}
	} );
} )();
