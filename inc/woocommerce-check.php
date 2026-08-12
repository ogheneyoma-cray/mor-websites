<?php
/**
 * Guards against WooCommerce being inactive — this theme requires it,
 * but must never fatal-error; deactivate gracefully with an admin
 * notice instead.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_woocommerce_is_missing() {
	return ! class_exists( 'WooCommerce' );
}

function mor_woocommerce_missing_notice() {
	if ( ! mor_woocommerce_is_missing() ) {
		return;
	}
	?>
	<div class="notice notice-error">
		<p>
			<?php esc_html_e( 'The Fusion Cart theme requires WooCommerce to be installed and active. Please install and activate WooCommerce.', 'mor-websites' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'mor_woocommerce_missing_notice' );
