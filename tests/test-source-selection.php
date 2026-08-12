<?php
/**
 * Demonstrates the single most important correctness property of this
 * updater: upgrader_source_selection must rename a GitHub-branch-zip
 * extraction folder like "mor-websites-client-a" back to the real
 * installed slug "mor-websites" before WordPress moves it into place.
 *
 * This builds a real temp directory tree that mimics what WP's Upgrader
 * hands to the upgrader_source_selection filter (a $remote_source
 * working dir containing exactly one extracted folder), calls the real
 * fix_source_selection() method against it, and inspects the real
 * filesystem afterwards.
 *
 * Run: php tests/test-source-selection.php
 */

require_once __DIR__ . '/bootstrap.php';

use MOR\Updater\Updater_Api;
use MOR\Updater\Github_Updater;

function mor_test_make_extracted_dir( $remote_source, $folder_name ) {
	$path = $remote_source . '/' . $folder_name;
	mkdir( $path, 0777, true );
	file_put_contents( $path . '/style.css', "Version: 9.9.9\n" );
	file_put_contents( $path . '/functions.php', "<?php // extracted theme\n" );
	return $path;
}

function mor_test_rrmdir( $dir ) {
	if ( ! is_dir( $dir ) ) {
		return;
	}
	$items = array_diff( scandir( $dir ), array( '.', '..' ) );
	foreach ( $items as $item ) {
		$full = $dir . '/' . $item;
		is_dir( $full ) ? mor_test_rrmdir( $full ) : unlink( $full );
	}
	rmdir( $dir );
}

$work_root = sys_get_temp_dir() . '/mor-updater-source-selection-test';
mor_test_rrmdir( $work_root );
mkdir( $work_root, 0777, true );

$GLOBALS['wp_filesystem'] = new Test_WP_Filesystem_Direct();
$GLOBALS['__test_installed_slug'] = 'mor-websites';

echo "=== upgrader_source_selection: renames \"mor-websites-client-a\" -> \"mor-websites\" ===\n";

$remote_source = $work_root . '/remote-source-1';
mkdir( $remote_source, 0777, true );
// This mirrors exactly what GitHub's branch zip produces: {repo}-{branch}.
$wrong_source = mor_test_make_extracted_dir( $remote_source, 'mor-websites-client-a' );

$updater = new Github_Updater( new Updater_Api() );
$args    = array( 'theme' => 'mor-websites' ); // this update IS for our theme

$result = $updater->fix_source_selection( $wrong_source, $remote_source, null, $args );

$expected = trailingslashit( $remote_source ) . 'mor-websites';

test_assert( untrailingslashit( $result ) === untrailingslashit( $expected ), 'returned path is the renamed folder, not the original' );
test_assert( ! is_dir( $wrong_source ), 'old mismatched-name folder no longer exists on disk' );
test_assert( is_dir( $expected ), 'correctly-named folder now exists on disk' );
test_assert( file_exists( $expected . '/style.css' ), 'file contents were preserved through the rename (style.css present)' );
test_assert(
	'Version: 9.9.9' === trim( file_get_contents( $expected . '/style.css' ) ),
	'file contents are byte-identical after rename (not re-extracted/corrupted)'
);

echo "\n=== upgrader_source_selection: folder already correctly named -> left alone (no-op) ===\n";

$remote_source_2 = $work_root . '/remote-source-2';
mkdir( $remote_source_2, 0777, true );
$already_right = mor_test_make_extracted_dir( $remote_source_2, 'mor-websites' );

$result2 = $updater->fix_source_selection( $already_right, $remote_source_2, null, $args );

test_assert( untrailingslashit( $result2 ) === untrailingslashit( $already_right ), 'no-op when the folder is already named correctly' );
test_assert( is_dir( $already_right ), 'folder still exists untouched' );

echo "\n=== upgrader_source_selection: update for a DIFFERENT theme -> left completely alone ===\n";

$remote_source_3 = $work_root . '/remote-source-3';
mkdir( $remote_source_3, 0777, true );
$other_theme_source = mor_test_make_extracted_dir( $remote_source_3, 'some-other-theme-main' );

$other_args = array( 'theme' => 'some-other-theme' );
$result3    = $updater->fix_source_selection( $other_theme_source, $remote_source_3, null, $other_args );

test_assert( $result3 === $other_theme_source, 'source is returned unchanged when $args[theme] is not this theme' );
test_assert( is_dir( $other_theme_source ), 'other theme extraction folder was never touched' );

echo "\n=== upgrader_source_selection: destination folder collides with a stale leftover -> cleared then renamed ===\n";

$remote_source_4 = $work_root . '/remote-source-4';
mkdir( $remote_source_4, 0777, true );
$wrong_source_4 = mor_test_make_extracted_dir( $remote_source_4, 'mor-websites-main' );
// Simulate a stale directory left behind by a previous crashed update.
mkdir( $remote_source_4 . '/mor-websites', 0777, true );
file_put_contents( $remote_source_4 . '/mor-websites/stale.txt', 'leftover' );

$result4 = $updater->fix_source_selection( $wrong_source_4, $remote_source_4, null, $args );
$expected4 = trailingslashit( $remote_source_4 ) . 'mor-websites';

test_assert( untrailingslashit( $result4 ) === untrailingslashit( $expected4 ), 'rename succeeds even when destination pre-exists as a stale leftover' );
test_assert( ! file_exists( $expected4 . '/stale.txt' ), 'stale leftover contents were cleared, not merged' );
test_assert( file_exists( $expected4 . '/functions.php' ), 'fresh extracted contents are present after clearing the stale dir' );

echo "\n=== upgrader_source_selection: move() failure -> logs and returns ORIGINAL source untouched (fails safe) ===\n";

class Test_WP_Filesystem_AlwaysFailsMove extends WP_Filesystem_Base {
	public function exists( $path ) {
		return file_exists( $path );
	}
	public function delete( $path, $recursive = false ) {
		return true;
	}
	public function move( $source, $destination, $overwrite = false ) {
		return false; // simulate a permissions/locking failure
	}
}

$GLOBALS['wp_filesystem'] = new Test_WP_Filesystem_AlwaysFailsMove();

$remote_source_5 = $work_root . '/remote-source-5';
mkdir( $remote_source_5, 0777, true );
$wrong_source_5 = mor_test_make_extracted_dir( $remote_source_5, 'mor-websites-client-b' );

$result5 = $updater->fix_source_selection( $wrong_source_5, $remote_source_5, null, $args );

test_assert( $result5 === $wrong_source_5, 'on a failed move, the original mismatched source is returned unchanged' );
test_assert( is_dir( $wrong_source_5 ), 'original extracted folder is left intact (nothing destructive happened) after a failed rename' );

$GLOBALS['wp_filesystem'] = new Test_WP_Filesystem_Direct();
mor_test_rrmdir( $work_root );

test_summary();
