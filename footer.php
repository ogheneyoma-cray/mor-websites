<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer id="colophon" class="site-footer">
	<div class="container">
		<div class="footer-grid footer-grid--4">
			<div>
				<h3><?php echo esc_html( mor_get_store_detail( 'company_name' ) ); ?></h3>
				<p><?php esc_html_e( 'Contemporary fashion for men and women, shipped across Ghana.', 'mor-websites' ); ?></p>
			</div>

			<div>
				<h3><?php esc_html_e( 'Quick Links', 'mor-websites' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'mor-websites' ); ?></a></li>
					<?php if ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Shop', 'mor-websites' ); ?></a></li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'mor-websites' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'mor-websites' ); ?></a></li>
				</ul>
			</div>

			<div>
				<h3><?php esc_html_e( 'Legal', 'mor-websites' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>"><?php esc_html_e( 'Shipping Policy', 'mor-websites' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'mor-websites' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms-and-conditions/' ) ); ?>"><?php esc_html_e( 'Terms and Conditions', 'mor-websites' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/refunds-policy/' ) ); ?>"><?php esc_html_e( 'Refunds Policy', 'mor-websites' ); ?></a></li>
				</ul>
			</div>

			<div>
				<h3><?php esc_html_e( 'Contact', 'mor-websites' ); ?></h3>
				<ul>
					<li><?php echo do_shortcode( '[company_address]' ); ?></li>
					<?php if ( mor_get_store_detail( 'company_phone' ) ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', mor_get_store_detail( 'company_phone' ) ) ); ?>"><?php echo do_shortcode( '[company_phone]' ); ?></a></li>
					<?php endif; ?>
					<?php if ( mor_get_store_detail( 'company_email' ) ) : ?>
						<li><a href="mailto:<?php echo esc_attr( mor_get_store_detail( 'company_email' ) ); ?>"><?php echo do_shortcode( '[company_email]' ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="site-footer__bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( mor_get_store_detail( 'company_name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'mor-websites' ); ?></p>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
