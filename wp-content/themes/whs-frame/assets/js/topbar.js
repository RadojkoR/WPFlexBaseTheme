/* WHS Frame — topbar.js */

// ── Top bar dismiss ───────────────────────────────────────────────────────────
( function () {
	'use strict';

	var STORAGE_KEY = 'whs-frame-topbar-dismissed';

	function isDismissed() {
		try {
			return window.localStorage.getItem( STORAGE_KEY ) === '1';
		} catch ( err ) {
			return false;
		}
	}

	function rememberDismissed() {
		try {
			window.localStorage.setItem( STORAGE_KEY, '1' );
		} catch ( err ) {
			// localStorage unavailable — dismiss lasts for this page view only.
		}
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var topbar = document.getElementById( 'whs-frame-topbar' );

		if ( ! topbar || topbar.getAttribute( 'data-dismissible' ) !== 'true' ) {
			return;
		}

		// Dismissed on a previous visit — remove immediately, no animation.
		if ( isDismissed() ) {
			if ( topbar.parentNode ) {
				topbar.parentNode.removeChild( topbar );
			}
			return;
		}

		var closeBtn = topbar.querySelector( '.whs-frame-topbar__close' );
		if ( ! closeBtn ) {
			return;
		}

		closeBtn.addEventListener( 'click', function () {
			rememberDismissed();
			topbar.classList.add( 'whs-frame-topbar--dismissed' );

			// Remove from DOM after transition so it no longer occupies space.
			topbar.addEventListener( 'transitionend', function onEnd( e ) {
				if ( e.propertyName !== 'max-height' ) {
					return;
				}
				topbar.removeEventListener( 'transitionend', onEnd );
				if ( topbar.parentNode ) {
					topbar.parentNode.removeChild( topbar );
				}
			} );
		} );
	} );
}() );
