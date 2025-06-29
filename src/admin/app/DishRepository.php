<?php

namespace Peking\Admin;

class DishRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByMenuId(int $mid): array
    {
        $sql = 'SELECT * FROM jela WHERE mid = :mid ORDER BY sort';

        return $this->db->fetchAll($sql, ['mid' => $mid]);
    }

    public function getById(int $jid): ?array
    {
        $sql = 'SELECT * FROM jela WHERE jid = :jid';

        return $this->db->fetch($sql, ['jid' => $jid]);
    }

    public function create(array $data): int
    {
        return $this->db->insert('jela', [
            'sort' => $data['sort'],
            'broj' => $data['broj'],
            'naziv' => $data['naziv'],
            'naziv_en' => $data['naziv_en'] ?? '',
            'cijena' => $data['cijena'],
            'mid' => $data['mid'],
        ]);
    }

    public function update(int $jid, array $data): bool
    {
        return $this->db->update('jela', [
            'sort' => $data['sort'],
            'broj' => $data['broj'],
            'naziv' => $data['naziv'],
            'naziv_en' => $data['naziv_en'] ?? '',
            'cijena' => $data['cijena'],
        ], ['jid' => $jid]);
    }

    public function delete(int $jid): bool
    {
        return $this->db->delete('jela', ['jid' => $jid]);
    }

    public function getMaxSortForMenu(int $mid): int
    {
        $sql = 'SELECT MAX(sort) as max_sort FROM jela WHERE mid = :mid';
        $result = $this->db->fetch($sql, ['mid' => $mid]);

        return (int) ($result['max_sort'] ?? 0);
    }

    public function reorderInMenu(int $mid, array $jelaOrder): bool
    {
        try {
            $this->db->beginTransaction();

            foreach ($jelaOrder as $index => $jid) {
                $this->db->update('jela', ['sort' => $index + 1], ['jid' => $jid, 'mid' => $mid]);
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
