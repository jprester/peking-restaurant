<?php

namespace App\Controllers\Api;

use App\Models\User;
use App\Middleware\Auth;
use App\Middleware\Csrf;
use PDO;

class AuthController
{
    private $userModel;

    public function __construct(PDO $pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function login()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $username = trim($input['username'] ?? '');
        $password = $input['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->json(['error' => 'Username and password are required'], 400);
            return;
        }

        $user = $this->userModel->authenticate($username, $password);
        if (!$user) {
            $this->json(['error' => 'Invalid credentials'], 401);
            return;
        }

        Auth::login($user['id'], $user['username']);

        $this->json([
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
            ],
            'csrfToken' => Csrf::getToken(),
        ]);
    }

    public function logout()
    {
        Auth::logout();
        $this->json(['success' => true]);
    }

    public function changePassword()
    {
        Auth::requireAuth();
        Csrf::validate();

        $input = json_decode(file_get_contents('php://input'), true);
        $newPassword = $input['newPassword'] ?? '';

        if (strlen($newPassword) < 6) {
            $this->json(['error' => 'Password must be at least 6 characters long'], 400);
            return;
        }

        $this->userModel->changePassword($_SESSION['userId'], $newPassword);
        $this->json(['success' => true]);
    }

    private function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
