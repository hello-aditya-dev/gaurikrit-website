<?php
/**
 * Gaurikrit Bio Products — bootstrap
 * Loaded by every page. Sets up config, data, helpers, session.
 */

declare(strict_types=1);

// Define paths.
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('ASSETS_PATH', ROOT_PATH . '/assets');

// Load configuration (config.php is gitignored in production).
$configFile = ROOT_PATH . '/config.php';
if (is_file($configFile)) {
    $config = require $configFile;
} else {
    // Development fallback — never has real credentials.
    $config = require ROOT_PATH . '/config.example.php';
}

// Load helpers.
require_once INCLUDES_PATH . '/helpers.php';

// Load brand data (company, products, claims, certs).
require_once INCLUDES_PATH . '/data.php';

// Start session for CSRF tokens.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
