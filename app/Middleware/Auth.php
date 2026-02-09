<?php

namespace App\Middleware;

class Auth
{
    public static function check()
    {
        return isset($_SESSION['userId']);
    }

    public static function requireAuth()
    {
        if (!self::check()) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    public static function login($userId, $username)
    {
        session_regenerate_id(true);
        $_SESSION['userId'] = $userId;
        $_SESSION['username'] = $username;
    }

    public static function logout()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }
}
