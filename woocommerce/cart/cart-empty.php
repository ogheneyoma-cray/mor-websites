<?php
/**
 * Empty cart state override.
 *
 * @package MOR
 */

defined( 'ABSPATH' ) || exit;

$shop_url = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/' );
?>
<div class="cart-empty-state" style="text-align:center;padding:var(--space-6) 0;">
	<?php do_action( 'woocommerce_cart_is_empty' ); ?>
	<p><?php esc_html_e( 'Your cart is currently empty — browse our services and add what you need.', 'mor-websites' ); ?></p>
	<p>
		<a class="btn" href="<?php echo esc_url( $shop_url ); ?>">
			<?php esc_html_e( 'Shop Now', 'mor-websites' ); ?>
		</a>
	</p>
</div>
