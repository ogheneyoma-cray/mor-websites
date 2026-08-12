<?php
/**
 * Template Name: Home
 *
 * Assigned automatically to the "Home" page created by the content
 * importer, which is also set as the site's static front page. Renders
 * a fixed structure — hero, featured services, brand intro — rather
 * than the page's post_content.
 */

get_header();

$shop_url  = ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/' );
$featured  = array();

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

	<section class="hero">
		<img
			class="hero__bg"
			src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/hero-network-technician.jpg' ); ?>"
			alt=""
		>
		<div class="container hero__inner">
			<h1><?php echo esc_html( mor_get_store_detail( 'company_name' ) ); ?></h1>
			<p class="hero__tagline"><?php esc_html_e( 'Dependable IT support, network setup, and device repair for homes and businesses across Accra — booked online, delivered on time.', 'mor-websites' ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--light" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop Now', 'mor-websites' ); ?></a>
				<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="border-color:#fff;color:#fff !important;"><?php esc_html_e( 'Talk to Us', 'mor-websites' ); ?></a>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $featured ) ) : ?>
	<section class="section">
		<div class="container">
			<div class="section-heading">
				<h2><?php esc_html_e( 'Popular Services', 'mor-websites' ); ?></h2>
				<p><?php esc_html_e( 'A few of the services our clients book most often.', 'mor-websites' ); ?></p>
			</div>
			<div class="grid grid--3">
				<?php foreach ( $featured as $product ) : ?>
					<div class="card">
						<a class="card__media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo wp_kses_post( $product->get_image( 'medium' ) ); ?>
						</a>
						<div class="card__body">
							<h3 class="card__title"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
							<div class="card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
							<a class="btn" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"><?php esc_html_e( 'Add to Cart', 'mor-websites' ); ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<p style="text-align:center;margin-top:var(--space-4);">
				<a class="btn btn--outline" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'View All Services', 'mor-websites' ); ?></a>
			</p>
		</div>
	</section>
	<?php endif; ?>

	<section class="section section--subtle">
		<div class="container brand-intro">
			<div class="brand-intro__media">
				<img
					src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/brand-intro-server-room.jpg' ); ?>"
					alt="<?php esc_attr_e( 'DigitalDrum Networks technician working on IT infrastructure', 'mor-websites' ); ?>"
				>
			</div>
			<div class="brand-intro__copy">
				<h2><?php esc_html_e( 'About DigitalDrum Networks', 'mor-websites' ); ?></h2>
				<p>
					<?php
					esc_html_e(
						'DigitalDrum Networks is a technology support company based on Nii Amo Street in Osu, Accra, built around a simple idea: most IT problems shouldn\'t take days to fix, and most people shouldn\'t need an in-house IT department to keep their devices, networks, and small business systems running. We work with individuals, home offices, and small-to-medium businesses across Accra who need dependable, fairly priced technical support without the overhead of a full-time hire.',
						'mor-websites'
					);
					?>
				</p>
				<p>
					<?php
					esc_html_e(
						'Our services cover the everyday reality of running technology in Accra: unreliable networks, ageing laptops, unsecured Wi-Fi, offices that have outgrown their original cabling, and small businesses that need a point-of-sale or booking system that actually works. We offer both remote support — for software issues, security checks, and system tuning that don\'t require anyone on site — and in-person visits for hardware repair, structured cabling, router and network configuration, and CCTV or access-control installation.',
						'mor-websites'
					);
					?>
				</p>
				<p>
					<?php
					esc_html_e(
						'Every service on this site is bookable online: choose what you need, check out, and we\'ll confirm a time that works for you. Pricing is transparent up front — no surprise call-out fees, no vague "contact us for a quote" for standard jobs. Larger or custom projects, like a full office network build-out, are scoped with a short consultation first so you know exactly what you\'re paying for before any work begins.',
						'mor-websites'
					);
					?>
				</p>
			</div>
		</div>
	</section>

</main>
<?php
get_footer();
