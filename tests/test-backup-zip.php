<?php
/**
 * Confirms backup_current_theme() produces a restorable zip: relative
 * paths inside the archive (not absolute), correct nested structure,
 * and content that round-trips byte-for-byte through extraction.
 *
 * Run: php tests/test-backup-zip.php
 */

require_once __DIR__ . '/bootstrap.php';

use MOR\Updater\Updater_Api;
use MOR\Updater\Github_Updater;

function mor_test_rrmdir2( $dir ) {
	if ( ! is_dir( $dir ) ) {
		return;
	}
	$items = array_diff( scandir( $dir ), array( '.', '..' ) );
	foreach ( $items as $item ) {
		$full = $dir . '/' . $item;
		is_dir( $full ) ? mor_test_rrmdir2( $full ) : unlink( $full );
	}
	rmdir( $dir );
}

if ( ! class_exists( 'ZipArchive' ) ) {
	echo "ZipArchive extension not available — skipping backup zip test.\n";
	exit( 0 );
}

$work_root  = sys_get_temp_dir() . '/mor-updater-backup-test';
mor_test_rrmdir2( $work_root );

$source_dir = $work_root . '/theme-source/mor-websites';
mkdir( $source_dir . '/inc/updater', 0777, true );
mkdir( $source_dir . '/assets/css', 0777, true );

file_put_contents( $source_dir . '/style.css', "Version: 1.4.2\n" );
file_put_contents( $source_dir . '/functions.php', "<?php // root file\n" );
file_put_contents( $source_dir . '/inc/updater/class-github-updater.php', "<?php // nested file\n" );
file_put_contents( $source_dir . '/assets/css/style.min.css', "body{margin:0}" );

$backup_dir = $work_root . '/theme-backups';

// backup_current_theme() names the zip using the *installed* theme's
// version (via wp_get_theme()), matching what real WP would report for
// the theme about to be overwritten — not by reading the folder's own
// style.css. Set it to match so the filename assertion below is meaningful.
$GLOBALS['__test_installed_version'] = '1.4.2';

$updater = new Github_Updater( new Updater_Api() );

echo "=== backup_current_theme(): produces a zip file ===\n";
$ok = $updater->backup_current_theme( $source_dir, $backup_dir );
test_assert( true === $ok, 'backup_current_theme() reports success' );

$zips = glob( $backup_dir . '/mor-websites-*.zip' );
test_assert( 1 === count( $zips ), 'exactly one backup zip was created' );

$zip_path = $zips[0] ?? null;
test_assert(
	$zip_path && preg_match( '/^mor-websites-1\.4\.2-\d{8}-\d{6}\.zip$/', basename( $zip_path ) ),
	'filename matches {slug}-{old-version}-{timestamp}.zip'
);

echo "\n=== backup zip: entries use RELATIVE paths, not absolute ===\n";
$zip = new ZipArchive();
$zip->open( $zip_path );

$names = array();
for ( $i = 0; $i < $zip->numFiles; $i++ ) {
	$names[] = $zip->getNameIndex( $i );
}
sort( $names );

$expected_names = array(
	'assets/css/style.min.css',
	'functions.php',
	'inc/updater/class-github-updater.php',
	'style.css',
);

test_assert( $expected_names === $names, 'zip contains exactly the expected relative-path entries: ' . implode( ', ', $names ) );

foreach ( $names as $name ) {
	test_assert( '/' !== substr( $name, 0, 1 ) && ! preg_match( '#^[A-Za-z]:#', $name ), "entry \"$name\" is a relative path, not absolute" );
	test_assert( false === strpos( $name, $work_root ), "entry \"$name\" does not leak the source temp-dir path" );
}

echo "\n=== backup zip: is actually restorable — extract and diff against the original ===\n";
$restore_dir = $work_root . '/restored';
mkdir( $restore_dir, 0777, true );
$zip->extractTo( $restore_dir );
$zip->close();

test_assert( is_dir( $restore_dir . '/inc/updater' ), 'nested directory structure was recreated on extraction' );
test_assert(
	file_get_contents( $restore_dir . '/style.css' ) === file_get_contents( $source_dir . '/style.css' ),
	'extracted style.css is byte-identical to the original'
);
test_assert(
	file_get_contents( $restore_dir . '/inc/updater/class-github-updater.php' ) === file_get_contents( $source_dir . '/inc/updater/class-github-updater.php' ),
	'extracted nested file is byte-identical to the original'
);
test_assert(
	is_dir( $restore_dir . '/mor-websites' ) === false,
	'extraction lands files directly at restore root (no extra wrapping folder) — dropping this zip straight into wp-content/themes/mor-websites/ restores the theme'
);

mor_test_rrmdir2( $work_root );

test_summary();
