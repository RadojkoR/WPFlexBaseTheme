<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', function() {
	add_options_page(
		'Stripe Payment Buttons',
		'Stripe Payments',
		'manage_options',
		'stripe-payment-buttons',
		'stripe_pb_settings_page'
	);
} );

add_action( 'admin_init', function() {
	register_setting( 'stripe_pb_settings_group', 'stripe_pb_options', [
		'sanitize_callback' => 'stripe_pb_sanitize_options',
	] );

	add_settings_section( 'stripe_pb_api',    'API Settings',   null, 'stripe-payment-buttons' );
	add_settings_section( 'stripe_pb_links',  'Payment Links',  null, 'stripe-payment-buttons' );
	add_settings_section( 'stripe_pb_labels', 'Button Labels',  null, 'stripe-payment-buttons' );
	add_settings_section( 'stripe_pb_prices', 'Prices',         null, 'stripe-payment-buttons' );
	add_settings_section( 'stripe_pb_style',  'Button Style',   null, 'stripe-payment-buttons' );

	// Fields: [ key, label, section, type, default, placeholder, options (for select) ]
	$fields = [
		[ 'mode',             'Mode',                      'stripe_pb_api',    'select', 'test',    '', [ 'test' => 'Test', 'live' => 'Live' ] ],
		[ 'currency',         'Currency',                  'stripe_pb_api',    'select', 'cad',     '', [ 'usd' => 'USD – US Dollar', 'cad' => 'CAD – Canadian Dollar', 'eur' => 'EUR – Euro', 'gbp' => 'GBP – British Pound' ] ],
		[ 'publishable_key',  'Publishable Key',           'stripe_pb_api',    'text' ],
		[ 'secret_key',       'Secret Key',                'stripe_pb_api',    'password' ],
		[ 'onetime_link',     'One-Time Payment Link',     'stripe_pb_links',  'url' ],
		[ 'monthly_link',     'Monthly Subscription Link', 'stripe_pb_links',  'url' ],
		[ 'yearly_link',      'Yearly Subscription Link',  'stripe_pb_links',  'url' ],
		[ 'portal_link',      'Customer Portal Link',      'stripe_pb_links',  'url' ],
		[ 'thank_you_page',   'Thank You Page URL',        'stripe_pb_links',  'url' ],
		[ 'onetime_btn_text', 'One-Time Button Text',      'stripe_pb_labels', 'text', 'Donate' ],
		[ 'monthly_btn_text', 'Monthly Button Text',       'stripe_pb_labels', 'text', 'Subscribe Monthly' ],
		[ 'yearly_btn_text',  'Yearly Button Text',        'stripe_pb_labels', 'text', 'Subscribe Yearly' ],
		[ 'onetime_price',    'One-Time Price',            'stripe_pb_prices', 'text', '$10',    'e.g. $10' ],
		[ 'monthly_price',    'Monthly Price',             'stripe_pb_prices', 'text', '$5/mo',  'e.g. $5/mo' ],
		[ 'yearly_price',     'Yearly Price',              'stripe_pb_prices', 'text', '$50/yr', 'e.g. $50/yr' ],
		[ 'button_color',     'Button Color',              'stripe_pb_style',  'color', '#6366f1' ],
	];

	foreach ( $fields as $field ) {
		[ $key, $label, $section, $type ] = $field;
		$default     = $field[4] ?? '';
		$placeholder = $field[5] ?? '';
		$options     = $field[6] ?? [];
		$callback    = $type === 'select' ? 'stripe_pb_render_select' : 'stripe_pb_render_input';

		add_settings_field( $key, $label, $callback, 'stripe-payment-buttons', $section, compact( 'key', 'type', 'default', 'placeholder', 'options' ) + [ 'label_for' => $key ] );
	}
} );

function stripe_pb_get( $key, $default = '' ) {
	$options = get_option( 'stripe_pb_options', [] );
	return $options[ $key ] ?? $default;
}

function stripe_pb_sanitize_options( $input ) {
	if ( ! is_array( $input ) ) {
		return get_option( 'stripe_pb_options', [] );
	}

	$clean = [];

	$clean['button_color'] = sanitize_hex_color( $input['button_color'] ?? '' ) ?: '#6366f1';

	$text_fields = [ 'publishable_key', 'secret_key', 'onetime_btn_text', 'monthly_btn_text', 'yearly_btn_text', 'onetime_price', 'monthly_price', 'yearly_price' ];
	foreach ( $text_fields as $field ) {
		$clean[ $field ] = sanitize_text_field( $input[ $field ] ?? '' );
	}

	$url_fields = [ 'onetime_link', 'monthly_link', 'yearly_link', 'portal_link', 'thank_you_page' ];
	foreach ( $url_fields as $field ) {
		$clean[ $field ] = esc_url_raw( $input[ $field ] ?? '' );
	}

	$mode          = $input['mode'] ?? '';
	$clean['mode'] = in_array( $mode, [ 'test', 'live' ], true ) ? $mode : 'test';

	$currency          = $input['currency'] ?? '';
	$clean['currency'] = in_array( $currency, [ 'usd', 'cad', 'eur', 'gbp' ], true ) ? $currency : 'cad';

	return $clean;
}

function stripe_pb_render_input( $args ) {
	if ( $args['type'] === 'color' ) {
		printf(
			'<input type="color" id="%s" name="stripe_pb_options[%s]" value="%s" />',
			esc_attr( $args['key'] ),
			esc_attr( $args['key'] ),
			esc_attr( stripe_pb_get( $args['key'], $args['default'] ) )
		);
		return;
	}

	$class = empty( $args['placeholder'] ) ? 'regular-text' : 'small-text';
	printf(
		'<input type="%s" id="%s" name="stripe_pb_options[%s]" value="%s" class="%s" placeholder="%s" />',
		esc_attr( $args['type'] ),
		esc_attr( $args['key'] ),
		esc_attr( $args['key'] ),
		esc_attr( stripe_pb_get( $args['key'], $args['default'] ) ),
		esc_attr( $class ),
		esc_attr( $args['placeholder'] )
	);
}

function stripe_pb_render_select( $args ) {
	$value   = stripe_pb_get( $args['key'], $args['default'] );
	$options = $args['options'] ?? [];
	?>
	<select id="<?php echo esc_attr( $args['key'] ); ?>" name="stripe_pb_options[<?php echo esc_attr( $args['key'] ); ?>]">
		<?php foreach ( $options as $opt_value => $opt_label ) : ?>
		<option value="<?php echo esc_attr( $opt_value ); ?>" <?php selected( $value, $opt_value ); ?>>
			<?php echo esc_html( $opt_label ); ?>
		</option>
		<?php endforeach; ?>
	</select>
	<?php
}

function stripe_pb_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1>Stripe Payment Buttons</h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'stripe_pb_settings_group' );
			do_settings_sections( 'stripe-payment-buttons' );
			submit_button( 'Save Settings' );
			?>
		</form>

		<div style="margin-top:32px; padding:16px 20px; background:#f0f6fc; border-left:4px solid #2271b1; border-radius:3px;">
			<h2 style="margin:0 0 12px; font-size:14px; text-transform:uppercase; letter-spacing:.5px; color:#1d2327;">Shortcode Usage</h2>
			<p style="margin:0 0 4px; font-size:13px; color:#50575e;"><strong>Basic usage:</strong></p>
			<code style="display:block; padding:8px 12px; margin-bottom:12px; background:#fff; border:1px solid #c3c4c7; border-radius:3px; font-size:13px; color:#1d2327;">[stripe_payment_buttons]</code>
			<p style="margin:0 0 4px; font-size:13px; color:#50575e;"><strong>With parameters:</strong></p>
			<code style="display:block; padding:8px 12px; background:#fff; border:1px solid #c3c4c7; border-radius:3px; font-size:13px; color:#1d2327;">[stripe_payment_buttons layout="horizontal" show_yearly="false" button_text="Donate Now"]</code>
			<p style="margin:12px 0 0; font-size:12px; color:#787c82;">
				Available parameters: <code>layout</code> (horizontal | vertical), <code>show_one_time</code> (true | false), <code>show_monthly</code> (true | false), <code>show_yearly</code> (true | false), <code>button_text</code> (overrides admin setting), <code>show_portal</code> (true | false &mdash; shows a &ldquo;Manage Subscription&rdquo; button if Customer Portal Link is configured).
			</p>
		</div>
	</div>
	<?php
}
