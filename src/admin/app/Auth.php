<?php

namespace Peking\Admin;

use Peking\Config;
use Ramsey\Uuid\Uuid;

class Auth
{
    private Database $db;
    private array $securityConfig;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->securityConfig = Config::security();
    }

    public function login(string $username, string $password): bool
    {
        // Input validation
        if (empty($username) || empty($password)) {
            return false;
        }

        $user = $this->getUserByUsername($username);

        if (!$user || !$this->verifyPassword($password, $user['password'])) {
            // Log failed attempt
            error_log("Failed login attempt for username: $username from IP: " . $_SERVER['REMOTE_ADDR']);

            return false;
        }

        // Check if password needs rehashing (security upgrade)
        if (
            password_needs_rehash(
                $user['password'],
                $this->securityConfig['password_algo'],
                $this->securityConfig['password_options'],
            )
        ) {
            $this->updateUserPassword($user['uid'], $password);
        }

        $this->createSession($user);

        return true;
    }

    public function logout(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->destroySession();
        }

        session_destroy();
        session_start();
        session_regenerate_id(true);
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['csrf_token']) && $this->validateSession();
    }

    public function getCurrentUser(): ?array
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return $this->getUserById($_SESSION['user_id']);
    }

    public function generateCSRFToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public function validateCSRFToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public function hashPassword(string $password): string
    {
        return password_hash(
            $password,
            $this->securityConfig['password_algo'],
            $this->securityConfig['password_options'],
        );
    }

    private function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    private function getUserByUsername(string $username): ?array
    {
        $sql = 'SELECT uid, username, password, email, created_at FROM users WHERE username = :username AND active = 1';

        return $this->db->fetch($sql, ['username' => $username]);
    }

    private function getUserById(int $userId): ?array
    {
        $sql = 'SELECT uid, username, email, created_at FROM users WHERE uid = :uid AND active = 1';

        return $this->db->fetch($sql, ['uid' => $userId]);
    }

    private function updateUserPassword(int $userId, string $password): void
    {
        $hashedPassword = $this->hashPassword($password);
        $this->db->update('users', ['password' => $hashedPassword], ['uid' => $userId]);
    }

    private function createSession(array $user): void
    {
        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['uid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['session_id'] = Uuid::uuid4()->toString();

        // Update last login
        $this->db->update(
            'users',
            [
                'last_login' => date('Y-m-d H:i:s'),
                'last_ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            ],
            ['uid' => $user['uid']],
        );
    }

    private function destroySession(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['login_time']);
        unset($_SESSION['last_activity']);
        unset($_SESSION['csrf_token']);
        unset($_SESSION['session_id']);
    }

    private function validateSession(): bool
    {
        // Check session timeout
        $sessionLifetime = Config::get('session.lifetime', 120) * 60;

        if (!isset($_SESSION['last_activity']) || time() - $_SESSION['last_activity'] > $sessionLifetime) {
            $this->logout();

            return false;
        }

        // Update last activity
        $_SESSION['last_activity'] = time();

        return true;
    }
}
