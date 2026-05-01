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

		// Remember original DOM position so we can restore on close.
		var hamburgerParent  = hamburger.parentNode;
		var hamburgerNextSib = hamburger.nextSibling;

		// Move menu to <body> (root stacking context).
		document.body.appendChild( mobileMenu );

		// Create backdrop.
		var backdrop = document.createElement( 'div' );
		backdrop.className = 'flexbase-nav-backdrop';
		backdrop.setAttribute( 'aria-hidden', 'true' );
		document.body.appendChild( backdrop );

		function openMenu() {
			/*
			 * Capture the hamburger's viewport position while it's still inside
			 * the header, then move it to <body> with position:fixed.
			 * This places it in the root stacking context at z-index 10003,
			 * above the menu panel (10001) and backdrop (10000), regardless of
			 * whether a sticky wrapper is active.
			 */
			var rect = hamburger.getBoundingClientRect();
			hamburger.style.cssText = [
				'position:fixed',
				'top:'   + Math.max( 0, rect.top )                    + 'px',
				'right:' + Math.max( 0, window.innerWidth - rect.right ) + 'px',
				'z-index:10003'
			].join( ';' );
			document.body.appendChild( hamburger );

			hamburger.setAttribute( 'aria-expanded', 'true' );
			hamburger.classList.add( 'is-active' );
			mobileMenu.setAttribute( 'aria-hidden', 'false' );
			mobileMenu.classList.add( 'is-open' );
			backdrop.classList.add( 'is-visible' );
			document.body.classList.add( 'flexbase-menu-open' );
		}

		function closeMenu() {
			hamburger.setAttribute( 'aria-expanded', 'false' );
			hamburger.classList.remove( 'is-active' );
			mobileMenu.setAttribute( 'aria-hidden', 'true' );
			mobileMenu.classList.remove( 'is-open' );
			backdrop.classList.remove( 'is-visible' );
			document.body.classList.remove( 'flexbase-menu-open' );

			// Restore hamburger to header.
			hamburger.style.cssText = '';
			hamburgerParent.insertBefore( hamburger, hamburgerNextSib );
		}

		hamburger.addEventListener( 'click', function () {
			if ( this.getAttribute( 'aria-expanded' ) === 'true' ) {
				closeMenu();
			} else {
				openMenu();
			}
		} );

		backdrop.addEventListener( 'click', closeMenu );

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && mobileMenu.classList.contains( 'is-open' ) ) {
				closeMenu();
				hamburger.focus();
			}
		} );

		window.addEventListener( 'resize', function () {
			if ( window.innerWidth > 768 && mobileMenu.classList.contains( 'is-open' ) ) {
				closeMenu();
			}
		} );
	} );
}() );
