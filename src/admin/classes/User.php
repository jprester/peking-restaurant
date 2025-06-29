<?php

/**
 * DEPRECATED: Legacy User class with severe security vulnerabilities
 * This class has been disabled for security reasons.
 * Use Peking\Admin\Auth class instead.
 */
class User extends Db
{
    public function __construct()
    {
        parent::__construct();

        // Log security warning
        error_log('SECURITY WARNING: Attempt to use deprecated User class with vulnerabilities. Use Peking\Admin\Auth instead.');

        // Prevent instantiation
        throw new Exception('This class has been deprecated due to security vulnerabilities. Use Peking\Admin\Auth instead.');
    }

    public function login($username, $password)
    {
        throw new Exception('Legacy authentication disabled. Use modern Auth system.');
    }

    public function logout()
    {
        throw new Exception('Legacy authentication disabled. Use modern Auth system.');
    }
}
