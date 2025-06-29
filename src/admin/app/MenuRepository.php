<?php

namespace Peking\Admin;

class MenuRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $sql = 'SELECT mid, meni_ime, en_ime FROM meni ORDER BY mid';

        return $this->db->fetchAll($sql);
    }

    public function getById(int $mid): ?array
    {
        $sql = 'SELECT mid, meni_ime, en_ime FROM meni WHERE mid = :mid';

        return $this->db->fetch($sql, ['mid' => $mid]);
    }

    public function getMenuName(int $mid): ?string
    {
        $menu = $this->getById($mid);

        return $menu ? $menu['meni_ime'] : null;
    }

    public function create(array $data): int
    {
        return $this->db->insert('meni', [
            'meni_ime' => $data['meni_ime'],
            'en_ime' => $data['en_ime'] ?? '',
        ]);
    }

    public function update(int $mid, array $data): bool
    {
        return $this->db->update('meni', [
            'meni_ime' => $data['meni_ime'],
            'en_ime' => $data['en_ime'] ?? '',
        ], ['mid' => $mid]);
    }

    public function delete(int $mid): bool
    {
        return $this->db->delete('meni', ['mid' => $mid]);
    }
}
