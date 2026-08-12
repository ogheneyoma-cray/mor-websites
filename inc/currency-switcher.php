<?php
/**
 * NGN... actually GHS/USD front-end currency switcher.
 *
 * Store currency (all real transactions, WooCommerce settings) stays
 * GHS. This only re-renders DISPLAYED prices client-side using a
 * static, configurable conversion rate — no live FX API call, no
 * change to what checkout actually charges.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Configurable static exchange rate: 1 GHS = this many USD.
// Update periodically by editing this constant — not fetched live.
if ( ! defined( 'MOR_GHS_TO_USD_RATE' ) ) {
	define( 'MOR_GHS_TO_USD_RATE', 0.067 );
}

function mor_enqueue_currency_switcher() {
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
			'rate'       => MOR_GHS_TO_USD_RATE,
			'base'       => 'GHS',
			'display'    => 'USD',
			'baseSymbol' => 'GH₵',
			'usdSymbol'  => '$',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'mor_enqueue_currency_switcher' );
