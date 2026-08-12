<?php
/**
 * Theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOR_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'MOR_THEME_DIR', get_template_directory() );
define( 'MOR_THEME_URI', get_template_directory_uri() );

require_once MOR_THEME_DIR . '/inc/woocommerce-check.php';

if ( ! mor_woocommerce_is_missing() ) {
	require_once MOR_THEME_DIR . '/inc/woocommerce-support.php';
}

require_once MOR_THEME_DIR . '/inc/setup.php';
require_once MOR_THEME_DIR . '/inc/template-functions.php';
require_once MOR_THEME_DIR . '/inc/customizer.php';
require_once MOR_THEME_DIR . '/inc/currency-switcher.php';
require_once MOR_THEME_DIR . '/inc/contact-form.php';
require_once MOR_THEME_DIR . '/inc/content-importer.php';
require_once MOR_THEME_DIR . '/inc/page-content-fields.php';

// Shared GitHub branch updater — do not modify; merged in independently.
require_once MOR_THEME_DIR . '/inc/updater/updater-config.php';
require_once MOR_THEME_DIR . '/inc/updater/class-updater-api.php';
require_once MOR_THEME_DIR . '/inc/updater/class-github-updater.php';
require_once MOR_THEME_DIR . '/inc/updater/class-updater-settings.php';

new MOR\Updater\Github_Updater();
new MOR\Updater\Updater_Settings();
