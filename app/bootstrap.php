<?php

define('APP_ROOT', __DIR__);
define('PUBLIC_ROOT', APP_ROOT . '/../public');

// Detect base URL for subfolder installations
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/';
$baseDir = dirname($scriptName);
if ($baseDir === DIRECTORY_SEPARATOR || $baseDir === '\\') {
    $baseDir = '';
}
define('BASE_URL', rtrim($baseDir, '/'));

$config = require APP_ROOT . '/config.php';

if ($config['app']['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

spl_autoload_register(function ($class) {
    $map = [
        'App\\Models\\' => APP_ROOT . '/Models/',
        'App\\Controllers\\Api\\' => APP_ROOT . '/Controllers/Api/',
        'App\\Controllers\\' => APP_ROOT . '/Controllers/',
        'App\\Middleware\\' => APP_ROOT . '/Middleware/',
        'App\\' => APP_ROOT . '/',
    ];

    foreach ($map as $prefix => $dir) {
        if (substr($class, 0, strlen($prefix)) === $prefix) {
            $relativeClass = substr($class, strlen($prefix));
            $file = $dir . $relativeClass . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});

session_start();

$db = App\Models\Database::getInstance($config['db']);
