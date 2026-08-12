<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
	<div class="container site-header__inner">
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( mor_get_store_detail( 'company_name' ) ); ?></a>
		</div>

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'mor-websites' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => '',
					)
				);
			} else {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'mor-websites' ); ?></a></li>
					<?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Shop', 'mor-websites' ); ?></a></li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'mor-websites' ); ?></a></li>
				</ul>
				<?php
			}
			?>
		</nav>

		<div class="header-actions">
			<div class="currency-switcher" role="group" aria-label="<?php esc_attr_e( 'Currency display', 'mor-websites' ); ?>">
				<button type="button" data-currency="ghs" aria-pressed="true">GH₵ GHS</button>
				<button type="button" data-currency="usd" aria-pressed="false">$ USD</button>
			</div>

			<?php if ( ! mor_woocommerce_is_missing() && function_exists( 'wc_get_page_id' ) ) : ?>
				<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'View cart', 'mor-websites' ); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
					<span class="cart-contents__count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
				</a>
			<?php endif; ?>

			<button type="button" class="menu-toggle" aria-controls="mobile-navigation" aria-expanded="false">
				<span class="visually-hidden"><?php esc_html_e( 'Menu', 'mor-websites' ); ?></span>
			</button>
		</div>
	</div>

	<div class="mobile-nav" id="mobile-navigation">
		<ul>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'mor-websites' ); ?></a></li>
			<?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
				<li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Shop', 'mor-websites' ); ?></a></li>
			<?php endif; ?>
			<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'mor-websites' ); ?></a></li>
		</ul>
		<p class="currency-note"><?php esc_html_e( 'Prices shown in USD are for reference only — checkout always completes in Ghanaian Cedis (GHS).', 'mor-websites' ); ?></p>
	</div>
</header>
