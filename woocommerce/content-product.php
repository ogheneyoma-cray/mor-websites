<?php
/**
 * Shop/archive service card override.
 * Mirrors woocommerce/templates/content-product.php but styled to the
 * design system: image, name, price, Add to Cart.
 *
 * @package MOR
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'card', $product ); ?>>
	<a class="card__media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php echo wp_kses_post( $product->get_image( 'medium' ) ); ?>
	</a>
	<div class="card__body">
		<h2 class="card__title woocommerce-loop-product__title">
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
		</h2>
		<span class="card__price price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
		<?php
		echo wc_get_stock_html( $product ); // phpcs-friendly: core WC output, already escaped internally.
		?>
		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>
</li>
