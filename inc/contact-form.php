<?php
/**
 * Self-contained contact form: renders the fields, verifies the nonce,
 * sanitizes input, and sends via wp_mail() — no form plugin involved.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOR_CONTACT_FORM_ACTION', 'mor_submit_contact_form' );

function mor_render_contact_form() {
	?>
	<form method="post" class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="<?php echo esc_attr( MOR_CONTACT_FORM_ACTION ); ?>">
		<?php wp_nonce_field( MOR_CONTACT_FORM_ACTION, 'mor_contact_form_nonce' ); ?>

		<div class="contact-form__row">
			<div class="form-field">
				<label for="mor-contact-name"><?php esc_html_e( 'Your Name', 'mor-websites' ); ?></label>
				<input type="text" id="mor-contact-name" name="mor_contact_name" required>
			</div>

			<div class="form-field">
				<label for="mor-contact-email"><?php esc_html_e( 'Your Email', 'mor-websites' ); ?></label>
				<input type="email" id="mor-contact-email" name="mor_contact_email" required>
			</div>
		</div>

		<div class="form-field">
			<label for="mor-contact-subject"><?php esc_html_e( 'Subject', 'mor-websites' ); ?></label>
			<input type="text" id="mor-contact-subject" name="mor_contact_subject">
		</div>

		<div class="form-field">
			<label for="mor-contact-message"><?php esc_html_e( 'Your Message', 'mor-websites' ); ?></label>
			<textarea id="mor-contact-message" name="mor_contact_message" required></textarea>
		</div>

		<!-- honeypot: real visitors never see or fill this field -->
		<div class="visually-hidden" aria-hidden="true">
			<label for="mor-contact-website"><?php esc_html_e( 'Website', 'mor-websites' ); ?></label>
			<input type="text" id="mor-contact-website" name="mor_contact_website" tabindex="-1" autocomplete="off">
		</div>

		<button type="submit" class="btn"><?php esc_html_e( 'Send', 'mor-websites' ); ?> →</button>
	</form>
	<?php
}

function mor_handle_contact_form() {
	if ( ! isset( $_POST['mor_contact_form_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['mor_contact_form_nonce'] ), MOR_CONTACT_FORM_ACTION ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', home_url( '/contact/' ) ) );
		exit;
	}

	// Honeypot: a filled hidden field means a bot submitted the form.
	if ( ! empty( $_POST['mor_contact_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'success', home_url( '/contact/' ) ) );
		exit;
	}

	$name    = isset( $_POST['mor_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mor_contact_name'] ) ) : '';
	$email   = isset( $_POST['mor_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['mor_contact_email'] ) ) : '';
	$subject = isset( $_POST['mor_contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['mor_contact_subject'] ) ) : '';
	$message = isset( $_POST['mor_contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mor_contact_message'] ) ) : '';

	if ( '' === $name || '' === $email || ! is_email( $email ) || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', home_url( '/contact/' ) ) );
		exit;
	}

	$to           = mor_get_store_detail( 'company_email' );
	$email_subject = '' !== $subject
		? $subject
		/* translators: %s: sender name */
		: sprintf( __( 'New contact form message from %s', 'mor-websites' ), $name );
	$body = sprintf(
		"Name: %s\nEmail: %s\n\nMessage:\n%s",
		$name,
		$email,
		$message
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $email_subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'success' : 'error', home_url( '/contact/' ) ) );
	exit;
}
add_action( 'admin_post_' . MOR_CONTACT_FORM_ACTION, 'mor_handle_contact_form' );
add_action( 'admin_post_nopriv_' . MOR_CONTACT_FORM_ACTION, 'mor_handle_contact_form' );
