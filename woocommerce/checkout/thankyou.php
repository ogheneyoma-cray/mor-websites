<?php
/**
 * Order thank-you / confirmation page override, styled to match the
 * design system. Order details table itself is left to WooCommerce's
 * own woocommerce_order_details_table() output.
 *
 * @package MOR
 */

defined( 'ABSPATH' ) || exit;

/**
 * @var WC_Order|false $order
 */
?>

<section class="hero" style="text-align:center;">
	<div class="container hero__inner" style="max-width:100%;">
		<?php if ( $order ) : ?>
			<?php if ( $order->has_status( 'failed' ) ) : ?>
				<h1><?php esc_html_e( 'Order Not Completed', 'mor-websites' ); ?></h1>
				<p class="hero__tagline">
					<?php esc_html_e( 'There was a problem processing your order. Please try again, or contact us for help.', 'mor-websites' ); ?>
				</p>
				<div class="hero__actions">
					<a class="btn btn--light" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"><?php esc_html_e( 'Try Again', 'mor-websites' ); ?></a>
					<a class="btn btn--outline" style="border-color:#fff;color:#fff !important;" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'mor-websites' ); ?></a>
				</div>
			<?php else : ?>
				<h1><?php esc_html_e( 'Thank You — Your Booking Is Confirmed', 'mor-websites' ); ?></h1>
				<p class="hero__tagline">
					<?php
					printf(
						/* translators: %s: order number */
						esc_html__( 'Order #%s has been received. A confirmation has been sent to your email.', 'mor-websites' ),
						esc_html( $order->get_order_number() )
					);
					?>
				</p>
			<?php endif; ?>
		<?php else : ?>
			<h1><?php esc_html_e( 'Thank You', 'mor-websites' ); ?></h1>
		<?php endif; ?>
	</div>
</section>

<div class="container section">
	<div class="order-summary-panel">
		<?php if ( $order ) : ?>
			<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
			<?php wc_get_template( 'order/order-details.php', array( 'order' => $order ) ); ?>
			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
		<?php endif; ?>
	</div>

	<p style="text-align:center;margin-top:var(--space-4);">
		<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'mor-websites' ); ?></a>
	</p>
</div>
