<?php
defined( 'ABSPATH' ) || exit;

// ─── Local Font Registry ────────────────────────────────────────────────────

/**
 * Self-hosted font files (assets/webfonts/google/) and the weights actually
 * available for each family. No external requests — required for
 * WordPress.org (Google Fonts CDN loading is not allowed since 2022).
 */
function whs_frame_local_fonts() {
	return [
		'Inter'             => [ 'slug' => 'inter',             'weights' => [ 300, 400, 500, 600, 700, 800, 900 ], 'serif' => false ],
		'Poppins'           => [ 'slug' => 'poppins',           'weights' => [ 300, 400, 500, 600, 700, 800, 900 ], 'serif' => false ],
		'Montserrat'        => [ 'slug' => 'montserrat',        'weights' => [ 300, 400, 500, 600, 700, 800, 900 ], 'serif' => false ],
		'Playfair Display'  => [ 'slug' => 'playfair-display',  'weights' => [ 400, 500, 600, 700, 800, 900 ],      'serif' => true ],
		'Merriweather'      => [ 'slug' => 'merriweather',      'weights' => [ 300, 400, 700, 900 ],                'serif' => true ],
		'Lora'              => [ 'slug' => 'lora',              'weights' => [ 400, 500, 600, 700 ],                'serif' => true ],
	];
}

// ─── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Returns a complete font-family stack for a given font name.
 * Appends a suitable generic family so the browser always has a fallback.
 */
function whs_frame_font_stack( $font ) {
	$fonts = whs_frame_local_fonts();
	$serif = isset( $fonts[ $font ] ) && $fonts[ $font ]['serif'];

	if ( $serif ) {
		return '"' . $font . '", Georgia, "Times New Roman", serif';
	}
	return '"' . $font . '", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
}

/**
 * Builds @font-face rules for one local font family, one per available weight.
 */
function whs_frame_font_face_css( $font ) {
	$fonts = whs_frame_local_fonts();
	if ( ! isset( $fonts[ $font ] ) ) {
		return '';
	}

	$data = $fonts[ $font ];
	$css  = '';

	foreach ( $data['weights'] as $weight ) {
		$url = esc_url( WHS_FRAME_ASSETS . 'webfonts/google/' . $data['slug'] . '-' . $weight . '.woff2' );
		$css .= "@font-face{font-family:'" . esc_attr( $font ) . "';font-style:normal;font-weight:{$weight};font-display:swap;src:url('{$url}') format('woff2');}\n";
	}

	return $css;
}

// ─── Enqueue ──────────────────────────────────────────────────────────────────

/**
 * Injects @font-face rules for the selected fonts plus the body/heading
 * font-family CSS. Fully self-hosted — no external requests.
 *
 * Runs at priority 20 (after whs_frame_enqueue_assets at priority 10) so that
 * wp_add_inline_style can attach to the already-registered whs-frame-main handle.
 */
function whs_frame_enqueue_local_fonts() {
	$base    = whs_frame_opt( 'font_base',    'inherit' );
	$heading = whs_frame_opt( 'font_heading', 'inherit' );
	$fonts   = whs_frame_local_fonts();

	$css = '';

	if ( 'inherit' !== $base && isset( $fonts[ $base ] ) ) {
		$css .= whs_frame_font_face_css( $base );
	}
	if ( 'inherit' !== $heading && $heading !== $base && isset( $fonts[ $heading ] ) ) {
		$css .= whs_frame_font_face_css( $heading );
	}

	if ( 'inherit' !== $base ) {
		$css .= 'body { font-family: ' . whs_frame_font_stack( $base ) . '; }' . "\n";
	}
	if ( 'inherit' !== $heading ) {
		$css .= 'h1, h2, h3, h4, h5, h6 { font-family: ' . whs_frame_font_stack( $heading ) . '; }' . "\n";
	}

	if ( $css ) {
		wp_add_inline_style( 'whs-frame-main', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'whs_frame_enqueue_local_fonts', 20 );
