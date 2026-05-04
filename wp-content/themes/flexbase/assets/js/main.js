/* FlexBase — main.js */

// ── Hamburger / mobile menu toggle ───────────────────────────────────────────
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var hamburger  = document.querySelector( '.flexbase-header__hamburger' );
		var mobileMenu = document.getElementById( 'flexbase-mobile-menu' );

		if ( ! hamburger || ! mobileMenu ) {
			return;
		}

		var closeBtn = mobileMenu.querySelector( '.flexbase-header__mobile-close' );

		// Move menu to <body> (root stacking context, z-index 10001).
		document.body.appendChild( mobileMenu );

		// Create backdrop (z-index 10000, covers header).
		var backdrop = document.createElement( 'div' );
		backdrop.className = 'flexbase-nav-backdrop';
		backdrop.setAttribute( 'aria-hidden', 'true' );
		document.body.appendChild( backdrop );

		function openMenu() {
			hamburger.setAttribute( 'aria-expanded', 'true' );
			mobileMenu.setAttribute( 'aria-hidden', 'false' );
			mobileMenu.classList.add( 'is-open' );
			backdrop.classList.add( 'is-visible' );
			document.body.classList.add( 'flexbase-menu-open' );
			if ( closeBtn ) {
				closeBtn.classList.add( 'is-visible' );
			}
		}

		function closeMenu() {
			hamburger.setAttribute( 'aria-expanded', 'false' );
			mobileMenu.setAttribute( 'aria-hidden', 'true' );
			mobileMenu.classList.remove( 'is-open' );
			backdrop.classList.remove( 'is-visible' );
			document.body.classList.remove( 'flexbase-menu-open' );
			if ( closeBtn ) {
				closeBtn.classList.remove( 'is-visible' );
			}
		}

		hamburger.addEventListener( 'click', openMenu );

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeMenu );
		}

		backdrop.addEventListener( 'click', closeMenu );

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && mobileMenu.classList.contains( 'is-open' ) ) {
				closeMenu();
				hamburger.focus();
			}
		} );

		window.addEventListener( 'resize', function () {
			if ( window.innerWidth > 992 && mobileMenu.classList.contains( 'is-open' ) ) {
				closeMenu();
			}
		} );
	} );
}() );
