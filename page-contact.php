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

	<section class="hero">
		<div class="container hero__inner">
			<h1><?php esc_html_e( 'Get in Touch', 'mor-websites' ); ?></h1>
			<p class="hero__tagline"><?php esc_html_e( 'Questions about a service, an existing job, or a quote — reach us directly or send a message below.', 'mor-websites' ); ?></p>
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
			<div>
				<h2><?php esc_html_e( 'Send a Message', 'mor-websites' ); ?></h2>
				<?php mor_render_contact_form(); ?>
			</div>

			<div class="contact-details">
				<h2><?php esc_html_e( 'Store Details', 'mor-websites' ); ?></h2>
				<dl>
					<dt><?php esc_html_e( 'Address', 'mor-websites' ); ?></dt>
					<dd><?php echo do_shortcode( '[company_address]' ); ?></dd>

					<dt><?php esc_html_e( 'Phone', 'mor-websites' ); ?></dt>
					<dd><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', mor_get_store_detail( 'company_phone' ) ) ); ?>"><?php echo do_shortcode( '[company_phone]' ); ?></a></dd>

					<dt><?php esc_html_e( 'Email', 'mor-websites' ); ?></dt>
					<dd><a href="mailto:<?php echo esc_attr( mor_get_store_detail( 'company_email' ) ); ?>"><?php echo do_shortcode( '[company_email]' ); ?></a></dd>

					<dt><?php esc_html_e( 'Business Hours', 'mor-websites' ); ?></dt>
					<dd>
						<?php esc_html_e( 'Monday – Friday: 8:00 AM – 6:00 PM', 'mor-websites' ); ?><br>
						<?php esc_html_e( 'Saturday: 9:00 AM – 3:00 PM', 'mor-websites' ); ?><br>
						<?php esc_html_e( 'Sunday: Closed (emergency support requests only)', 'mor-websites' ); ?>
					</dd>
				</dl>
			</div>
		</div>
	</div>

	<div class="container section section--faq">
		<div class="section-heading">
			<h2><?php esc_html_e( 'Frequently Asked Questions', 'mor-websites' ); ?></h2>
			<p><?php esc_html_e( 'Answers to the questions we get asked most before a booking.', 'mor-websites' ); ?></p>
		</div>

		<div class="faq-list">
			<details class="faq-item" open>
				<summary><?php esc_html_e( 'How quickly can you respond to a service request?', 'mor-websites' ); ?></summary>
				<p><?php esc_html_e( 'Remote support requests submitted during business hours are typically picked up within 2 hours. On-site visits within Accra are usually scheduled within 24–48 hours of confirming your booking, depending on the service and technician availability. If you flag a request as urgent, we prioritise a same-day response wherever possible, though this cannot always be guaranteed outside business hours.', 'mor-websites' ); ?></p>
			</details>
			<details class="faq-item">
				<summary><?php esc_html_e( 'Can I cancel or reschedule a booked service?', 'mor-websites' ); ?></summary>
				<p><?php esc_html_e( 'Yes. You can cancel or reschedule any booked service package free of charge up to 24 hours before the scheduled appointment. Cancellations made with less than 24 hours\' notice, or missed appointments where our technician arrives on site and cannot gain access, may be subject to a call-out fee. Full details are in our Refunds & Cancellation Policy.', 'mor-websites' ); ?></p>
			</details>
			<details class="faq-item">
				<summary><?php esc_html_e( 'Do you provide remote support or only on-site visits?', 'mor-websites' ); ?></summary>
				<p><?php esc_html_e( 'Both. Many of our services — software troubleshooting, network configuration, security audits, and system optimisation — can be delivered remotely over a secure remote-desktop session. Hardware repairs, in-office network cabling, and CCTV/access-control installation require an on-site visit, which we currently offer within Accra and surrounding areas.', 'mor-websites' ); ?></p>
			</details>
			<details class="faq-item">
				<summary><?php esc_html_e( 'What payment methods do you accept?', 'mor-websites' ); ?></summary>
				<p><?php esc_html_e( 'Checkout accepts payment in Ghanaian Cedis (GHS). The specific payment gateways enabled (mobile money, card, or bank transfer) are configured directly in WooCommerce and may vary as we add providers — the checkout page will always show the options currently available at the time you book.', 'mor-websites' ); ?></p>
			</details>
			<details class="faq-item">
				<summary><?php esc_html_e( 'How do I track the status of my service request?', 'mor-websites' ); ?></summary>
				<p><?php esc_html_e( 'After checkout you\'ll receive an order confirmation by email with your booking reference. You can also log in to your account and view "My Account > Orders" at any time to see the current status of a booking. If a visit needs to be rescheduled on our side, we\'ll contact you directly using the phone number or email provided at checkout.', 'mor-websites' ); ?></p>
			</details>
		</div>
	</div>

</main>
<?php
get_footer();
