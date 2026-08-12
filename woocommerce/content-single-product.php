<?php
/**
 * Single product page override: image, name, price, full description,
 * quantity selector, Add to Cart.
 *
 * @package MOR
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_singular( 'product' ) ) {
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-layout', $product ); ?>>

	<?php do_action( 'woocommerce_before_single_product' ); ?>

	<div class="grid grid--2">
		<div class="single-product-layout__gallery">
			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		</div>

		<div class="single-product-layout__summary">
			<h1 class="product_title entry-title"><?php the_title(); ?></h1>

			<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			<div class="single-product-layout__rule"></div>

			<div class="woocommerce-product-details__description">
				<?php the_content(); ?>
			</div>

			<?php woocommerce_template_single_add_to_cart(); ?>

			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_single_product' ); ?>
</div>
