<?php
/**
 * This theme requires WooCommerce. Never fatal — if it's missing or
 * inactive, show an admin notice and skip all WooCommerce-dependent
 * theme code instead of crashing the site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_woocommerce_is_missing() {
	return ! class_exists( 'WooCommerce' );
}

function mor_woocommerce_missing_notice() {
	if ( ! mor_woocommerce_is_missing() || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-error">
		<p>
			<?php
			printf(
				/* translators: %s: theme name */
				esc_html__( 'The "%s" theme requires WooCommerce to be installed and active. Store pages (Shop, Cart, Checkout, product import) will not work until it is activated.', 'mor-websites' ),
				esc_html( wp_get_theme()->get( 'Name' ) )
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'mor_woocommerce_missing_notice' );
