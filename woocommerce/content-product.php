<?php
/**
 * Shop/archive product card override.
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
<li <?php wc_product_class( 'product-card', $product ); ?>>
	<a class="product-card__media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php echo wp_kses_post( $product->get_image( 'medium' ) ); ?>
	</a>
	<h2 class="product-card__title woocommerce-loop-product__title">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
	</h2>
	<div class="product-card__rule"></div>
	<span class="product-card__price price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
	<div class="product-card__cta">
		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>
</li>
