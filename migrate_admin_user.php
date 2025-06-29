<?php

/**
 * Migration script to create secure admin user
 * Run this once to set up the modern authentication system
 */

require_once 'vendor/autoload.php';
require_once 'src/admin/init.php';

use Peking\Admin\Database;
use Peking\Admin\Auth;

// Create secure admin user
function createAdminUser(): void {
    $db = Database::getInstance();
    $auth = new Auth();
    
    // Check if users table exists and has the right structure
    $sql = "SHOW TABLES LIKE 'users'";
    $result = $db->query($sql);
    
    if (empty($result)) {
        echo "Creating users table...\n";
        
        $createTable = "
        CREATE TABLE users (
            uid int(11) NOT NULL AUTO_INCREMENT,
            username varchar(50) NOT NULL UNIQUE,
            password varchar(255) NOT NULL,
            email varchar(100) DEFAULT NULL,
            active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            last_login timestamp NULL DEFAULT NULL,
            last_ip varchar(45) DEFAULT NULL,
            PRIMARY KEY (uid),
            INDEX idx_username (username),
            INDEX idx_active (active)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $db->query($createTable);
        echo "Users table created.\n";
    }
    
    // Check if admin user exists
    $existingUser = $db->fetch(
        "SELECT uid FROM users WHERE username = :username",
        ['username' => 'admin']
    );
    
    if ($existingUser) {
        echo "Admin user already exists.\n";
        
        // Ask if user wants to update password
        echo "Do you want to update the admin password? (y/n): ";
        $handle = fopen("php://stdin", "r");
        $input = trim(fgets($handle));
        fclose($handle);
        
        if (strtolower($input) !== 'y') {
            echo "Skipping password update.\n";
            return;
        }
    }
    
    // Get new password
    echo "Enter new admin password (min 8 characters): ";
    $handle = fopen("php://stdin", "r");
    $password = trim(fgets($handle));
    fclose($handle);
    
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.\n";
        return;
    }
    
    // Hash password using modern security
    $hashedPassword = $auth->hashPassword($password);
    
    if ($existingUser) {
        // Update existing user
        $db->update(
            'users',
            ['password' => $hashedPassword],
            ['uid' => $existingUser['uid']]
        );
        echo "Admin password updated successfully.\n";
    } else {
        // Create new admin user
        $db->insert('users', [
            'username' => 'admin',
            'password' => $hashedPassword,
            'email' => 'admin@peking-restaurant.local',
            'active' => 1
        ]);
        echo "Admin user created successfully.\n";
    }
    
    echo "\nSecurity migration completed!\n";
    echo "You can now log in at /admin/login_new.php with:\n";
    echo "Username: admin\n";
    echo "Password: [the password you just entered]\n";
}

// Run the migration
try {
    createAdminUser();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Please check your database connection and try again.\n";
}