<?php
/**
 * Checkout page — auto-applied by WordPress's template hierarchy to the
 * page with slug "checkout" (WooCommerce's own checkout page). Renders a
 * branded hero instead of falling back to the generic page.php. The
 * order-received (thank-you) view is also served through this same page,
 * so the hero copy adapts for that case.
 *
 * the_content() runs the [woocommerce_checkout] shortcode WooCommerce put
 * in this page's content — this theme keeps the classic shortcode-based
 * checkout (see inc/woocommerce-support.php) rather than the block
 * checkout editor, and no payment/card form is built here; gateway setup
 * happens separately.
 */

get_header();

$is_order_received = function_exists( 'is_order_received_page' ) && is_order_received_page();
?>
<main id="primary" class="site-main woocommerce-main">

	<?php if ( ! $is_order_received ) : ?>
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><span class="eyebrow-text"><?php esc_html_e( 'Checkout', 'mor-websites' ); ?></span></p>
			<h1><?php esc_html_e( 'Complete Your Booking', 'mor-websites' ); ?></h1>
			<p class="page-hero__tagline"><?php esc_html_e( 'Enter your details below — pricing is transparent, with no surprise call-out fees added at this step.', 'mor-websites' ); ?></p>
		</div>
	</section>
	<?php endif; ?>

	<div class="<?php echo $is_order_received ? '' : 'container section'; ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>

</main>
<?php
get_footer();
