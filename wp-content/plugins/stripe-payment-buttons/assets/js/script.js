document.addEventListener( 'DOMContentLoaded', function () {
	document.querySelectorAll( '.stripe-pb-wrap' ).forEach( function ( wrap ) {
		const btn         = wrap.querySelector( '.stripe-pb-btn' );
		const amountWrap  = wrap.querySelector( '.stripe-pb-amount' );
		const amountInput = wrap.querySelector( '.stripe-pb-amount-input' );
		const msgEl       = wrap.querySelector( '.stripe-pb-msg' );

		if ( ! btn ) return;

		function getSelected() {
			return wrap.querySelector( 'input[type="radio"]:checked' );
		}

		function isSubscription( value ) {
			return value === 'monthly' || value === 'yearly';
		}

		function setError( msg ) {
			if ( msgEl ) {
				msgEl.textContent = msg;
				msgEl.style.color = '#dc2626';
			}
		}

		function clearMsg() {
			if ( msgEl ) msgEl.textContent = '';
		}

		function showAmount( show ) {
			if ( amountWrap ) amountWrap.style.display = show ? 'block' : 'none';
		}

		// Sync initial amount-input visibility with the pre-checked radio.
		const initial = getSelected();
		if ( initial && amountWrap ) {
			showAmount( isSubscription( initial.value ) );
		}

		// Radio change: update button text, toggle amount input.
		wrap.querySelectorAll( 'input[type="radio"]' ).forEach( function ( radio ) {
			radio.addEventListener( 'change', function () {
				btn.textContent = wrap.dataset[ this.value + 'Btn' ] || '';
				clearMsg();
				showAmount( isSubscription( this.value ) );
				if ( amountInput ) amountInput.value = '';
			} );
		} );

		// Clear error as user types.
		if ( amountInput ) {
			amountInput.addEventListener( 'input', clearMsg );
		}

		// Button click.
		btn.addEventListener( 'click', function () {
			const selected = getSelected();
			if ( ! selected ) return;

			clearMsg();

			// One-time: open Stripe Payment Link.
			if ( ! isSubscription( selected.value ) ) {
				const link = wrap.dataset[ selected.value + 'Link' ];
				if ( ! link ) {
					setError( 'This option is not configured yet.' );
				} else {
					window.open( link, '_blank', 'noopener,noreferrer' );
				}
				return;
			}

			// Monthly / Yearly: validate amount, then create Checkout Session via AJAX.
			if ( typeof window.stripePB === 'undefined' ) {
				setError( 'Configuration error. Please refresh the page.' );
				return;
			}

			const amount = amountInput ? parseFloat( amountInput.value ) : 0;
			if ( ! amount || amount < 1 ) {
				const symbol = stripePB.currencySymbol || '$';
				setError( 'Please enter an amount of at least ' + symbol + '1.00.' );
				if ( amountInput ) amountInput.focus();
				return;
			}

			const interval     = selected.value === 'monthly' ? 'month' : 'year';
			const originalText = btn.textContent;

			btn.disabled    = true;
			btn.textContent = 'Processing…';

			const body = new FormData();
			body.append( 'action',   'stripe_pb_create_session' );
			body.append( 'nonce',    stripePB.nonce );
			body.append( 'amount',   amount );
			body.append( 'interval', interval );
			body.append( 'page_url', window.location.href );

			fetch( stripePB.ajaxUrl, { method: 'POST', body: body } )
				.then( function ( res ) { return res.json(); } )
				.then( function ( data ) {
					if ( data.success && data.data && data.data.url ) {
						// Open Stripe Checkout in a new tab; restore button so user can re-submit if needed.
						window.open( data.data.url, '_blank', 'noopener,noreferrer' );
					} else {
						const msg = ( data.data && data.data.message ) ? data.data.message : 'An error occurred. Please try again.';
						setError( msg );
					}
					btn.disabled    = false;
					btn.textContent = originalText;
				} )
				.catch( function () {
					setError( 'Connection error. Please try again.' );
					btn.disabled    = false;
					btn.textContent = originalText;
				} );
		} );
	} );
} );
