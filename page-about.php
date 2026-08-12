<?php
/**
 * About Us page — auto-applied to the page with slug "about"
 * (created by the content importer). Custom layout: doesn't render
 * the page's post_content, it renders this fixed structure instead.
 */

get_header();
?>
<main id="primary" class="site-main">

	<section class="page-hero">
		<div class="container">
			<p class="label-caps"><?php esc_html_e( 'About Us', 'mor-websites' ); ?></p>
			<h1><?php echo esc_html( mor_get_store_detail( 'company_name' ) ); ?></h1>
			<p class="page-hero__tagline"><?php esc_html_e( 'A fashion retailer built in Accra, for the way Accra actually gets dressed.', 'mor-websites' ); ?></p>
		</div>
	</section>

	<section class="section">
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
				<h2><?php esc_html_e( 'Our Story', 'mor-websites' ); ?></h2>
				<p>
					<?php
					printf(
						/* translators: %s: company name from Store Details */
						esc_html__(
							'%s started with a simple frustration: too many online stores selling to Ghana either import a small, overpriced selection or ship generic basics that could belong to anyone. We wanted a store that felt considered — real pieces for real bodies, styled and described honestly, at prices that make sense for a weekly wardrobe update rather than a once-a-year splurge.', 'mor-websites' ),
						mor_get_store_detail( 'company_name' )
					);
					?>
				</p>
				<p><?php esc_html_e( 'We\'re based on Lampshade Lane in Anyaa, Accra, and every order is packed and dispatched from there. Our buying team sources a rotating edit of men\'s and women\'s clothing — tailored shirts and blazers, denim, printed dresses, outerwear, and the bags and scarves that finish a look — instead of an endless, overwhelming scroll of near-identical basics.', 'mor-websites' ); ?></p>
				<p><?php esc_html_e( 'We keep the fundamentals simple: transparent pricing in Ghanaian Cedis, honest product photography and descriptions, and a straightforward 14-day returns window if something isn\'t right. Whether you shop with us once or every week, we want the experience to feel like it was built by people who actually think about what they wear.', 'mor-websites' ); ?></p>
			</div>
		</div>
	</section>

	<section class="section section--dark">
		<div class="container">
			<div class="section-heading">
				<div class="section-heading__rule" style="background:#fff;"></div>
				<h2><?php esc_html_e( 'What We Stand For', 'mor-websites' ); ?></h2>
			</div>
			<div class="grid grid--3">
				<div>
					<h3 style="color:#fff;"><?php esc_html_e( 'Considered, Not Endless', 'mor-websites' ); ?></h3>
					<p style="color:rgba(255,255,255,0.75);"><?php esc_html_e( 'New arrivals land in small drops rather than a flood of near-identical items, so every product is something we\'d actually stock in a physical shop.', 'mor-websites' ); ?></p>
				</div>
				<div>
					<h3 style="color:#fff;"><?php esc_html_e( 'Honest Product Pages', 'mor-websites' ); ?></h3>
					<p style="color:rgba(255,255,255,0.75);"><?php esc_html_e( 'Real measurements, real fabric details, and photography that matches what actually arrives at your door — no surprises at checkout.', 'mor-websites' ); ?></p>
				</div>
				<div>
					<h3 style="color:#fff;"><?php esc_html_e( 'Built For Accra', 'mor-websites' ); ?></h3>
					<p style="color:rgba(255,255,255,0.75);"><?php esc_html_e( 'Same-day dispatch, fast delivery across Greater Accra, and a returns process that doesn\'t punish you for ordering the wrong size.', 'mor-websites' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container" style="text-align:center;">
			<h2><?php esc_html_e( 'Ready to Shop?', 'mor-websites' ); ?></h2>
			<p style="color:var(--color-text-muted);max-width:52ch;margin-inline:auto;"><?php esc_html_e( 'New arrivals land every week — see what\'s in this week\'s drop.', 'mor-websites' ); ?></p>
			<p style="margin-top:var(--space-3);">
				<a class="btn" href="<?php echo esc_url( ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Shop Now', 'mor-websites' ); ?></a>
			</p>
		</div>
	</section>

</main>
<?php
get_footer();
