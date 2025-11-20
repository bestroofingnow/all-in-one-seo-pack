<?php
/**
 * Diagnostic script to check if assets are loading correctly
 * Run this from WordPress admin or via WP-CLI
 */

// Check if WordPress is loaded
if ( ! defined( 'ABSPATH' ) ) {
	die( 'This script must be run within WordPress' );
}

echo "=== AIOSEO Asset Loading Diagnostic ===\n\n";

// Check plugin file exists
echo "1. Checking plugin file...\n";
$pluginFile = WP_PLUGIN_DIR . '/all-in-one-seo-pack/all_in_one_seo_pack.php';
echo "   Plugin file exists: " . ( file_exists( $pluginFile ) ? "YES" : "NO" ) . "\n\n";

// Check if AIOSEO is loaded
echo "2. Checking if AIOSEO is loaded...\n";
if ( function_exists( 'aioseo' ) ) {
	echo "   AIOSEO function exists: YES\n";
	echo "   Version: " . aioseo()->version . "\n";
	echo "   Version Path: " . aioseo()->versionPath . "\n";
	echo "   Is Pro: " . ( aioseo()->pro ? 'YES' : 'NO' ) . "\n";
	echo "   Is Dev: " . ( aioseo()->isDev ? 'YES' : 'NO' ) . "\n\n";
} else {
	echo "   AIOSEO function does NOT exist\n\n";
}

// Check dist folder structure
echo "3. Checking dist folder structure...\n";
$distDir = WP_PLUGIN_DIR . '/all-in-one-seo-pack/dist';
echo "   dist/ exists: " . ( is_dir( $distDir ) ? "YES" : "NO" ) . "\n";

$liteDir = $distDir . '/Lite';
echo "   dist/Lite/ exists: " . ( is_dir( $liteDir ) ? "YES" : "NO" ) . "\n";

$manifestFile = $liteDir . '/manifest.php';
echo "   dist/Lite/manifest.php exists: " . ( file_exists( $manifestFile ) ? "YES" : "NO" ) . "\n";

if ( file_exists( $manifestFile ) ) {
	$manifest = include $manifestFile;
	echo "   Manifest loaded: " . ( is_array( $manifest ) ? "YES (" . count( $manifest ) . " entries)" : "NO" ) . "\n";
}

$assetsDir = $liteDir . '/assets';
echo "   dist/Lite/assets/ exists: " . ( is_dir( $assetsDir ) ? "YES" : "NO" ) . "\n";

if ( is_dir( $assetsDir ) ) {
	$jsCount = count( glob( $assetsDir . '/**/*.js' ) );
	$cssCount = count( glob( $assetsDir . '/**/*.css' ) );
	echo "   JavaScript files found: $jsCount\n";
	echo "   CSS files found: $cssCount\n";
}
echo "\n";

// Check if assets class exists
echo "4. Checking Assets class...\n";
if ( class_exists( 'AIOSEO\Plugin\Common\Utils\Assets' ) ) {
	echo "   Assets class exists: YES\n";
} else {
	echo "   Assets class exists: NO\n";
}
echo "\n";

// Check enqueued scripts
echo "5. Checking enqueued scripts on admin page...\n";
global $wp_scripts;
if ( $wp_scripts ) {
	$aioseoScripts = array_filter( $wp_scripts->registered, function( $handle ) {
		return strpos( $handle, 'aioseo' ) !== false;
	}, ARRAY_FILTER_USE_KEY );

	echo "   AIOSEO scripts enqueued: " . count( $aioseoScripts ) . "\n";
	foreach ( $aioseoScripts as $handle => $script ) {
		echo "   - $handle: " . $script->src . "\n";
	}
} else {
	echo "   No scripts registered yet\n";
}

echo "\n=== End Diagnostic ===\n";
