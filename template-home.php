<?php
/**
 * Template Name: Home
 *
 * Assigned automatically to the "Home" page created by the content
 * importer, which is also set as the site's static front page. Renders
 * a fixed structure — hero, featured products, category promos, brand
 * intro — rather than the page's post_content.
 */

get_header();

$shop_url = ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/' );
$featured = array();

if ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_products' ) ) {
	$featured = wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => 6,
			'orderby' => 'date',
			'order'   => 'DESC',
		)
	);
}
?>
<main id="primary" class="site-main">

	<section class="hero-split">
		<div class="hero-split__media">
			<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/hero-fashion-editorial.jpg' ); ?>" alt="">
		</div>
		<div class="hero-split__panel">
			<h1>
				<span class="hero-split__eyebrow"><?php esc_html_e( 'Brand New', 'mor-websites' ); ?></span>
				<span class="hero-split__accent"><?php esc_html_e( 'Vibes', 'mor-websites' ); ?></span>
			</h1>
			<p class="hero-split__tagline"><?php esc_html_e( 'Contemporary clothing for men and women — new arrivals every week, shipped across Ghana.', 'mor-websites' ); ?></p>
			<div class="hero-split__actions">
				<a class="btn" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop Now', 'mor-websites' ); ?></a>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $featured ) ) : ?>
	<section class="section">
		<div class="container">
			<div class="section-heading">
				<div class="section-heading__rule"></div>
				<h2><?php esc_html_e( 'Shop The Latest', 'mor-websites' ); ?></h2>
			</div>
			<div class="grid grid--3">
				<?php foreach ( $featured as $product ) : ?>
					<div class="product-card">
						<a class="product-card__media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo wp_kses_post( $product->get_image( 'medium' ) ); ?>
						</a>
						<h3 class="product-card__title"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
						<div class="product-card__rule"></div>
						<div class="product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
						<div class="product-card__cta">
							<a class="btn btn--outline" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"><?php esc_html_e( 'Add to Cart', 'mor-websites' ); ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<p style="text-align:center;margin-top:var(--space-4);">
				<a class="btn btn--outline" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'View All Products', 'mor-websites' ); ?></a>
			</p>
		</div>
	</section>
	<?php endif; ?>

	<section class="category-promo">
		<div class="category-promo__media">
			<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/promo-womens-collection.jpg' ); ?>" alt="<?php esc_attr_e( "Women's collection", 'mor-websites' ); ?>">
		</div>
		<div class="category-promo__copy">
			<h2 class="category-promo__heading"><?php esc_html_e( 'Explore', 'mor-websites' ); ?> <span class="accent"><?php esc_html_e( "Women's Collection", 'mor-websites' ); ?></span></h2>
			<div class="category-promo__rule"></div>
			<p class="category-promo__desc"><?php esc_html_e( "Minimal silhouettes, bold tailoring, and everyday pieces built for movement.", 'mor-websites' ); ?></p>
			<a class="btn" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop Women', 'mor-websites' ); ?></a>
		</div>
	</section>

	<section class="category-promo category-promo--reverse">
		<div class="category-promo__media">
			<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/promo-mens-collection.jpg' ); ?>" alt="<?php esc_attr_e( "Men's collection", 'mor-websites' ); ?>">
		</div>
		<div class="category-promo__copy">
			<h2 class="category-promo__heading"><?php esc_html_e( 'Discover', 'mor-websites' ); ?> <span class="accent"><?php esc_html_e( "Men's Collection", 'mor-websites' ); ?></span></h2>
			<div class="category-promo__rule"></div>
			<p class="category-promo__desc"><?php esc_html_e( 'Sharp shirting, easy denim, and layers built for Accra\'s pace.', 'mor-websites' ); ?></p>
			<a class="btn" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop Men', 'mor-websites' ); ?></a>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="section-heading">
				<div class="section-heading__rule"></div>
				<h2><?php esc_html_e( 'Mix & Match', 'mor-websites' ); ?></h2>
			</div>
			<div class="tile-grid">
				<div class="tile">
					<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/tile-cardigans.jpg' ); ?>" alt="">
					<span class="tile__label"><?php esc_html_e( 'Cardigans', 'mor-websites' ); ?></span>
				</div>
				<div class="tile">
					<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/tile-trousers.jpg' ); ?>" alt="">
					<span class="tile__label"><?php esc_html_e( 'Trousers', 'mor-websites' ); ?></span>
				</div>
				<div class="tile">
					<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/tile-bags.jpg' ); ?>" alt="">
					<span class="tile__label"><?php esc_html_e( 'Bags', 'mor-websites' ); ?></span>
				</div>
				<div class="tile">
					<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/tile-scarves.jpg' ); ?>" alt="">
					<span class="tile__label"><?php esc_html_e( 'Scarves & Shawls', 'mor-websites' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<section class="section section--subtle">
		<div class="container brand-intro">
			<div class="brand-intro__media">
				<img
					src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/brand-intro-fashion.jpg' ); ?>"
					alt="<?php
						printf(
							/* translators: %s: company name from Store Details */
							esc_attr__( '%s styled look', 'mor-websites' ),
							esc_attr( mor_get_store_detail( 'company_name' ) )
						);
					?>"
				>
			</div>
			<div class="brand-intro__copy">
				<h2>
					<?php
					printf(
						/* translators: %s: company name from Store Details */
						esc_html__( 'About %s', 'mor-websites' ),
						esc_html( mor_get_store_detail( 'company_name' ) )
					);
					?>
				</h2>
				<p>
					<?php
					printf(
						/* translators: %s: company name from Store Details */
						esc_html__(
							'%s is a fashion retailer based in Anyaa, Accra, built for people who want clothes that actually fit into daily life — not just a lookbook. We stock a rotating edit of men\'s and women\'s pieces: tailored shirts and blazers, everyday denim, printed dresses, and the outerwear and accessories that pull an outfit together. Every product on this site is styled, described honestly (including how it fits and what it\'s made of), and photographed so you know exactly what\'s arriving at your door.', 'mor-websites' ),
						mor_get_store_detail( 'company_name' )
					);
					?>
				</p>
				<p>
					<?php esc_html_e( 'We keep the range focused rather than overwhelming — new arrivals land in small, considered drops instead of an endless scroll of near-identical basics. Prices are shown in Ghanaian Cedis, with an optional USD reference toggle for anyone budgeting in another currency, though checkout always completes in GHS.', 'mor-websites' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Orders placed before 3:00 PM ship the same or next business day, with delivery across Accra typically within 1–2 days and nationwide delivery within a week. If something isn\'t right, our 14-day returns window makes it straightforward to send back or exchange — details are on our Shipping and Refunds pages.', 'mor-websites' ); ?>
				</p>
			</div>
		</div>
	</section>

</main>
<?php
get_footer();
