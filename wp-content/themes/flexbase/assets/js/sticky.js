/* FlexBase — sticky.js */

// ── Sticky header: none / always / scroll_up + transparent transition ─────────
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var wrap   = document.getElementById( 'flexbase-header-wrap' );
		var topbar = document.getElementById( 'flexbase-topbar' );

		if ( ! wrap ) {
			return;
		}

		var stickyMode  = wrap.getAttribute( 'data-sticky' );
		var transparent = wrap.getAttribute( 'data-transparent' ) === 'true';
		var isSticky    = stickyMode === 'always' || stickyMode === 'scroll_up';
		var needsFixed  = isSticky || transparent;

		if ( ! needsFixed ) {
			return;
		}

		// ── Topbar height helper ──────────────────────────────────────────────
		function getTopbarHeight() {
			return ( topbar && topbar.offsetParent !== null ) ? topbar.offsetHeight : 0;
		}

		// ── Scroll handler ────────────────────────────────────────────────────
		var lastScrollY        = window.scrollY || window.pageYOffset;
		var SCROLLED_THRESHOLD = 50;
		var HIDE_THRESHOLD     = 80;

		function onScroll() {
			var currentY = window.scrollY || window.pageYOffset;

			if ( needsFixed ) {
				var topbarH = getTopbarHeight();
				wrap.style.top = Math.max( 0, topbarH - currentY ) + 'px';
			}

			if ( currentY > SCROLLED_THRESHOLD ) {
				wrap.classList.add( 'is-scrolled' );
			} else {
				wrap.classList.remove( 'is-scrolled' );
			}

			if ( stickyMode === 'scroll_up' ) {
				if ( currentY > HIDE_THRESHOLD ) {
					wrap.classList[ currentY > lastScrollY ? 'add' : 'remove' ]( 'is-hidden' );
				} else {
					wrap.classList.remove( 'is-hidden' );
				}
			}

			lastScrollY = currentY;
		}

		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	} );
}() );
