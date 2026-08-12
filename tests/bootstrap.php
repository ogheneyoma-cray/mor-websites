<?php
/**
 * Minimal standalone WP-function stubs so the actual updater classes
 * can be exercised with `php tests/test-*.php` — no full WP install or
 * PHPUnit required. Every stub here does just enough to make the real
 * class code run the same logical path it would run inside WordPress;
 * none of the logic under test lives in this file.
 */

error_reporting( E_ALL & ~E_DEPRECATED );

define( 'ABSPATH', __DIR__ . '/fixtures/' );
define( 'WP_CONTENT_DIR', sys_get_temp_dir() . '/mor-updater-tests/wp-content' );
define( 'HOUR_IN_SECONDS', 3600 );

if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

$GLOBALS['__test_transients'] = array();
$GLOBALS['__test_options']    = array();
$GLOBALS['__test_theme_root'] = sys_get_temp_dir() . '/mor-updater-tests/themes';
$GLOBALS['__test_installed_slug'] = 'mor-websites';
$GLOBALS['__test_http_responses'] = array();

function add_filter( $tag, $cb, $priority = 10, $args = 1 ) {}
function add_action( $tag, $cb, $priority = 10, $args = 1 ) {}

function is_wp_error( $thing ) {
	return $thing instanceof WP_Error;
}

class WP_Error {
	protected $code;
	protected $message;
	public function __construct( $code = '', $message = '' ) {
		$this->code    = $code;
		$this->message = $message;
	}
	public function get_error_message() {
		return $this->message;
	}
	public function get_error_code() {
		return $this->code;
	}
}

/**
 * Queue a canned HTTP response keyed by URL substring, for wp_remote_get().
 */
function mor_test_queue_http_response( $url_contains, $response ) {
	$GLOBALS['__test_http_responses'][ $url_contains ] = $response;
}

function wp_remote_get( $url, $args = array() ) {
	foreach ( $GLOBALS['__test_http_responses'] as $needle => $response ) {
		if ( false !== strpos( $url, $needle ) ) {
			if ( isset( $args['stream'] ) && $args['stream'] && isset( $args['filename'] ) && isset( $response['body'] ) ) {
				file_put_contents( $args['filename'], $response['body'] );
			}
			return $response;
		}
	}
	return new WP_Error( 'mor_test_no_stub', 'No stubbed response for ' . $url );
}

function wp_remote_retrieve_response_code( $response ) {
	return $response['response']['code'] ?? 0;
}

function wp_remote_retrieve_body( $response ) {
	return $response['body'] ?? '';
}

function get_site_transient( $key ) {
	return $GLOBALS['__test_transients'][ $key ] ?? false;
}

function set_site_transient( $key, $value, $ttl = 0 ) {
	$GLOBALS['__test_transients'][ $key ] = $value;
	return true;
}

function delete_site_transient( $key ) {
	unset( $GLOBALS['__test_transients'][ $key ] );
	return true;
}

function get_option( $key, $default = false ) {
	return $GLOBALS['__test_options'][ $key ] ?? $default;
}

function update_option( $key, $value, $autoload = null ) {
	$GLOBALS['__test_options'][ $key ] = $value;
	return true;
}

function get_template_directory() {
	return $GLOBALS['__test_theme_root'] . '/' . $GLOBALS['__test_installed_slug'];
}

function get_theme_root( $stylesheet = null ) {
	return $GLOBALS['__test_theme_root'];
}

class Test_WP_Theme {
	protected $version;
	protected $exists;
	public function __construct( $version = '1.0.0', $exists = true ) {
		$this->version = $version;
		$this->exists  = $exists;
	}
	public function get( $field ) {
		return 'Version' === $field ? $this->version : '';
	}
	public function exists() {
		return $this->exists;
	}
}

function wp_get_theme( $slug = null ) {
	return new Test_WP_Theme( $GLOBALS['__test_installed_version'] ?? '1.0.0' );
}

function trailingslashit( $string ) {
	return rtrim( $string, '/\\' ) . '/';
}

function untrailingslashit( $string ) {
	return rtrim( $string, '/\\' );
}

function wp_tempnam( $filename = '' ) {
	return tempnam( sys_get_temp_dir(), 'mor-updater-test-' );
}

function wp_mkdir_p( $target ) {
	return is_dir( $target ) || mkdir( $target, 0777, true );
}

function __( $text, $domain = 'default' ) {
	return $text;
}

function sanitize_text_field( $str ) {
	return trim( preg_replace( '/[\r\n\t ]+/', ' ', strip_tags( (string) $str ) ) );
}

/**
 * Minimal stand-in for WP_Filesystem_Base so `instanceof` checks in the
 * real class pass, and a Direct-style implementation the tests can point
 * $wp_filesystem at to perform real moves on a temp directory.
 */
abstract class WP_Filesystem_Base {
	abstract public function exists( $path );
	abstract public function delete( $path, $recursive = false );
	abstract public function move( $source, $destination, $overwrite = false );
}

class Test_WP_Filesystem_Direct extends WP_Filesystem_Base {
	public function exists( $path ) {
		return file_exists( $path );
	}
	public function delete( $path, $recursive = false ) {
		if ( is_dir( $path ) ) {
			$items = array_diff( scandir( $path ), array( '.', '..' ) );
			foreach ( $items as $item ) {
				$full = $path . '/' . $item;
				is_dir( $full ) ? $this->delete( $full, true ) : unlink( $full );
			}
			return rmdir( $path );
		}
		return @unlink( $path );
	}
	public function move( $source, $destination, $overwrite = false ) {
		if ( file_exists( $destination ) ) {
			if ( ! $overwrite ) {
				return false;
			}
			$this->delete( $destination, true );
		}
		return @rename( $source, $destination );
	}
}

function mor_test_reset_state() {
	$GLOBALS['__test_transients']     = array();
	$GLOBALS['__test_options']        = array();
	$GLOBALS['__test_http_responses'] = array();
}

require_once __DIR__ . '/../inc/updater/updater-config.php';
require_once __DIR__ . '/../inc/updater/class-updater-api.php';
require_once __DIR__ . '/../inc/updater/class-github-updater.php';

$__mor_test_pass = 0;
$__mor_test_fail = 0;

function test_assert( $condition, $label ) {
	global $__mor_test_pass, $__mor_test_fail;
	if ( $condition ) {
		$__mor_test_pass++;
		echo "  \033[32mPASS\033[0m  $label\n";
	} else {
		$__mor_test_fail++;
		echo "  \033[31mFAIL\033[0m  $label\n";
	}
}

function test_summary() {
	global $__mor_test_pass, $__mor_test_fail;
	echo "\n" . ( $__mor_test_pass ) . " passed, " . $__mor_test_fail . " failed\n";
	if ( $__mor_test_fail > 0 ) {
		exit( 1 );
	}
}
