<?php
/**
 * WooCommerce theme support + template overrides plumbing.
 * Only loaded when WooCommerce is confirmed active (see functions.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'mor_woocommerce_setup' );

/**
 * Ensure WooCommerce's classic shortcode-based checkout is used instead
 * of the block checkout editor — the classic checkout has far broader
 * payment-gateway plugin compatibility, which matters since gateway
 * setup happens separately from this build.
 */
function mor_force_classic_checkout() {
	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$checkout_id = wc_get_page_id( 'checkout' );
	if ( ! $checkout_id || $checkout_id < 1 ) {
		return;
	}

	$post = get_post( $checkout_id );
	if ( ! $post ) {
		return;
	}

	// If the checkout page content uses the block checkout, replace it
	// with the classic [woocommerce_checkout] shortcode.
	if ( has_block( 'woocommerce/checkout', $post ) || false === strpos( $post->post_content, '[woocommerce_checkout]' ) ) {
		wp_update_post(
			array(
				'ID'           => $checkout_id,
				'post_content' => '[woocommerce_checkout]',
			)
		);
	}
}
add_action( 'admin_init', 'mor_force_classic_checkout' );

/**
 * Cart fragment: keep the header cart count in sync via WooCommerce's
 * native AJAX cart fragments (no full page reload needed).
 */
function mor_cart_fragments( $fragments ) {
	ob_start();
	?>
	<span class="cart-contents__count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
	<?php
	$fragments['span.cart-contents__count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'mor_cart_fragments' );

/**
 * Remove the default WooCommerce wrappers so header.php/footer.php own
 * the page chrome consistently.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function mor_woocommerce_wrapper_start() {
	echo '<main id="primary" class="site-main woocommerce-main"><div class="container">';
}
add_action( 'woocommerce_before_main_content', 'mor_woocommerce_wrapper_start' );

function mor_woocommerce_wrapper_end() {
	echo '</div></main>';
}
add_action( 'woocommerce_after_main_content', 'mor_woocommerce_wrapper_end' );
