<?php

namespace App\Middleware;

class Csrf
{
    public static function getToken()
    {
        if (empty($_SESSION['csrfToken'])) {
            $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrfToken'];
    }

    public static function validate()
    {
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

        if (!$token || !hash_equals($_SESSION['csrfToken'] ?? '', $token)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit;
        }
    }
}
