<?php

namespace App\Models;

use PDO;

class ComboMenu
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $menus = $this->pdo->query(
            "SELECT * FROM comboMenus ORDER BY sortOrder"
        )->fetchAll();

        foreach ($menus as &$menu) {
            $menu['items'] = $this->getItems((int) $menu['id']);
        }

        return $menus;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM comboMenus WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $menu = $stmt->fetch();
        if (!$menu) {
            return null;
        }
        $menu['items'] = $this->getItems($id);
        return $menu;
    }

    public function getByPersonCount($personCount)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM comboMenus WHERE personCount = :personCount ORDER BY sortOrder"
        );
        $stmt->execute([':personCount' => $personCount]);
        $menus = $stmt->fetchAll();

        foreach ($menus as &$menu) {
            $menu['items'] = $this->getItems((int) $menu['id']);
        }

        return $menus;
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO comboMenus (name, nameCro, nameEn, personCount, price, sortOrder)
             VALUES (:name, :nameCro, :nameEn, :personCount, :price, :sortOrder)"
        );
        $stmt->execute([
            ':name' => $data['name'],
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':personCount' => $data['personCount'],
            ':price' => $data['price'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE comboMenus SET name = :name, nameCro = :nameCro, nameEn = :nameEn,
             personCount = :personCount, price = :price, sortOrder = :sortOrder
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':personCount' => $data['personCount'],
            ':price' => $data['price'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM comboMenus WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // --- Combo menu items ---

    public function getItems($menuId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM comboMenuItems WHERE comboMenuId = :comboMenuId ORDER BY sortOrder"
        );
        $stmt->execute([':comboMenuId' => $menuId]);
        return $stmt->fetchAll();
    }

    public function addItem($menuId, $data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO comboMenuItems (comboMenuId, itemNumber, nameCro, nameEn, sortOrder)
             VALUES (:comboMenuId, :itemNumber, :nameCro, :nameEn, :sortOrder)"
        );
        $stmt->execute([
            ':comboMenuId' => $menuId,
            ':itemNumber' => $data['itemNumber'],
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updateItem($menuId, $itemId, $data)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE comboMenuItems SET itemNumber = :itemNumber, nameCro = :nameCro,
             nameEn = :nameEn, sortOrder = :sortOrder
             WHERE id = :itemId AND comboMenuId = :comboMenuId"
        );
        return $stmt->execute([
            ':itemId' => $itemId,
            ':comboMenuId' => $menuId,
            ':itemNumber' => $data['itemNumber'],
            ':nameCro' => $data['nameCro'],
            ':nameEn' => $data['nameEn'],
            ':sortOrder' => $data['sortOrder'] ?? 0,
        ]);
    }

    public function deleteItem($menuId, $itemId)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM comboMenuItems WHERE id = :itemId AND comboMenuId = :comboMenuId"
        );
        return $stmt->execute([
            ':itemId' => $itemId,
            ':comboMenuId' => $menuId,
        ]);
    }
}
