/* FlexBase — topbar.js */

// ── Top bar dismiss ───────────────────────────────────────────────────────────
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var topbar = document.getElementById( 'flexbase-topbar' );

		if ( ! topbar || topbar.getAttribute( 'data-dismissible' ) !== 'true' ) {
			return;
		}

		var closeBtn = topbar.querySelector( '.flexbase-topbar__close' );
		if ( ! closeBtn ) {
			return;
		}

		closeBtn.addEventListener( 'click', function () {
			topbar.classList.add( 'flexbase-topbar--dismissed' );

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
