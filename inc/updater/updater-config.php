<?php
/**
 * Updater configuration constants.
 *
 * All of these can be overridden from wp-config.php by defining the
 * constant before this file loads (i.e. before WordPress bootstraps the
 * theme — a normal wp-config.php define() satisfies this).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// GitHub repo that hosts this theme. Fallback defaults point at the
// canonical repo; override per-environment if you ever fork it.
if ( ! defined( 'GITHUB_UPDATER_OWNER' ) ) {
	define( 'GITHUB_UPDATER_OWNER', 'ogheneyoma-cray' );
}

if ( ! defined( 'GITHUB_UPDATER_REPO' ) ) {
	define( 'GITHUB_UPDATER_REPO', 'mor-websites' );
}

// Fallback branch used only until a site admin sets one via the
// Appearance -> Theme Updates screen (see class-updater-settings.php).
// The branch actually tracked lives in wp_options as 'mor_updater_branch'
// — deliberately NOT a wp-config.php constant, so any admin with
// `update_themes` capability can point a site at a different client
// branch from the UI without a code deploy.
if ( ! defined( 'MOR_UPDATER_DEFAULT_BRANCH' ) ) {
	define( 'MOR_UPDATER_DEFAULT_BRANCH', 'main' );
}

// Optional GitHub personal access token, required only if the repo is
// private. Never persisted to the database — wp-config.php only.
if ( ! defined( 'GITHUB_UPDATER_TOKEN' ) ) {
	define( 'GITHUB_UPDATER_TOKEN', '' );
}

/**
 * The theme's actual installed slug — always the folder WordPress put
 * this theme in, never a hardcoded string. This is what update
 * responses and the source-selection rename must key off of.
 */
if ( ! function_exists( 'mor_updater_theme_slug' ) ) {
	function mor_updater_theme_slug() {
		return basename( get_template_directory() );
	}
}

/**
 * The branch this install currently tracks, stored in wp_options so it's
 * editable from the Appearance -> Theme Updates admin screen.
 */
if ( ! function_exists( 'mor_updater_get_branch' ) ) {
	function mor_updater_get_branch() {
		return get_option( 'mor_updater_branch', MOR_UPDATER_DEFAULT_BRANCH );
	}
}
