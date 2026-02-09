<?php

namespace App\Models;

use PDO;

class Category
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query(
            "SELECT *, 
            (SELECT COUNT(*) FROM dishes WHERE categoryId = categories.id) as dishCount
             FROM categories 
             ORDER BY sortOrder"
        );
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO categories (nameCro, nameEn, sortOrder)
             VALUES (:nameCro, :nameEn, :sortOrder)"
        );
        $stmt->execute([
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE categories SET nameCro = :nameCro, nameEn = :nameEn, sortOrder = :sortOrder
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
    }

    public function updateSortOrder($id, $sortOrder)
    {
        $stmt = $this->pdo->prepare("UPDATE categories SET sortOrder = :sortOrder WHERE id = :id");
        return $stmt->execute([':id' => $id, ':sortOrder' => $sortOrder]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
