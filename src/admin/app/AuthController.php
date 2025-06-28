<?php

namespace Peking\Admin;

class AuthController extends Controller
{
    public function login(): void
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->isLoggedIn()) {
            $this->redirect('/admin/private/admin.php');
        }

        $message = '';
        $messageType = 'error';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) {
                $message = 'Sigurnosna provjera neuspješna. Molimo pokušajte ponovo.';
            } else {
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';

                if (empty($username) || empty($password)) {
                    $message = 'Molimo unesite korisničko ime i lozinku.';
                } else {
                    if ($this->auth->login($username, $password)) {
                        $this->setFlashMessage('Uspješno ste se prijavili.', 'success');
                        $this->redirect('/admin/private/admin.php');
                    } else {
                        $message = 'Neispravno korisničko ime ili lozinka.';
                    }
                }
            }
        }

        // Get flash message if available
        $flash = $this->getFlashMessage();
        if ($flash) {
            $message = $flash['message'];
            $messageType = $flash['type'];
        }

        $this->render('login', [
            'message' => $message,
            'messageType' => $messageType,
            'page' => 'log'
        ]);
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->setFlashMessage('Uspješno ste se odjavili.', 'success');
        $this->redirect('/admin/');
    }
}