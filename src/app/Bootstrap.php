<?php

namespace Peking;

use Dotenv\Dotenv;

class Bootstrap
{
    public static function init(): void
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        // Set error reporting based on environment
        if ($_ENV['APP_ENV'] === 'development') {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        // Configure session settings
        self::configureSession();

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Set default timezone
        date_default_timezone_set('Europe/Zagreb');
    }

    private static function configureSession(): void
    {
        // Only configure session if no output has been sent yet
        if (!headers_sent()) {
            // Session security configuration
            ini_set('session.cookie_lifetime', $_ENV['SESSION_LIFETIME'] * 60);
            ini_set('session.cookie_secure', $_ENV['SESSION_SECURE'] ?? false);
            ini_set('session.cookie_httponly', $_ENV['SESSION_HTTP_ONLY'] ?? true);
            ini_set('session.cookie_samesite', $_ENV['SESSION_SAME_SITE'] ?? 'Strict');
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_only_cookies', 1);
        }

        // Regenerate session ID periodically
        if (isset($_SESSION['last_regeneration']) && time() - $_SESSION['last_regeneration'] > 300) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        } elseif (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        }
    }
}
