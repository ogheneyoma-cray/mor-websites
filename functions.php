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

require_once MOR_THEME_DIR . '/inc/setup.php';
require_once MOR_THEME_DIR . '/inc/template-functions.php';

require_once MOR_THEME_DIR . '/inc/updater/updater-config.php';
require_once MOR_THEME_DIR . '/inc/updater/class-updater-api.php';
require_once MOR_THEME_DIR . '/inc/updater/class-github-updater.php';
require_once MOR_THEME_DIR . '/inc/updater/class-updater-settings.php';

new MOR\Updater\Github_Updater();
new MOR\Updater\Updater_Settings();
