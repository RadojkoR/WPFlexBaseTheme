<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function stripe_pb_render_shortcode( $atts ) {
	$atts = shortcode_atts( [
		'layout'        => 'vertical',
		'show_one_time' => 'true',
		'show_monthly'  => 'true',
		'show_yearly'   => 'true',
		'button_text'   => '',
		'show_portal'   => 'false',
	], $atts, 'stripe_payment_buttons' );

	$opts = get_option( 'stripe_pb_options', [] );

	$plans = [
		'onetime' => [
			'title' => 'One-Time',
			'btn'   => ( $opts['onetime_btn_text'] ?? '' ) ?: 'Donate',
			'link'  => $opts['onetime_link']     ?? '',
		],
		'monthly' => [
			'title' => 'Monthly',
			'btn'   => ( $opts['monthly_btn_text'] ?? '' ) ?: 'Subscribe Monthly',
			'link'  => $opts['monthly_link']     ?? '',
		],
		'yearly'  => [
			'title' => 'Yearly',
			'btn'   => ( $opts['yearly_btn_text'] ?? '' ) ?: 'Subscribe Yearly',
			'link'  => $opts['yearly_link']     ?? '',
		],
	];

	if ( strtolower( $atts['show_one_time'] ) === 'false' ) {
		unset( $plans['onetime'] );
	}
	if ( strtolower( $atts['show_monthly'] ) === 'false' ) {
		unset( $plans['monthly'] );
	}
	if ( strtolower( $atts['show_yearly'] ) === 'false' ) {
		unset( $plans['yearly'] );
	}

	if ( empty( $plans ) ) {
		return '';
	}

	wp_enqueue_style( 'stripe-pb' );
	wp_enqueue_script( 'stripe-pb' );

	$uid = wp_unique_id( 'stripe_pb_' );

	$btn_override = sanitize_text_field( $atts['button_text'] );
	if ( $btn_override !== '' ) {
		foreach ( $plans as &$plan ) {
			$plan['btn'] = $btn_override;
		}
		unset( $plan );
	}

	$currency_symbols = [ 'usd' => '$', 'cad' => '$', 'eur' => '€', 'gbp' => '£' ];
	$currency         = $opts['currency'] ?? 'cad';
	$currency_symbol  = $currency_symbols[ $currency ] ?? '$';
	$color            = sanitize_hex_color( $opts['button_color'] ?? '#6366f1' ) ?: '#6366f1';
	$layout           = strtolower( $atts['layout'] ) === 'horizontal' ? 'is-horizontal' : 'is-vertical';
	$first_key        = array_key_first( $plans );
	$portal_link      = $opts['portal_link'] ?? '';
	$show_portal      = strtolower( $atts['show_portal'] ) === 'true' && $portal_link !== '';
	$has_subscription = isset( $plans['monthly'] ) || isset( $plans['yearly'] );
	$amount_visible   = in_array( $first_key, [ 'monthly', 'yearly' ], true );

	ob_start();
	?>
	<div class="stripe-pb-wrap <?php echo esc_attr( $layout ); ?>"
		style="--stripe-pb-color: <?php echo esc_attr( $color ); ?>;"
		data-onetime-link="<?php echo esc_url( $plans['onetime']['link'] ?? '' ); ?>"
		data-monthly-link="<?php echo esc_url( $plans['monthly']['link'] ?? '' ); ?>"
		data-yearly-link="<?php echo esc_url( $plans['yearly']['link'] ?? '' ); ?>"
		data-onetime-btn="<?php echo esc_attr( $plans['onetime']['btn'] ?? '' ); ?>"
		data-monthly-btn="<?php echo esc_attr( $plans['monthly']['btn'] ?? '' ); ?>"
		data-yearly-btn="<?php echo esc_attr( $plans['yearly']['btn'] ?? '' ); ?>">

		<div class="stripe-pb-options">
			<?php foreach ( $plans as $value => $plan ) : ?>
				<label class="stripe-pb-option">
					<input type="radio" name="<?php echo esc_attr( $uid ); ?>" value="<?php echo esc_attr( $value ); ?>"<?php checked( $value, $first_key ); ?>>
					<span class="stripe-pb-option-label">
						<span class="stripe-pb-option-title"><?php echo esc_html( $plan['title'] ); ?></span>
					</span>
				</label>
			<?php endforeach; ?>
		</div>

		<?php if ( $has_subscription ) : ?>
		<div class="stripe-pb-amount"<?php echo $amount_visible ? ' style="display:block;"' : ''; ?>>
			<div class="stripe-pb-amount-row">
				<span class="stripe-pb-currency"><?php echo esc_html( $currency_symbol ); ?></span>
				<input type="number" class="stripe-pb-amount-input" min="1" step="any" placeholder="Enter amount">
			</div>
		</div>
		<?php endif; ?>

		<button class="stripe-pb-btn" type="button">
			<?php echo esc_html( $plans[ $first_key ]['btn'] ); ?>
		</button>

		<p class="stripe-pb-msg" aria-live="polite"></p>

		<?php if ( $show_portal ) : ?>
		<a class="stripe-pb-portal-btn"
			href="<?php echo esc_url( $portal_link ); ?>"
			target="_blank"
			rel="noopener noreferrer">
			Manage Subscription
		</a>
		<?php endif; ?>

	</div>
	<?php
	return ob_get_clean();
}

function stripe_pb_render_thank_you( $atts = [] ) {
	wp_enqueue_style( 'stripe-pb' );
	ob_start();
	?>
	<div class="stripe-pb-thank-you">
		<div class="stripe-pb-thank-you-icon">&#10003;</div>
		<h2 class="stripe-pb-thank-you-title">Thank You for Your Subscription!</h2>
		<p class="stripe-pb-thank-you-msg">Your payment was successful. You will receive a confirmation email shortly.</p>
	</div>
	<?php
	return ob_get_clean();
}
