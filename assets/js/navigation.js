/**
 * Mobile hamburger menu toggle.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var toggle = document.querySelector( '.menu-toggle' );
		var mobileNav = document.querySelector( '.mobile-nav' );

		if ( ! toggle || ! mobileNav ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var isOpen = mobileNav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	} );
} )();
