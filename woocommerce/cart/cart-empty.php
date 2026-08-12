<?php
/**
 * Empty-cart state, styled to match the design system, with a
 * "Shop Now" link back to the shop.
 *
 * @package MOR
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="cart-empty">
	<p><?php esc_html_e( 'Your cart is currently empty.', 'mor-websites' ); ?></p>
	<p>
		<a class="btn" href="<?php echo esc_url( ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Shop Now', 'mor-websites' ); ?>
		</a>
	</p>
</div>
