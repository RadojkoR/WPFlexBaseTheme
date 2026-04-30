<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_stripe_pb_create_session',        'stripe_pb_create_session' );
add_action( 'wp_ajax_nopriv_stripe_pb_create_session', 'stripe_pb_create_session' );

function stripe_pb_create_session() {
	if ( ! check_ajax_referer( 'stripe_pb_nonce', 'nonce', false ) ) {
		wp_send_json_error( [ 'message' => 'Security check failed.' ], 403 );
	}

	$opts       = get_option( 'stripe_pb_options', [] );
	$secret_key = $opts['secret_key'] ?? '';

	if ( empty( $secret_key ) ) {
		wp_send_json_error( [ 'message' => 'Payment is not configured. Please contact the site administrator.' ], 400 );
	}

	// Sanitize before casting — prevents malformed input from bypassing float conversion.
	$amount   = isset( $_POST['amount'] )   ? (float) sanitize_text_field( $_POST['amount'] ) : 0;
	$interval = isset( $_POST['interval'] ) ? sanitize_text_field( $_POST['interval'] )        : '';
	// Validate page_url is on this site to prevent open redirect via cancel_url.
	$page_url = wp_validate_redirect( esc_url_raw( $_POST['page_url'] ?? '' ), home_url() );

	if ( $amount < 1 ) {
		wp_send_json_error( [ 'message' => 'Minimum amount is $1.00.' ], 400 );
	}

	if ( ! in_array( $interval, [ 'month', 'year' ], true ) ) {
		wp_send_json_error( [ 'message' => 'Invalid billing interval.' ], 400 );
	}

	$allowed_currencies = [ 'usd', 'cad', 'eur', 'gbp' ];
	$currency = $opts['currency'] ?? 'cad';
	if ( ! in_array( $currency, $allowed_currencies, true ) ) {
		$currency = 'cad';
	}

	$unit_amount    = (int) round( $amount * 100 );
	$product_name   = $interval === 'month' ? 'Monthly Subscription' : 'Yearly Subscription';
	$thank_you_page = $opts['thank_you_page'] ?? '';
	$success_url    = $thank_you_page ?: $page_url;
	$cancel_url     = add_query_arg( 'stripe_pb', 'cancelled', $page_url );

	$response = wp_remote_post( 'https://api.stripe.com/v1/checkout/sessions', [
		'headers' => [
			'Authorization'  => 'Bearer ' . $secret_key,
			'Content-Type'   => 'application/x-www-form-urlencoded',
			'Stripe-Version' => '2023-10-16',
		],
		'body' => [
			'mode'                                              => 'subscription',
			'success_url'                                       => $success_url,
			'cancel_url'                                        => $cancel_url,
			'line_items[0][price_data][currency]'               => $currency,
			'line_items[0][price_data][unit_amount]'            => $unit_amount,
			'line_items[0][price_data][recurring][interval]'    => $interval,
			'line_items[0][price_data][product_data][name]'     => $product_name,
			'line_items[0][quantity]'                           => '1',
			// Collect full name (required) and business name (optional) on Stripe Checkout.
			'custom_fields[0][key]'                             => 'full_name',
			'custom_fields[0][label][type]'                     => 'custom',
			'custom_fields[0][label][custom]'                   => 'Full Name',
			'custom_fields[0][type]'                            => 'text',
			'custom_fields[1][key]'                             => 'business_name',
			'custom_fields[1][label][type]'                     => 'custom',
			'custom_fields[1][label][custom]'                   => 'Business Name',
			'custom_fields[1][type]'                            => 'text',
			'custom_fields[1][optional]'                        => 'true',
		],
		'timeout' => 30,
	] );

	if ( is_wp_error( $response ) ) {
		wp_send_json_error( [ 'message' => 'Connection error. Please try again.' ], 500 );
	}

	$code = wp_remote_retrieve_response_code( $response );
	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( $code !== 200 || ! is_array( $data ) || empty( $data['url'] ) ) {
		$msg = ( is_array( $data ) && ! empty( $data['error']['message'] ) )
			? $data['error']['message']
			: 'Could not create payment session. Please try again.';
		wp_send_json_error( [ 'message' => $msg ], 400 );
	}

	wp_send_json_success( [ 'url' => $data['url'] ] );
}
