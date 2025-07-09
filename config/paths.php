
<?php
/**
 * Dynamic Path Configuration System
 * Works for both localhost and hosted environments regardless of folder name
 */

// Get the project root directory (where this config file is located)
define('PROJECT_ROOT', __DIR__ . '/..');

// Get the current script's directory depth from project root
function getCurrentDepth() {
    // Get the current script's directory
    $currentScriptDir = dirname($_SERVER['SCRIPT_NAME']);
    
    // Get the project root directory (where config/paths.php is located)
    $projectRootDir = dirname(dirname($_SERVER['SCRIPT_NAME']));
    
    // If we're at the project root, depth is 0
    if ($currentScriptDir === $projectRootDir) {
        return 0;
    }
    
    // Count the difference in directory levels
    $currentParts = explode('/', trim($currentScriptDir, '/'));
    $projectParts = explode('/', trim($projectRootDir, '/'));
    
    // Calculate depth based on how many levels deeper we are
    $depth = count($currentParts) - count($projectParts);
    
    return max(0, $depth);
}

// Generate relative path for includes (like admin section)
function getIncludePath($file) {
    $depth = getCurrentDepth();
    $relativePath = str_repeat('../', $depth) . 'includes/' . $file;
    return $relativePath;
}

// Generate relative path for config files
function getConfigPath($file) {
    $depth = getCurrentDepth();
    $relativePath = str_repeat('../', $depth) . 'config/' . $file;
    return $relativePath;
}

// Generate URL path for assets (CSS, JS, images)
function getAssetPath($file) {
    $depth = getCurrentDepth();
    $relativePath = str_repeat('../', $depth) . 'assets/' . $file;
    return $relativePath;
}

// Generate URL path for uploads
function getUploadPath($file) {
    $depth = getCurrentDepth();
    $relativePath = str_repeat('../', $depth) . 'uploads/' . $file;
    return $relativePath;
}

// Generate URL path for pages
function getPagePath($page) {
    $depth = getCurrentDepth();
    $relativePath = str_repeat('../', $depth) . $page;
    return $relativePath;
}

// Generate URL path for admin pages
function getAdminPath($page) {
    $depth = getCurrentDepth();
    $relativePath = str_repeat('../', $depth) . 'admin/' . $page;
    return $relativePath;
}

// Get base URL for the project (for absolute URLs when needed)
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $parts = explode('/', trim($scriptName, '/'));
    $base = '';
    if (count($parts) > 1) {
        $base = '/' . $parts[0];
    }
    return $protocol . '://' . $host . $base;
}

// Get project base path (for includes that need absolute paths)
function getProjectBasePath() {
    return PROJECT_ROOT;
}

// Helper function to check if we're in admin section
function isAdminSection() {
    return strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false;
}

// Helper function to get relative path to project root
function getRelativeToRoot() {
    $depth = getCurrentDepth();
    return str_repeat('../', $depth);
}
?> 