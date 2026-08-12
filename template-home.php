<?php
/**
 * Template Name: Home
 *
 * Assigned automatically to the "Home" page created by the content
 * importer, which is also set as the site's static front page. Renders
 * a fixed structure — hero, services, stats, brand intro — rather than
 * the page's post_content. Text and images are still editable from the
 * normal Edit Page screen via the "Page Content" meta boxes registered
 * in inc/page-content-fields.php (mor_get_page_field() below reads
 * those, falling back to the defaults baked in here when unset).
 */

get_header();

$post_id  = get_queried_object_id();
$shop_url = ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/' );

$hero_image_id = (int) mor_get_page_field( $post_id, 'mor_home_hero_image', 0 );
$hero_image    = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : MOR_THEME_URI . '/assets/images/hero-network-technician.jpg';

$about_image_id = (int) mor_get_page_field( $post_id, 'mor_home_about_image', 0 );
$about_image     = $about_image_id ? wp_get_attachment_image_url( $about_image_id, 'large' ) : MOR_THEME_URI . '/assets/images/brand-intro-server-room.jpg';

$about_heading = mor_get_page_field( $post_id, 'mor_home_about_heading', '' );
if ( '' === $about_heading ) {
	/* translators: %s: company name from Store Details */
	$about_heading = sprintf( __( 'About %s', 'mor-websites' ), mor_get_store_detail( 'company_name' ) );
}

$about_body = mor_get_page_field( $post_id, 'mor_home_about_body', '' );
if ( '' === $about_body ) {
	/* translators: %s: company name from Store Details */
	$about_paragraphs = array(
		sprintf(
			__( '%s is a technology support company based on Nii Amo Street in Osu, Accra, built around a simple idea: most IT problems shouldn\'t take days to fix, and most people shouldn\'t need an in-house IT department to keep their devices, networks, and small business systems running. We work with individuals, home offices, and small-to-medium businesses across Accra who need dependable, fairly priced technical support without the overhead of a full-time hire.', 'mor-websites' ),
			mor_get_store_detail( 'company_name' )
		),
		__( 'Our services cover the everyday reality of running technology in Accra: unreliable networks, ageing laptops, unsecured Wi-Fi, offices that have outgrown their original cabling, and small businesses that need a point-of-sale or booking system that actually works. We offer both remote support — for software issues, security checks, and system tuning that don\'t require anyone on site — and in-person visits for hardware repair, structured cabling, router and network configuration, and CCTV or access-control installation.', 'mor-websites' ),
		__( 'Every service on this site is bookable online: choose what you need, check out, and we\'ll confirm a time that works for you. Pricing is transparent up front — no surprise call-out fees, no vague "contact us for a quote" for standard jobs. Larger or custom projects, like a full office network build-out, are scoped with a short consultation first so you know exactly what you\'re paying for before any work begins.', 'mor-websites' ),
	);
} else {
	$about_paragraphs = preg_split( '/\n\s*\n/', trim( $about_body ) );
}
?>
<main id="primary" class="site-main">

	<section class="hero">
		<img
			class="hero__bg"
			src="<?php echo esc_url( $hero_image ); ?>"
			alt=""
		>
		<div class="container hero__inner">
			<p class="eyebrow"><span class="eyebrow-text"><?php esc_html_e( 'Technology Support Services', 'mor-websites' ); ?></span></p>
			<h1><?php echo esc_html( mor_get_store_detail( 'company_name' ) ); ?></h1>
			<p class="hero__tagline"><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_hero_tagline', __( 'Dependable IT support, network setup, and device repair for homes and businesses across Accra — booked online, delivered on time.', 'mor-websites' ) ) ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--light" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop Now', 'mor-websites' ); ?></a>
				<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="border-color:#fff;color:#fff !important;"><?php esc_html_e( 'Talk to Us', 'mor-websites' ); ?></a>
			</div>
			<dl class="hero__badges">
				<div class="hero__badge">
					<dt><?php esc_html_e( '100%', 'mor-websites' ); ?></dt>
					<dd><?php esc_html_e( 'Bookable Online', 'mor-websites' ); ?></dd>
				</div>
				<div class="hero__badge">
					<dt><?php esc_html_e( 'Remote + On-Site', 'mor-websites' ); ?></dt>
					<dd><?php esc_html_e( 'Support Options', 'mor-websites' ); ?></dd>
				</div>
				<div class="hero__badge">
					<dt><?php esc_html_e( 'Osu, Accra', 'mor-websites' ); ?></dt>
					<dd><?php esc_html_e( 'Based & Accra-Wide', 'mor-websites' ); ?></dd>
				</div>
			</dl>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="section-heading">
				<p class="eyebrow"><span class="eyebrow-text"><?php esc_html_e( 'Our Services', 'mor-websites' ); ?></span></p>
				<h2>
					<?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_services_heading', __( 'IT Support Built For', 'mor-websites' ) ) ); ?>
					<span class="accent-line"><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_services_heading_accent', __( 'How Accra Works', 'mor-websites' ) ) ); ?></span>
				</h2>
				<p><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_services_subheading', __( 'From a single laptop to a full office network, every service below is scoped, priced, and bookable online.', 'mor-websites' ) ) ); ?></p>
			</div>
			<div class="grid grid--3">
				<div class="service-card">
					<span class="service-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="14" width="20" height="8" rx="2"></rect><rect x="6" y="2" width="12" height="8" rx="2"></rect><line x1="6" y1="18" x2="6.01" y2="18"></line><line x1="12" y1="6" x2="12.01" y2="6"></line></svg>
					</span>
					<h3><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_service1_title', __( 'Network Setup & Cabling', 'mor-websites' ) ) ); ?></h3>
					<p><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_service1_desc', __( 'Structured cabling, router and Wi-Fi configuration, and network upgrades for offices that have outgrown their original setup.', 'mor-websites' ) ) ); ?></p>
					<a class="service-card__link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Explore Services →', 'mor-websites' ); ?></a>
					<span class="service-card__index">01</span>
				</div>
				<div class="service-card">
					<span class="service-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
					</span>
					<h3><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_service2_title', __( 'Device & Hardware Repair', 'mor-websites' ) ) ); ?></h3>
					<p><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_service2_desc', __( 'Laptop and desktop repair, security checks, and system tuning — handled remotely when possible, on-site when it isn\'t.', 'mor-websites' ) ) ); ?></p>
					<a class="service-card__link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Explore Services →', 'mor-websites' ); ?></a>
					<span class="service-card__index">02</span>
				</div>
				<div class="service-card">
					<span class="service-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2"></rect></svg>
					</span>
					<h3><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_service3_title', __( 'CCTV & Business Systems', 'mor-websites' ) ) ); ?></h3>
					<p><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_service3_desc', __( 'CCTV, access-control installation, and point-of-sale or booking systems that hold up for small-to-medium businesses.', 'mor-websites' ) ) ); ?></p>
					<a class="service-card__link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Explore Services →', 'mor-websites' ); ?></a>
					<span class="service-card__index">03</span>
				</div>
			</div>
			<p style="text-align:center;margin-top:var(--space-4);">
				<a class="btn btn--outline" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'View All Services', 'mor-websites' ); ?></a>
			</p>
		</div>
	</section>

	<section class="section stats-strip">
		<div class="container">
			<div class="grid grid--3">
				<div class="stat-block">
					<dt><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_stat1_value', __( 'Same-Week', 'mor-websites' ) ) ); ?></dt>
					<dd><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_stat1_label', __( 'Average Turnaround', 'mor-websites' ) ) ); ?></dd>
				</div>
				<div class="stat-block">
					<dt><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_stat2_value', __( 'Transparent', 'mor-websites' ) ) ); ?></dt>
					<dd><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_stat2_label', __( 'Pricing, No Surprise Call-Outs', 'mor-websites' ) ) ); ?></dd>
				</div>
				<div class="stat-block">
					<dt><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_stat3_value', __( 'Homes & SMEs', 'mor-websites' ) ) ); ?></dt>
					<dd><?php echo esc_html( mor_get_page_field( $post_id, 'mor_home_stat3_label', __( 'Across Accra', 'mor-websites' ) ) ); ?></dd>
				</div>
			</div>
		</div>
	</section>

	<section class="section section--subtle">
		<div class="container brand-intro">
			<div class="brand-intro__media">
				<img
					src="<?php echo esc_url( $about_image ); ?>"
					alt="<?php
						printf(
							/* translators: %s: company name from Store Details */
							esc_attr__( '%s technician working on IT infrastructure', 'mor-websites' ),
							esc_attr( mor_get_store_detail( 'company_name' ) )
						);
					?>"
				>
			</div>
			<div class="brand-intro__copy">
				<p class="eyebrow"><span class="eyebrow-text"><?php esc_html_e( 'About Us', 'mor-websites' ); ?></span></p>
				<h2><?php echo esc_html( $about_heading ); ?></h2>
				<?php foreach ( $about_paragraphs as $paragraph ) : ?>
					<p><?php echo esc_html( trim( $paragraph ) ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main>
<?php
get_footer();
