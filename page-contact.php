<?php
/**
 * Contact page — auto-applied to the page with slug "contact"
 * (created by the content importer). Custom layout: doesn't render
 * the page's post_content, it renders this fixed structure instead.
 */

get_header();

$status = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
?>
<main id="primary" class="site-main">

	<section class="hero-split">
		<div class="hero-split__media">
			<img src="<?php echo esc_url( MOR_THEME_URI . '/assets/images/brand-intro-fashion.jpg' ); ?>" alt="">
		</div>
		<div class="hero-split__panel">
			<h1>
				<span class="hero-split__eyebrow"><?php esc_html_e( 'Feel Free To', 'mor-websites' ); ?></span>
				<span class="hero-split__accent"><?php esc_html_e( 'Contact Us', 'mor-websites' ); ?></span>
			</h1>
		</div>
	</section>

	<div class="container section">
		<?php if ( 'success' === $status ) : ?>
			<div class="form-notice form-notice--success" role="status">
				<?php esc_html_e( 'Thanks — your message has been sent. We\'ll get back to you shortly.', 'mor-websites' ); ?>
			</div>
		<?php elseif ( 'error' === $status ) : ?>
			<div class="form-notice form-notice--error" role="alert">
				<?php esc_html_e( 'Sorry, something went wrong sending your message. Please check the fields and try again, or email us directly.', 'mor-websites' ); ?>
			</div>
		<?php endif; ?>

		<div class="contact-grid">
			<div class="contact-details">
				<h2><?php esc_html_e( 'Our Office', 'mor-websites' ); ?></h2>
				<dl>
					<dt><?php esc_html_e( 'Address', 'mor-websites' ); ?></dt>
					<dd><?php echo do_shortcode( '[company_address]' ); ?></dd>

					<?php if ( mor_get_store_detail( 'company_phone' ) ) : ?>
						<dt><?php esc_html_e( 'Phone', 'mor-websites' ); ?></dt>
						<dd><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', mor_get_store_detail( 'company_phone' ) ) ); ?>"><?php echo do_shortcode( '[company_phone]' ); ?></a></dd>
					<?php endif; ?>

					<?php if ( mor_get_store_detail( 'company_email' ) ) : ?>
						<dt><?php esc_html_e( 'Email', 'mor-websites' ); ?></dt>
						<dd><a href="mailto:<?php echo esc_attr( mor_get_store_detail( 'company_email' ) ); ?>"><?php echo do_shortcode( '[company_email]' ); ?></a></dd>
					<?php endif; ?>

					<dt><?php esc_html_e( 'Business Hours', 'mor-websites' ); ?></dt>
					<dd>
						<?php esc_html_e( 'Monday – Saturday: 9:00 AM – 7:00 PM', 'mor-websites' ); ?><br>
						<?php esc_html_e( 'Sunday: Closed', 'mor-websites' ); ?>
					</dd>
				</dl>
			</div>

			<div>
				<p class="hero-split__eyebrow" style="font-style:italic;color:var(--color-text-muted);margin-bottom:var(--space-2);"><?php esc_html_e( "Don't hesitate to fill in the form & we'll reply as soon as possible.", 'mor-websites' ); ?></p>
				<?php mor_render_contact_form(); ?>
			</div>
		</div>
	</div>

</main>
<?php
get_footer();
