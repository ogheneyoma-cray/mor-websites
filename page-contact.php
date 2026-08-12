<?php
/**
 * Contact page — auto-applied to the page with slug "contact"
 * (created by the content importer). Custom layout: doesn't render
 * the page's post_content, it renders this fixed structure instead.
 * Text is still editable from the normal Edit Page screen via the
 * "Page Content" meta boxes registered in inc/page-content-fields.php.
 */

get_header();

$post_id = get_queried_object_id();
$status  = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';

$business_hours = mor_get_page_field( $post_id, 'mor_contact_hours', '' );
if ( '' === $business_hours ) {
	$business_hours = "Monday – Friday: 8:00 AM – 6:00 PM\nSaturday: 9:00 AM – 3:00 PM\nSunday: Closed (emergency support requests only)";
}
$business_hours_lines = array_filter( array_map( 'trim', explode( "\n", $business_hours ) ) );

$faq_defaults = mor_contact_faq_defaults();
$faqs         = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$question = mor_get_page_field( $post_id, "mor_contact_faq{$i}_q", $faq_defaults[ $i ]['q'] );
	$answer   = mor_get_page_field( $post_id, "mor_contact_faq{$i}_a", $faq_defaults[ $i ]['a'] );
	if ( '' === $question || '' === $answer ) {
		continue;
	}
	$faqs[] = array( 'q' => $question, 'a' => $answer );
}
?>
<main id="primary" class="site-main">

	<section class="hero">
		<div class="container hero__inner">
			<h1><?php echo esc_html( mor_get_page_field( $post_id, 'mor_contact_hero_heading', __( 'Get in Touch', 'mor-websites' ) ) ); ?></h1>
			<p class="hero__tagline"><?php echo esc_html( mor_get_page_field( $post_id, 'mor_contact_hero_tagline', __( 'Questions about a service, an existing job, or a quote — reach us directly or send a message below.', 'mor-websites' ) ) ); ?></p>
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
						<?php foreach ( $business_hours_lines as $i => $line ) : ?>
							<?php echo esc_html( $line ); ?><?php echo $i < count( $business_hours_lines ) - 1 ? '<br>' : ''; ?>
						<?php endforeach; ?>
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
			<?php foreach ( $faqs as $index => $faq ) : ?>
				<details class="faq-item" <?php echo 0 === $index ? 'open' : ''; ?>>
					<summary><?php echo esc_html( $faq['q'] ); ?></summary>
					<p><?php echo esc_html( $faq['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>

</main>
<?php
get_footer();
