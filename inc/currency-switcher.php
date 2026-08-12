<?php
/**
 * Client-side, display-only GHS -> USD price toggle. All checkout/order
 * totals still process in GHS regardless of what's shown here — see
 * assets/js/currency-switcher.js, which only rewrites the text of
 * already-rendered WooCommerce price elements.
 *
 * The conversion rate is a static constant, not a live API call, per
 * the build brief — update MOR_GHS_TO_USD_RATE below to keep it
 * reasonably current.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// REPLACE periodically to keep the displayed USD reference price current.
define( 'MOR_GHS_TO_USD_RATE', 0.065 );

function mor_currency_switcher_assets() {
	wp_enqueue_script(
		'mor-currency-switcher',
		MOR_THEME_URI . '/assets/js/currency-switcher.js',
		array(),
		MOR_THEME_VERSION,
		true
	);

	wp_localize_script(
		'mor-currency-switcher',
		'morCurrency',
		array(
			'rate'      => MOR_GHS_TO_USD_RATE,
			'usdSymbol' => '$',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'mor_currency_switcher_assets' );
