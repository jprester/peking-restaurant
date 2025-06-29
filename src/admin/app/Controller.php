<?php

namespace Peking\Admin;

abstract class Controller
{
    protected Auth $auth;
    protected array $data = [];

    public function __construct()
    {
        $this->auth = new Auth();
    }

    protected function requireAuth(): void
    {
        if (!$this->auth->isLoggedIn()) {
            $this->redirect('/admin/');
        }
    }

    protected function redirect(string $path): void
    {
        header("Location: $path");
        exit();
    }

    protected function render(string $view, array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
        extract($this->data);

        $viewPath = __DIR__ . "/../views/$view.php";

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new \Exception("View not found: $view");
        }
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function setFlashMessage(string $message, string $type = 'info'): void
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    protected function getFlashMessage(): ?array
    {
        if (isset($_SESSION['flash_message'])) {
            $message = [
                'message' => $_SESSION['flash_message'],
                'type' => $_SESSION['flash_type'] ?? 'info',
            ];

            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);

            return $message;
        }

        return null;
    }

    protected function validateCSRF(): bool
    {
        $token = $_POST['csrf_token'] ?? '';

        return Validator::validateCSRF($token);
    }
}
