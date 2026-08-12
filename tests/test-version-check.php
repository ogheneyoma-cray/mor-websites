<?php
/**
 * Verifies check_update() parses a mocked style.css remote response and
 * only flags an update when version_compare says the remote is actually
 * newer than what's installed.
 *
 * Run: php tests/test-version-check.php
 */

require_once __DIR__ . '/bootstrap.php';

use MOR\Updater\Updater_Api;
use MOR\Updater\Github_Updater;

function mor_test_transient_stub( array $checked ) {
	$t           = new stdClass();
	$t->checked  = $checked;
	$t->response = array();
	$t->no_update = array();
	return $t;
}

echo "=== check_update(): remote newer than installed -> flags an update ===\n";
mor_test_reset_state();
$GLOBALS['__test_installed_version'] = '1.2.3';

mor_test_queue_http_response(
	'raw.githubusercontent.com',
	array(
		'response' => array( 'code' => 200 ),
		'body'     => "/*\nTheme Name: MOR Websites\nVersion: 1.3.0\n*/\n",
	)
);

$updater   = new Github_Updater( new Updater_Api() );
$transient = mor_test_transient_stub( array( $updater->slug => '1.2.3' ) );
$result    = $updater->check_update( $transient );

test_assert( isset( $result->response[ $updater->slug ] ), 'update is flagged in $transient->response' );
test_assert( '1.3.0' === ( $result->response[ $updater->slug ]['new_version'] ?? null ), 'new_version parsed correctly as 1.3.0' );
test_assert(
	false !== strpos( $result->response[ $updater->slug ]['package'] ?? '', 'archive/refs/heads/main.zip' ),
	'package URL points at the tracked branch zip'
);
test_assert( ! isset( $result->no_update[ $updater->slug ] ), 'no_update entry is not set when an update is available' );

echo "\n=== check_update(): remote same as installed -> no update flagged ===\n";
mor_test_reset_state();
$GLOBALS['__test_installed_version'] = '1.3.0';

mor_test_queue_http_response(
	'raw.githubusercontent.com',
	array(
		'response' => array( 'code' => 200 ),
		'body'     => "/*\nTheme Name: MOR Websites\nVersion: 1.3.0\n*/\n",
	)
);

$updater   = new Github_Updater( new Updater_Api() );
$transient = mor_test_transient_stub( array( $updater->slug => '1.3.0' ) );
$result    = $updater->check_update( $transient );

test_assert( ! isset( $result->response[ $updater->slug ] ), 'no update flagged when versions are equal' );
test_assert( isset( $result->no_update[ $updater->slug ] ), 'no_update entry set when versions are equal' );

echo "\n=== check_update(): remote OLDER than installed -> no update flagged ===\n";
mor_test_reset_state();
$GLOBALS['__test_installed_version'] = '2.0.0';

mor_test_queue_http_response(
	'raw.githubusercontent.com',
	array(
		'response' => array( 'code' => 200 ),
		'body'     => "/*\nVersion: 1.9.9\n*/\n",
	)
);

$updater   = new Github_Updater( new Updater_Api() );
$transient = mor_test_transient_stub( array( $updater->slug => '2.0.0' ) );
$result    = $updater->check_update( $transient );

test_assert( ! isset( $result->response[ $updater->slug ] ), 'no update flagged when installed is newer than remote (e.g. dev ahead of tag)' );

echo "\n=== check_update(): GitHub request fails (404 / bad branch) -> fails gracefully, no update flagged ===\n";
mor_test_reset_state();
$GLOBALS['__test_installed_version'] = '1.0.0';

mor_test_queue_http_response(
	'raw.githubusercontent.com',
	array(
		'response' => array( 'code' => 404 ),
		'body'     => '404: Not Found',
	)
);

$updater   = new Github_Updater( new Updater_Api() );
$transient = mor_test_transient_stub( array( $updater->slug => '1.0.0' ) );
$result    = $updater->check_update( $transient );

test_assert( ! isset( $result->response[ $updater->slug ] ), 'a 404 from GitHub does not flag an update' );
test_assert( is_object( $result ) && '1.0.0' === $GLOBALS['__test_installed_version'], 'installed version is untouched by a failed check' );

echo "\n=== get_remote_version(): result is cached for 12h (second call makes no HTTP request) ===\n";
mor_test_reset_state();
mor_test_queue_http_response(
	'raw.githubusercontent.com',
	array(
		'response' => array( 'code' => 200 ),
		'body'     => "Version: 3.1.4\n",
	)
);
$updater = new Github_Updater( new Updater_Api() );
$first   = $updater->get_remote_version( '1.0.0' );

// Remove the stubbed HTTP response only (keep the transient cache
// intact); if the second call hits the network it will get a WP_Error
// ("no stub") and return false instead of the cached value.
$GLOBALS['__test_http_responses'] = array();
$second = $updater->get_remote_version( '1.0.0' );

test_assert( '3.1.4' === $first, 'first call fetches and parses the live response' );
test_assert( '3.1.4' === $second, 'second call is served from the 12h transient cache, not a new request' );

echo "\n=== set_branch(): persists to wp_options, updates in-memory branch, and busts caches ===\n";
mor_test_reset_state();
$updater = new Github_Updater( new Updater_Api() );
test_assert( 'main' === $updater->get_branch(), 'defaults to main when no option is set' );

mor_test_queue_http_response(
	'raw.githubusercontent.com/ogheneyoma-cray/mor-websites/main/',
	array( 'response' => array( 'code' => 200 ), 'body' => "Version: 1.0.0\n" )
);
$updater->get_remote_version( '1.0.0' ); // populate the cache for 'main'
test_assert( false !== $updater->get_cached_remote_version(), 'main branch cache is populated before switching' );

$ok = $updater->set_branch( 'client-a' );
test_assert( true === $ok, 'set_branch() accepts a valid branch name' );
test_assert( 'client-a' === $updater->get_branch(), 'in-memory branch updates immediately' );
test_assert( 'client-a' === $GLOBALS['__test_options']['mor_updater_branch'], 'branch is persisted to wp_options' );
test_assert( false === $updater->get_cached_remote_version(), 'switching branches clears the version cache (new branch has its own cache key)' );

$rejected = $updater->set_branch( 'not a valid branch; rm -rf' );
test_assert( false === $rejected, 'set_branch() rejects a branch name with disallowed characters' );
test_assert( 'client-a' === $updater->get_branch(), 'a rejected branch name does not overwrite the previously saved one' );

test_summary();
