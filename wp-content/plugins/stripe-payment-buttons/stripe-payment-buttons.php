<?php
/**
 * Plugin Name: Stripe Payment Buttons
 * Description: Adds Stripe payment buttons to your site via shortcode.
 * Version: 1.0.0
 * Author: Radojko Radulovic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STRIPE_PB_PATH', plugin_dir_path( __FILE__ ) );
define( 'STRIPE_PB_URL',  plugin_dir_url( __FILE__ ) );
define( 'STRIPE_PB_VER',  '1.0.0' );

if ( is_admin() && ! wp_doing_ajax() ) {
	require_once STRIPE_PB_PATH . 'admin/settings.php';
}

require_once STRIPE_PB_PATH . 'includes/shortcode.php';
require_once STRIPE_PB_PATH . 'includes/ajax.php';

add_action( 'wp_enqueue_scripts', function() {
	$opts             = get_option( 'stripe_pb_options', [] );
	$currency_symbols = [ 'usd' => '$', 'cad' => '$', 'eur' => '€', 'gbp' => '£' ];
	$currency         = $opts['currency'] ?? 'cad';
	$currency_symbol  = $currency_symbols[ $currency ] ?? '$';

	wp_register_style( 'stripe-pb', STRIPE_PB_URL . 'assets/css/style.css', [], STRIPE_PB_VER );
	wp_register_script( 'stripe-pb', STRIPE_PB_URL . 'assets/js/script.js', [], STRIPE_PB_VER, true );
	wp_localize_script( 'stripe-pb', 'stripePB', [
		'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
		'nonce'          => wp_create_nonce( 'stripe_pb_nonce' ),
		'currencySymbol' => $currency_symbol,
	] );
} );

add_action( 'init', function() {
	add_shortcode( 'stripe_payment_buttons', 'stripe_pb_render_shortcode' );
	add_shortcode( 'stripe_thank_you',       'stripe_pb_render_thank_you' );
} );
