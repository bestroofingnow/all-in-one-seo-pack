<?php
/**
 * Debug Script - Run this to diagnose plugin issues
 *
 * Upload to WordPress root and access via browser: yoursite.com/debug-plugin.php
 * Or run via command line: php debug-plugin.php
 */

// Enable all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
echo "=== AIOSEO Independence Plugin Debug ===\n\n";

// 1. Check if running in WordPress
if (defined('ABSPATH')) {
    echo "✓ Running in WordPress environment\n";
    echo "  WordPress Path: " . ABSPATH . "\n\n";
} else {
    echo "✗ NOT running in WordPress\n";
    echo "  Please run this from WordPress root or wp-admin\n\n";
}

// 2. Check plugin directory
$plugin_dir = defined('WP_PLUGIN_DIR') ? WP_PLUGIN_DIR . '/all-in-one-seo-pack' : dirname(__FILE__);
echo "Plugin Directory: $plugin_dir\n";

if (!is_dir($plugin_dir)) {
    echo "✗ Plugin directory does not exist!\n\n";
    exit;
}
echo "✓ Plugin directory exists\n\n";

// 3. Check critical files
echo "=== Checking Critical Files ===\n";
$critical_files = [
    'all_in_one_seo_pack.php' => 'Main plugin file',
    'app/AIOSEO.php' => 'Main class file',
    'app/Lite/Admin/Admin.php' => 'Admin class',
    'app/Lite/Options/Options.php' => 'Options class',
    'app/Common/Ai/AiManager.php' => 'AI Manager',
    'app/Common/Integrations/Elementor.php' => 'Elementor integration',
    'vendor/autoload.php' => 'Composer autoloader'
];

foreach ($critical_files as $file => $desc) {
    $full_path = "$plugin_dir/$file";
    if (file_exists($full_path)) {
        echo "✓ $desc: $file\n";

        // Check for syntax errors
        $output = [];
        $result = 0;
        exec("php -l " . escapeshellarg($full_path) . " 2>&1", $output, $result);
        if ($result !== 0) {
            echo "  ✗ SYNTAX ERROR:\n";
            echo "    " . implode("\n    ", $output) . "\n";
        }
    } else {
        echo "✗ MISSING: $desc ($file)\n";
    }
}
echo "\n";

// 4. Check for Pro directory (should NOT exist)
echo "=== Checking Directory Structure ===\n";
if (is_dir("$plugin_dir/app/Pro")) {
    echo "✗ WARNING: app/Pro directory exists (should not exist for independent plugin)\n";
} else {
    echo "✓ app/Pro directory does NOT exist (correct for Lite structure)\n";
}

if (is_dir("$plugin_dir/app/Lite")) {
    echo "✓ app/Lite directory exists (correct)\n";
} else {
    echo "✗ app/Lite directory MISSING\n";
}

if (is_dir("$plugin_dir/app/Common")) {
    echo "✓ app/Common directory exists (correct)\n";
} else {
    echo "✗ app/Common directory MISSING\n";
}
echo "\n";

// 5. Search for Pro class references
echo "=== Searching for Pro Class References ===\n";
$pro_refs = [];
exec("grep -r 'new Pro\\\\\\\\' " . escapeshellarg($plugin_dir . "/app/AIOSEO.php") . " 2>/dev/null", $pro_refs);
if (empty($pro_refs)) {
    echo "✓ No Pro class instantiations found in AIOSEO.php\n";
} else {
    echo "✗ Found Pro class references in AIOSEO.php:\n";
    foreach ($pro_refs as $ref) {
        echo "  - $ref\n";
    }
}
echo "\n";

// 6. Try to load the main plugin file
echo "=== Testing Plugin Load ===\n";
if (defined('ABSPATH') && file_exists("$plugin_dir/all_in_one_seo_pack.php")) {
    try {
        // Check if already loaded
        if (function_exists('aioseo')) {
            echo "✓ Plugin already loaded (aioseo() function exists)\n";

            // Check version info
            $aioseo = aioseo();
            echo "  Pro Mode: " . ($aioseo->pro ? 'TRUE' : 'FALSE') . "\n";
            echo "  Version Path: " . $aioseo->versionPath . "\n";
            echo "  Version: " . (defined('AIOSEO_VERSION') ? AIOSEO_VERSION : 'Unknown') . "\n";
        } else {
            echo "✗ Plugin not loaded yet\n";
            echo "  (This is normal if plugin isn't activated)\n";
        }
    } catch (Throwable $e) {
        echo "✗ Error checking plugin status:\n";
        echo "  " . $e->getMessage() . "\n";
        echo "  File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
}
echo "\n";

// 7. Check WordPress debug settings
if (defined('WP_DEBUG')) {
    echo "=== WordPress Debug Settings ===\n";
    echo "WP_DEBUG: " . (WP_DEBUG ? 'TRUE' : 'FALSE') . "\n";
    if (defined('WP_DEBUG_LOG')) {
        echo "WP_DEBUG_LOG: " . (WP_DEBUG_LOG ? 'TRUE' : 'FALSE') . "\n";
        if (WP_DEBUG_LOG && defined('WP_CONTENT_DIR')) {
            $log_file = WP_CONTENT_DIR . '/debug.log';
            if (file_exists($log_file)) {
                echo "Debug log exists at: $log_file\n";
                echo "Last 10 lines:\n";
                $lines = file($log_file);
                $last_lines = array_slice($lines, -10);
                echo "---\n" . implode("", $last_lines) . "---\n";
            }
        }
    }
    echo "\n";
}

echo "=== Debug Complete ===\n";
echo "</pre>";
?>
