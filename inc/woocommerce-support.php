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
 * Same as mor_force_classic_checkout() above, but for the Cart page.
 * WooCommerce creates the Cart page with the block-based cart by
 * default, which renders entirely different markup (wp-block-woocommerce-*
 * classes) that this theme's cart styling (page-cart.php + the "Cart
 * page" rules in style.css) doesn't target. Keeping it on the classic
 * [woocommerce_cart] shortcode keeps the cart page on the same design
 * system as the rest of the site.
 */
function mor_force_classic_cart() {
	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$cart_id = wc_get_page_id( 'cart' );
	if ( ! $cart_id || $cart_id < 1 ) {
		return;
	}

	$post = get_post( $cart_id );
	if ( ! $post ) {
		return;
	}

	if ( has_block( 'woocommerce/cart', $post ) || false === strpos( $post->post_content, '[woocommerce_cart]' ) ) {
		wp_update_post(
			array(
				'ID'           => $cart_id,
				'post_content' => '[woocommerce_cart]',
			)
		);
	}
}
add_action( 'admin_init', 'mor_force_classic_cart' );

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

/**
 * No sidebar, no default breadcrumb — this theme's own page-hero (below)
 * replaces both the "Shop" title and the breadcrumb trail.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Branded page-hero banner for the Shop archive (and product category/tag
 * archives) — 'woocommerce_before_main_content' only fires on these
 * listing templates, not on cart/checkout (see page-cart.php /
 * page-checkout.php for those).
 */
function mor_woocommerce_shop_hero() {
	if ( ! is_shop() && ! is_product_category() && ! is_product_tag() ) {
		return;
	}
	?>
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><span class="eyebrow-text"><?php esc_html_e( 'Our Services', 'mor-websites' ); ?></span></p>
			<h1><?php esc_html_e( 'Book a Service', 'mor-websites' ); ?></h1>
			<p class="page-hero__tagline"><?php esc_html_e( 'Every listing below is scoped and priced up front — add to cart and check out online, and we\'ll confirm an appointment time after checkout.', 'mor-websites' ); ?></p>
		</div>
	</section>
	<?php
}
add_action( 'woocommerce_before_main_content', 'mor_woocommerce_shop_hero', 5 );

function mor_woocommerce_wrapper_start() {
	echo '<main id="primary" class="site-main woocommerce-main"><div class="container">';
}
add_action( 'woocommerce_before_main_content', 'mor_woocommerce_wrapper_start' );

function mor_woocommerce_wrapper_end() {
	echo '</div></main>';
}
add_action( 'woocommerce_after_main_content', 'mor_woocommerce_wrapper_end' );
