<?php
/**
 * "Import Store Content" admin page under Appearance.
 *
 * Two explicit, admin-triggered import routines (never auto-run on
 * theme activation):
 *  - Import Products: creates 20 real WooCommerce products via CRUD
 *    methods (WC_Product_Simple), matched by SKU so it's safe to click
 *    more than once — existing SKUs are skipped, not duplicated.
 *  - Import Pages: creates the Home, Contact, and 4 legal pages via
 *    wp_insert_post(), matched by slug so it's safe to click more than
 *    once. Also nudges WooCommerce to (re)create its own Shop/Cart/
 *    Checkout/My Account pages if they're missing.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once MOR_THEME_DIR . '/inc/data/products.php';
require_once MOR_THEME_DIR . '/inc/data/legal-pages.php';

define( 'MOR_IMPORT_SERVICES_ACTION', 'mor_import_services' );
define( 'MOR_IMPORT_PAGES_ACTION', 'mor_import_pages' );

function mor_register_import_page() {
	add_theme_page(
		__( 'Import Store Products', 'mor-websites' ),
		__( 'Import Store Products', 'mor-websites' ),
		'manage_woocommerce',
		'mor-import-store-content',
		'mor_render_import_page'
	);
}
add_action( 'admin_menu', 'mor_register_import_page' );

function mor_render_import_page() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}

	$services_result = get_transient( 'mor_import_services_result' );
	$pages_result    = get_transient( 'mor_import_pages_result' );
	delete_transient( 'mor_import_services_result' );
	delete_transient( 'mor_import_pages_result' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Import Store Products', 'mor-websites' ); ?></h1>

		<?php if ( mor_woocommerce_is_missing() ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'WooCommerce must be active before importing products.', 'mor-websites' ); ?></p></div>
			</div>
			<?php return; ?>
		<?php endif; ?>

		<?php if ( $services_result ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php echo esc_html( $services_result ); ?></p></div>
		<?php endif; ?>
		<?php if ( $pages_result ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php echo esc_html( $pages_result ); ?></p></div>
		<?php endif; ?>

		<div class="card" style="max-width:640px;padding:1.5rem;margin-top:1rem;">
			<h2><?php esc_html_e( 'Products (WooCommerce Products)', 'mor-websites' ); ?></h2>
			<p>
				<?php
				printf(
					/* translators: %s: company name from Store Details */
					esc_html__( 'Creates the 20 %s products, with images. Safe to click more than once — existing products (matched by SKU) are skipped, never duplicated.', 'mor-websites' ),
					esc_html( mor_get_store_detail( 'company_name' ) )
				);
				?>
			</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="<?php echo esc_attr( MOR_IMPORT_SERVICES_ACTION ); ?>">
				<?php wp_nonce_field( MOR_IMPORT_SERVICES_ACTION, 'mor_import_services_nonce' ); ?>
				<?php submit_button( __( 'Import Products', 'mor-websites' ), 'primary', 'submit', false ); ?>
			</form>
		</div>

		<div class="card" style="max-width:640px;padding:1.5rem;margin-top:1rem;">
			<h2><?php esc_html_e( 'Pages (Home, Contact, Legal)', 'mor-websites' ); ?></h2>
			<p><?php esc_html_e( 'Creates the Home page (and sets it as the site\'s front page), the Contact page, and the four legal pages. Also ensures WooCommerce\'s own Shop/Cart/Checkout/My Account pages exist. Safe to click more than once — existing pages (matched by slug) are skipped, never duplicated.', 'mor-websites' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="<?php echo esc_attr( MOR_IMPORT_PAGES_ACTION ); ?>">
				<?php wp_nonce_field( MOR_IMPORT_PAGES_ACTION, 'mor_import_pages_nonce' ); ?>
				<?php submit_button( __( 'Import Pages', 'mor-websites' ), 'primary', 'submit', false ); ?>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Sideload a LOCAL theme image file into the media library as a real
 * attachment. media_sideload_image() only accepts remote HTTP(S) URLs,
 * and these images ship inside the theme itself, so this is the
 * equivalent operation for a local file: copy into uploads via
 * wp_upload_bits(), then register it as a proper attachment with
 * generated metadata (thumbnails etc.) exactly like a normal upload.
 *
 * @return int|false Attachment ID, or false on failure.
 */
function mor_sideload_local_image( $local_path, $description = '' ) {
	if ( ! file_exists( $local_path ) ) {
		return false;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$filename = wp_unique_filename( wp_upload_dir()['path'], basename( $local_path ) );
	$contents = file_get_contents( $local_path ); // phpcs:ignore -- local theme asset, not remote/user input.

	if ( false === $contents ) {
		return false;
	}

	$upload = wp_upload_bits( $filename, null, $contents );
	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$filetype   = wp_check_filetype( $upload['file'], null );
	$attachment = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => $description ? $description : sanitize_file_name( basename( $local_path ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	$attachment_id = wp_insert_attachment( $attachment, $upload['file'] );
	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		return false;
	}

	$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
	wp_update_attachment_metadata( $attachment_id, $attachment_data );

	return $attachment_id;
}

function mor_handle_import_services() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'mor-websites' ) );
	}
	check_admin_referer( MOR_IMPORT_SERVICES_ACTION, 'mor_import_services_nonce' );

	if ( mor_woocommerce_is_missing() ) {
		wp_die( esc_html__( 'WooCommerce is not active.', 'mor-websites' ) );
	}

	$catalog = mor_get_service_catalog();
	$created = 0;
	$skipped = 0;

	foreach ( $catalog as $product_data ) {
		$existing_id = wc_get_product_id_by_sku( $product_data['sku'] );
		if ( $existing_id ) {
			$skipped++;
			continue;
		}

		$product = new WC_Product_Simple();
		$product->set_name( $product_data['name'] );
		$product->set_sku( $product_data['sku'] );
		$product->set_regular_price( (string) $product_data['price'] );
		$product->set_description( $product_data['description'] );
		$product->set_short_description( wp_trim_words( $product_data['description'], 25 ) );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );

		$product_id = $product->save();

		if ( ! $product_id ) {
			continue;
		}

		$image_path    = MOR_THEME_DIR . '/assets/images/products/' . $product_data['image'];
		$attachment_id = mor_sideload_local_image( $image_path, $product_data['name'] );
		if ( $attachment_id ) {
			set_post_thumbnail( $product_id, $attachment_id );
		}

		$created++;
	}

	set_transient(
		'mor_import_services_result',
		sprintf(
			/* translators: 1: created count, 2: skipped count */
			__( 'Import complete: %1$d product(s) created, %2$d already existed and were skipped.', 'mor-websites' ),
			$created,
			$skipped
		),
		60
	);

	wp_safe_redirect( admin_url( 'themes.php?page=mor-import-store-content' ) );
	exit;
}
add_action( 'admin_post_' . MOR_IMPORT_SERVICES_ACTION, 'mor_handle_import_services' );

function mor_handle_import_pages() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'mor-websites' ) );
	}
	check_admin_referer( MOR_IMPORT_PAGES_ACTION, 'mor_import_pages_nonce' );

	$created = 0;
	$skipped = 0;

	// Ensure WooCommerce's own core pages (Shop, Cart, Checkout, My
	// Account) exist. WC_Install::create_pages() already checks for
	// existing pages before creating, so this is safe to call repeatedly.
	if ( class_exists( 'WC_Install' ) ) {
		WC_Install::create_pages();
	}

	// Home page — custom "Home" template, set as the static front page.
	$home_page = get_page_by_path( 'home' );
	if ( $home_page ) {
		$skipped++;
		$home_id = $home_page->ID;
	} else {
		$home_id = wp_insert_post(
			array(
				'post_title'   => __( 'Home', 'mor-websites' ),
				'post_name'    => 'home',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $home_id && ! is_wp_error( $home_id ) ) {
			update_post_meta( $home_id, '_wp_page_template', 'template-home.php' );
			$created++;
		}
	}

	if ( $home_id && ! is_wp_error( $home_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	// Contact page — auto-applies page-contact.php via slug.
	$contact_page = get_page_by_path( 'contact' );
	if ( $contact_page ) {
		$skipped++;
	} else {
		$contact_id = wp_insert_post(
			array(
				'post_title'   => __( 'Contact', 'mor-websites' ),
				'post_name'    => 'contact',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $contact_id && ! is_wp_error( $contact_id ) ) {
			$created++;
		}
	}

	// About page — auto-applies page-about.php via slug.
	$about_page = get_page_by_path( 'about' );
	if ( $about_page ) {
		$skipped++;
	} else {
		$about_id = wp_insert_post(
			array(
				'post_title'   => __( 'About Us', 'mor-websites' ),
				'post_name'    => 'about',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $about_id && ! is_wp_error( $about_id ) ) {
			$created++;
		}
	}

	// Legal pages.
	foreach ( mor_get_legal_pages() as $legal_page ) {
		$existing = get_page_by_path( $legal_page['slug'] );

		if ( $existing ) {
			// WordPress auto-creates a placeholder "Privacy Policy" page on
			// every fresh install, at this same slug, containing WordPress's
			// own generic guidance text rather than content specific to this
			// business — sometimes registered as wp_page_for_privacy_policy,
			// sometimes not, depending on how the site was set up. Either
			// way, if what's sitting at this slug isn't yet our real policy
			// (doesn't mention the Data Protection Act clause unique to it),
			// treat it as unwritten and replace it, so the site never ships
			// the WordPress boilerplate. Anything that already contains our
			// content is left alone (skipped) so a second import click never
			// clobbers an admin's own further edits. See CLAUDE.md.
			$is_unwritten_wp_privacy_placeholder = (
				'privacy-policy' === $legal_page['slug']
				&& false === strpos( $existing->post_content, 'Data Protection Act' )
			);

			if ( ! $is_unwritten_wp_privacy_placeholder ) {
				$skipped++;
				continue;
			}

			wp_update_post(
				array(
					'ID'           => $existing->ID,
					'post_title'   => $legal_page['title'],
					'post_status'  => 'publish',
					'post_content' => wp_kses_post( $legal_page['content'] ),
				)
			);
			update_option( 'wp_page_for_privacy_policy', $existing->ID );
			$created++;
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => $legal_page['title'],
				'post_name'    => $legal_page['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => wp_kses_post( $legal_page['content'] ),
			)
		);
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			if ( 'privacy-policy' === $legal_page['slug'] ) {
				update_option( 'wp_page_for_privacy_policy', $page_id );
			}
			$created++;
		}
	}

	set_transient(
		'mor_import_pages_result',
		sprintf(
			/* translators: 1: created count, 2: skipped count */
			__( 'Import complete: %1$d page(s) created, %2$d already existed and were skipped.', 'mor-websites' ),
			$created,
			$skipped
		),
		60
	);

	wp_safe_redirect( admin_url( 'themes.php?page=mor-import-store-content' ) );
	exit;
}
add_action( 'admin_post_' . MOR_IMPORT_PAGES_ACTION, 'mor_handle_import_pages' );
