<?php

namespace Peking\Admin;

class MenuManager {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllMenus(): array {
        $sql = 'SELECT mid, meni_ime, en_ime FROM meni ORDER BY mid';

        return $this->db->fetchAll($sql);
    }

    public function getMenuById(int $menuId): ?array {
        $sql = 'SELECT mid, meni_ime, en_ime FROM meni WHERE mid = :mid';

        return $this->db->fetch($sql, ['mid' => $menuId]);
    }

    public function getMenuByName(string $name): ?array {
        $sql = 'SELECT mid, meni_ime, en_ime FROM meni WHERE meni_ime = :name';

        return $this->db->fetch($sql, ['name' => $name]);
    }

    public function createMenu(array $data): string {
        $validator = new Validator($data);

        if (
            !$validator->validate([
                'meni_ime' => ['required', 'min:2', 'max:100'],
                'en_ime' => ['required', 'min:2', 'max:100'],
            ])
        ) {
            throw new \InvalidArgumentException($validator->getFirstError());
        }

        $cleanData = $validator->getCleanData();

        return $this->db->insert('meni', $cleanData);
    }

    public function updateMenu(int $menuId, array $data): bool {
        $validator = new Validator($data);

        if (
            !$validator->validate([
                'meni_ime' => ['required', 'min:2', 'max:100'],
                'en_ime' => ['required', 'min:2', 'max:100'],
            ])
        ) {
            throw new \InvalidArgumentException($validator->getFirstError());
        }

        $cleanData = $validator->getCleanData();
        $rowsAffected = $this->db->update('meni', $cleanData, ['mid' => $menuId]);

        return $rowsAffected > 0;
    }

    public function deleteMenu(int $menuId): bool {
        // Check if menu has dishes
        $dishCount = $this->db->fetch('SELECT COUNT(*) as count FROM jela WHERE mid = :mid', ['mid' => $menuId]);

        if ($dishCount['count'] > 0) {
            throw new \Exception('Cannot delete menu that contains dishes');
        }

        $rowsAffected = $this->db->delete('meni', ['mid' => $menuId]);

        return $rowsAffected > 0;
    }

    public function getDishesByMenu(int $menuId): array {
        $sql = 'SELECT jid, sort, broj, naziv, naziv_en, cijena, mid 
                FROM jela 
                WHERE mid = :mid 
                ORDER BY sort ASC, jid ASC';

        return $this->db->fetchAll($sql, ['mid' => $menuId]);
    }

    public function getDishById(int $dishId): ?array {
        $sql = 'SELECT jid, sort, broj, naziv, naziv_en, cijena, mid FROM jela WHERE jid = :jid';

        return $this->db->fetch($sql, ['jid' => $dishId]);
    }

    public function createDish(array $data): string {
        $validator = new Validator($data);

        if (
            !$validator->validate([
                'broj' => ['required', 'max:6'],
                'naziv' => ['required', 'min:2', 'max:500'],
                'naziv_en' => ['required', 'min:2', 'max:500'],
                'cijena' => ['required', 'price'],
                'mid' => ['required', 'numeric'],
                'sort' => ['numeric'],
            ])
        ) {
            throw new \InvalidArgumentException($validator->getFirstError());
        }

        $cleanData = $validator->getCleanData();

        // Normalize price format
        $cleanData['cijena'] = str_replace(',', '.', $cleanData['cijena']);

        // Set default sort order if not provided
        if (empty($cleanData['sort'])) {
            $maxSort = $this->db->fetch('SELECT MAX(sort) as max_sort FROM jela WHERE mid = :mid', [
                'mid' => $cleanData['mid'],
            ]);
            $cleanData['sort'] = ($maxSort['max_sort'] ?? 0) + 1;
        }

        return $this->db->insert('jela', $cleanData);
    }

    public function updateDish(int $dishId, array $data): bool {
        $validator = new Validator($data);

        if (
            !$validator->validate([
                'broj' => ['required', 'max:6'],
                'naziv' => ['required', 'min:2', 'max:500'],
                'naziv_en' => ['required', 'min:2', 'max:500'],
                'cijena' => ['required', 'price'],
                'mid' => ['required', 'numeric'],
                'sort' => ['numeric'],
            ])
        ) {
            throw new \InvalidArgumentException($validator->getFirstError());
        }

        $cleanData = $validator->getCleanData();

        // Normalize price format
        $cleanData['cijena'] = str_replace(',', '.', $cleanData['cijena']);

        $rowsAffected = $this->db->update('jela', $cleanData, ['jid' => $dishId]);

        return $rowsAffected > 0;
    }

    public function deleteDish(int $dishId): bool {
        $rowsAffected = $this->db->delete('jela', ['jid' => $dishId]);

        return $rowsAffected > 0;
    }

    public function reorderDishes(int $menuId, array $dishOrder): bool {
        try {
            $this->db->beginTransaction();

            foreach ($dishOrder as $index => $dishId) {
                $this->db->update('jela', ['sort' => $index + 1], ['jid' => $dishId, 'mid' => $menuId]);
            }

            $this->db->commit();

            return true;
        } catch (\Exception $e) {
            $this->db->rollback();
            error_log('Failed to reorder dishes: ' . $e->getMessage());

            return false;
        }
    }
}
