<?php

namespace App\Models;

use PDO;

class Dish
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll($categoryId = null)
    {
        if ($categoryId !== null) {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM dishes WHERE categoryId = :categoryId ORDER BY sortOrder"
            );
            $stmt->execute([':categoryId' => $categoryId]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM dishes ORDER BY categoryId, sortOrder");
        }
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dishes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO dishes (categoryId, dishNumber, nameCro, nameEn, price, sortOrder)
             VALUES (:categoryId, :dishNumber, :nameCro, :nameEn, :price, :sortOrder)"
        );
        $stmt->execute([
            ':categoryId' => $data['categoryId'],
            ':dishNumber' => $data['dishNumber'] ?? null,
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':price' => $data['price'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE dishes SET categoryId = :categoryId, dishNumber = :dishNumber,
             nameCro = :nameCro, nameEn = :nameEn, price = :price, sortOrder = :sortOrder
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':categoryId' => $data['categoryId'],
            ':dishNumber' => $data['dishNumber'] ?? null,
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':price' => $data['price'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
    }

    public function updateSortOrder($id, $sortOrder)
    {
        $stmt = $this->pdo->prepare("UPDATE dishes SET sortOrder = :sortOrder WHERE id = :id");
        return $stmt->execute([':id' => $id, ':sortOrder' => $sortOrder]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM dishes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
