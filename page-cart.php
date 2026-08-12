<?php
/**
 * Cart page — auto-applied by WordPress's template hierarchy to the page
 * with slug "cart" (WooCommerce's own cart page, created by
 * WC_Install::create_pages()). Renders a branded hero instead of falling
 * back to the generic page.php (which is built for the legal pages and
 * wraps content in a narrow, "Last updated" styled column unsuited to a
 * cart table). the_content() below still runs the [woocommerce_cart]
 * shortcode WooCommerce put in this page's content — no cart logic is
 * reimplemented here.
 */

get_header();
?>
<main id="primary" class="site-main woocommerce-main">

	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><span class="eyebrow-text"><?php esc_html_e( 'Your Cart', 'mor-websites' ); ?></span></p>
			<h1><?php esc_html_e( 'Review Your Booking', 'mor-websites' ); ?></h1>
			<p class="page-hero__tagline"><?php esc_html_e( 'Confirm the services you\'ve selected below, then proceed to checkout — payment always completes in Ghanaian Cedis (GHS).', 'mor-websites' ); ?></p>
		</div>
	</section>

	<div class="container section">
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
