<?php

// Legacy configuration - use environment variables if available, fallback to defaults
define('DB_TYPE', 'mysql');
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'peking');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'root');

define('SALT', $_ENV['SALT'] ?? 'e2313peking32iaew');

// Security warning for production
if (DB_USER === 'root' && DB_PASS === 'root') {
    error_log('WARNING: Using default database credentials. Please update your .env file.');
}
