<?php
/**
 * Hooks this theme into WordPress's native update UI, pulling releases
 * from a tracked GitHub branch instead of wordpress.org.
 */

namespace MOR\Updater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Github_Updater {

	/** @var string Installed theme folder name — the source of truth. */
	public $slug;

	/** @var string Branch this install tracks. */
	protected $branch;

	/** @var Updater_Api */
	protected $api;

	const CACHE_TTL = 12 * HOUR_IN_SECONDS;

	public function __construct( ?Updater_Api $api = null ) {
		$this->slug   = mor_updater_theme_slug();
		$this->branch = mor_updater_get_branch();
		$this->api    = $api ?: new Updater_Api();

		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
		add_filter( 'upgrader_pre_download', array( $this, 'pre_download' ), 10, 4 );
		add_filter( 'upgrader_source_selection', array( $this, 'fix_source_selection' ), 10, 4 );
		add_filter( 'upgrader_pre_install', array( $this, 'backup_before_install' ), 10, 2 );
	}

	/**
	 * pre_set_site_transient_update_themes: populate $transient->response
	 * when the tracked branch has a newer version than what's installed.
	 */
	public function check_update( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$installed_version = $transient->checked[ $this->slug ] ?? wp_get_theme( $this->slug )->get( 'Version' );

		$remote_version = $this->get_remote_version( $installed_version );

		if ( false === $remote_version ) {
			return $transient;
		}

		if ( version_compare( $remote_version, $installed_version, '>' ) ) {
			$transient->response[ $this->slug ] = array(
				'theme'       => $this->slug,
				'new_version' => $remote_version,
				'url'         => sprintf( 'https://github.com/%s/%s/tree/%s', GITHUB_UPDATER_OWNER, GITHUB_UPDATER_REPO, $this->branch ),
				'package'     => $this->api->get_branch_zip_url( $this->branch ),
			);
			unset( $transient->no_update[ $this->slug ] );
		} else {
			unset( $transient->response[ $this->slug ] );
			$transient->no_update[ $this->slug ] = array(
				'theme'       => $this->slug,
				'new_version' => $installed_version,
			);
		}

		return $transient;
	}

	/**
	 * Resolve the remote version, using a 12h transient cache so we don't
	 * hit GitHub on every admin page load. Never throws — a failed check
	 * just means "no update reported this cycle", not a fatal.
	 *
	 * @return string|false
	 */
	public function get_remote_version( $installed_version = null ) {
		$cache_key = $this->cache_key();
		$cached    = get_site_transient( $cache_key );

		if ( false !== $cached ) {
			return $cached;
		}

		$style_css = $this->api->get_remote_style_css( $this->branch );
		$version   = $style_css ? $this->api->parse_version( $style_css ) : false;

		if ( false === $version ) {
			return false;
		}

		set_site_transient( $cache_key, $version, self::CACHE_TTL );
		update_option( $this->last_checked_option_key(), time(), false );

		return $version;
	}

	/**
	 * Read-only accessor for the settings page: last cached remote
	 * version without triggering a new network request.
	 *
	 * @return string|false
	 */
	public function get_cached_remote_version() {
		$cached = get_site_transient( $this->cache_key() );
		return false === $cached ? false : $cached;
	}

	public function get_last_checked() {
		return get_option( $this->last_checked_option_key(), false );
	}

	public function get_branch() {
		return $this->branch;
	}

	/**
	 * Change the tracked branch (called from the Appearance -> Theme
	 * Updates screen). Persists to wp_options and immediately clears
	 * both the version cache and WP's own update_themes transient so
	 * the next admin page load re-checks against the new branch instead
	 * of serving a stale cached response for the old one.
	 *
	 * @return bool
	 */
	public function set_branch( $branch ) {
		$branch = sanitize_text_field( $branch );

		if ( '' === $branch || ! preg_match( '/^[A-Za-z0-9._\/-]+$/', $branch ) ) {
			return false;
		}

		update_option( 'mor_updater_branch', $branch );
		$this->branch = $branch;
		$this->clear_cache();

		return true;
	}

	public function clear_cache() {
		delete_site_transient( $this->cache_key() );
		delete_site_transient( 'update_themes' );
	}

	protected function cache_key() {
		return 'mor_updater_ver_' . md5( $this->slug . '|' . $this->branch );
	}

	protected function last_checked_option_key() {
		return 'mor_updater_last_checked_' . $this->slug;
	}

	/**
	 * upgrader_pre_download: when a token is configured and the package
	 * lives on github.com, download it ourselves with the Authorization
	 * header attached (needed for private repos — the core downloader
	 * has no way to inject custom headers).
	 *
	 * @return string|\WP_Error|false Local file path, WP_Error, or false to defer to core.
	 */
	public function pre_download( $reply, $package, $upgrader, $hook_extra = array() ) {
		if ( false !== $reply ) {
			return $reply;
		}

		if ( empty( GITHUB_UPDATER_TOKEN ) ) {
			return $reply;
		}

		$expected_prefix = sprintf( 'https://github.com/%s/%s/', GITHUB_UPDATER_OWNER, GITHUB_UPDATER_REPO );
		if ( 0 !== strpos( $package, $expected_prefix ) ) {
			return $reply;
		}

		if ( isset( $hook_extra['theme'] ) && $hook_extra['theme'] !== $this->slug ) {
			return $reply;
		}

		if ( ! function_exists( 'download_url' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$tmp_file = wp_tempnam( $package );
		if ( ! $tmp_file ) {
			$this->log( 'Could not allocate a temp file for authenticated download.' );
			return new \WP_Error( 'mor_updater_tmpfile', __( 'Could not create a temporary file for the theme download.', 'mor-websites' ) );
		}

		$response = wp_remote_get(
			$package,
			array(
				'timeout'  => 300,
				'stream'   => true,
				'filename' => $tmp_file,
				'headers'  => $this->api->auth_headers(),
			)
		);

		if ( is_wp_error( $response ) ) {
			@unlink( $tmp_file );
			$this->log( 'Authenticated package download failed: ' . $response->get_error_message() );
			return $response;
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			@unlink( $tmp_file );
			$this->log( sprintf( 'Authenticated package download returned HTTP %d for %s', $code, $package ) );
			return new \WP_Error(
				'mor_updater_download_failed',
				sprintf(
					/* translators: %d: HTTP status code */
					__( 'Downloading the theme package failed (HTTP %d). Check the branch name and repo visibility.', 'mor-websites' ),
					$code
				)
			);
		}

		return $tmp_file;
	}

	/**
	 * upgrader_source_selection: THE CRITICAL FIX.
	 *
	 * GitHub branch zips extract as "{repo}-{branch}". If that folder is
	 * left as-is, WordPress installs it as a brand-new theme instead of
	 * updating this one in place, orphaning theme_mods, the active-theme
	 * setting, menu locations, widgets, etc. This renames the extracted
	 * folder back to the real installed slug before WP moves it into
	 * wp-content/themes/.
	 *
	 * Only acts on updates for THIS theme ($args['theme'] === $this->slug)
	 * so it never touches other themes/plugins updating in the same
	 * request.
	 */
	public function fix_source_selection( $source, $remote_source, $upgrader, $args = array() ) {
		if ( ! isset( $args['theme'] ) || $args['theme'] !== $this->slug ) {
			return $source;
		}

		if ( ! $source || ! is_string( $source ) ) {
			return $source;
		}

		$corrected_source = trailingslashit( $remote_source ) . $this->slug;

		if ( untrailingslashit( $source ) === untrailingslashit( $corrected_source ) ) {
			// Already named correctly — nothing to do.
			return $source;
		}

		global $wp_filesystem;

		if ( ! $wp_filesystem instanceof \WP_Filesystem_Base ) {
			$this->log( 'WP_Filesystem is not available; cannot rename extracted folder.' );
			return $source;
		}

		if ( $wp_filesystem->exists( $corrected_source ) ) {
			// Leftover from a previous failed attempt — clear it first so
			// move() doesn't fail by colliding with a stale directory.
			$wp_filesystem->delete( $corrected_source, true );
		}

		$moved = $wp_filesystem->move( $source, $corrected_source, true );

		if ( ! $moved ) {
			$this->log(
				sprintf(
					'Failed to rename extracted folder "%s" to expected slug "%s". Aborting rename step; update will not proceed correctly and should be treated as failed.',
					basename( $source ),
					$this->slug
				)
			);
			// Fail safe: hand back the original, wrongly-named source.
			// WordPress will not overwrite the existing theme folder with
			// it, so the current install is left untouched — but the
			// update itself does not complete correctly and must be
			// investigated (see error_log).
			return $source;
		}

		return trailingslashit( $corrected_source );
	}

	/**
	 * upgrader_pre_install: zip up the current theme folder before the
	 * update overwrites anything, as a rollback safety net.
	 */
	public function backup_before_install( $response, $hook_extra ) {
		if ( is_wp_error( $response ) || ! $response ) {
			return $response;
		}

		if ( ! isset( $hook_extra['theme'] ) || $hook_extra['theme'] !== $this->slug ) {
			return $response;
		}

		if ( ! $this->backup_current_theme() ) {
			$this->log( 'Pre-install backup failed; aborting update rather than risk an unrecoverable overwrite.' );
			return new \WP_Error(
				'mor_updater_backup_failed',
				__( 'Could not create a safety backup of the current theme, so the update was cancelled.', 'mor-websites' )
			);
		}

		return $response;
	}

	/**
	 * Zip the current theme folder to
	 * wp-content/theme-backups/{slug}-{old-version}-{timestamp}.zip
	 * with paths relative to the theme root (so the zip is directly
	 * restorable by extracting it into wp-content/themes/{slug}/).
	 *
	 * @return bool
	 */
	public function backup_current_theme( $source_dir = null, $backup_dir = null ) {
		$source_dir = $source_dir ?: ( get_theme_root() . '/' . $this->slug );

		if ( ! is_dir( $source_dir ) ) {
			// Nothing installed yet to back up — not a failure.
			return true;
		}

		if ( ! class_exists( '\ZipArchive' ) ) {
			$this->log( 'ZipArchive is not available; cannot create theme backup.' );
			return false;
		}

		$theme       = wp_get_theme( $this->slug );
		$old_version = $theme->exists() ? $theme->get( 'Version' ) : 'unknown';

		$backup_dir = $backup_dir ?: ( WP_CONTENT_DIR . '/theme-backups' );
		if ( ! is_dir( $backup_dir ) && ! wp_mkdir_p( $backup_dir ) ) {
			$this->log( 'Could not create backup directory: ' . $backup_dir );
			return false;
		}

		$filename = sprintf( '%s-%s-%s.zip', $this->slug, $old_version, gmdate( 'Ymd-His' ) );
		$zip_path = trailingslashit( $backup_dir ) . $filename;

		$zip = new \ZipArchive();
		if ( true !== $zip->open( $zip_path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE ) ) {
			$this->log( 'Could not open zip file for writing: ' . $zip_path );
			return false;
		}

		$source_dir_real = realpath( $source_dir );

		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator( $source_dir_real, \RecursiveDirectoryIterator::SKIP_DOTS ),
			\RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ( $files as $file ) {
			if ( $file->isDir() ) {
				continue;
			}
			$file_path     = $file->getRealPath();
			$relative_path = ltrim( substr( $file_path, strlen( $source_dir_real ) ), '/\\' );
			$zip->addFile( $file_path, $relative_path );
		}

		$zip->close();

		return file_exists( $zip_path );
	}

	protected function log( $message ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( '[mor-updater] ' . $message );
		}
	}
}
