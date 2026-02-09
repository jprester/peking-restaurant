<?php

namespace App\Models;

use PDO;

class User
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['passwordHash'])) {
            return null;
        }

        // Rehash if needed (algorithm upgrade)
        if (password_needs_rehash($user['passwordHash'], PASSWORD_BCRYPT)) {
            $this->updatePasswordHash($user['id'], $password);
        }

        return $user;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, createdAt FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function changePassword($id, $newPassword)
    {
        return $this->updatePasswordHash($id, $newPassword);
    }

    private function updatePasswordHash($id, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET passwordHash = :hash WHERE id = :id");
        return $stmt->execute([':hash' => $hash, ':id' => $id]);
    }
}
