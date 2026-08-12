<?php
/**
 * Self-contained contact form: render + admin-post handler + wp_mail.
 * No plugin, no external form service. Nonce-verified, sanitized input,
 * escaped output throughout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'MOR_CONTACT_ACTION' ) ) {
	define( 'MOR_CONTACT_ACTION', 'mor_contact_submit' );
}

function mor_render_contact_form() {
	$nonce_action = MOR_CONTACT_ACTION;
	?>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="contact-form">
		<input type="hidden" name="action" value="<?php echo esc_attr( MOR_CONTACT_ACTION ); ?>">
		<?php wp_nonce_field( $nonce_action, 'mor_contact_nonce' ); ?>

		<div class="form-field">
			<label for="mor_contact_name"><?php esc_html_e( 'Name', 'mor-websites' ); ?></label>
			<input type="text" id="mor_contact_name" name="mor_contact_name" required maxlength="150">
		</div>

		<div class="form-field">
			<label for="mor_contact_email"><?php esc_html_e( 'Email', 'mor-websites' ); ?></label>
			<input type="email" id="mor_contact_email" name="mor_contact_email" required maxlength="150">
		</div>

		<div class="form-field">
			<label for="mor_contact_message"><?php esc_html_e( 'Message', 'mor-websites' ); ?></label>
			<textarea id="mor_contact_message" name="mor_contact_message" required maxlength="3000"></textarea>
		</div>

		<?php
		// Honeypot — hidden from real users via CSS, catches simple bots.
		// Not a substitute for the nonce check, just cheap extra friction.
		?>
		<div class="form-field" style="position:absolute;left:-9999px;" aria-hidden="true">
			<label for="mor_contact_website">Website</label>
			<input type="text" id="mor_contact_website" name="mor_contact_website" tabindex="-1" autocomplete="off">
		</div>

		<button type="submit" class="btn"><?php esc_html_e( 'Send Message', 'mor-websites' ); ?></button>
	</form>
	<?php
}

function mor_handle_contact_submit() {
	if ( ! isset( $_POST['mor_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mor_contact_nonce'] ) ), MOR_CONTACT_ACTION ) ) {
		wp_die( esc_html__( 'Security check failed. Please go back and try again.', 'mor-websites' ) );
	}

	// Honeypot filled in => silently treat as success without sending mail.
	if ( ! empty( $_POST['mor_contact_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'success', home_url( '/contact/' ) ) );
		exit;
	}

	$name    = isset( $_POST['mor_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mor_contact_name'] ) ) : '';
	$email   = isset( $_POST['mor_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['mor_contact_email'] ) ) : '';
	$message = isset( $_POST['mor_contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mor_contact_message'] ) ) : '';

	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', home_url( '/contact/' ) ) );
		exit;
	}

	$to      = mor_get_store_detail( 'company_email' );
	$subject = sprintf(
		/* translators: %s: site name */
		__( 'New contact form message — %s', 'mor-websites' ),
		mor_get_store_detail( 'company_name' )
	);

	$body  = sprintf( "%s: %s\n", __( 'Name', 'mor-websites' ), $name ) . "\n";
	$body .= sprintf( "%s: %s\n", __( 'Email', 'mor-websites' ), $email ) . "\n";
	$body .= sprintf( "%s:\n%s\n", __( 'Message', 'mor-websites' ), $message );

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'success' : 'error', home_url( '/contact/' ) ) );
	exit;
}
add_action( 'admin_post_' . MOR_CONTACT_ACTION, 'mor_handle_contact_submit' );
add_action( 'admin_post_nopriv_' . MOR_CONTACT_ACTION, 'mor_handle_contact_submit' );
