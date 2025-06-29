<?php

use Peking\Admin\DishRepository;

/**
 * Modern adapter for legacy Jelo class
 * Maintains backward compatibility while using secure modern Database class.
 */
class JeloModern
{
    private DishRepository $repository;

    public function __construct()
    {
        $this->repository = new DishRepository();
    }

    public function getJela($value): array
    {
        try {
            return $this->repository->getByMenuId((int) $value);
        } catch (Exception $e) {
            error_log('Error fetching dishes: ' . $e->getMessage());

            return [];
        }
    }

    public function chooseJelo($value): array
    {
        try {
            $dish = $this->repository->getById((int) $value);

            return $dish ? [$dish] : [];
        } catch (Exception $e) {
            error_log('Error fetching dish: ' . $e->getMessage());

            return [];
        }
    }

    public function insertJelo($sort, $broj, $naziv, $naziv_en, $cijena, $mid): bool
    {
        try {
            $this->repository->create([
                'sort' => (int) $sort,
                'broj' => $broj,
                'naziv' => $naziv,
                'naziv_en' => $naziv_en,
                'cijena' => $cijena,
                'mid' => (int) $mid,
            ]);

            return true;
        } catch (Exception $e) {
            error_log('Error inserting dish: ' . $e->getMessage());

            return false;
        }
    }

    public function deleteJelo($jid): bool
    {
        try {
            return $this->repository->delete((int) $jid);
        } catch (Exception $e) {
            error_log('Error deleting dish: ' . $e->getMessage());

            return false;
        }
    }

    public function editJelo($jid, $broj, $sort, $naziv, $naziv_en, $cijena): bool
    {
        try {
            return $this->repository->update((int) $jid, [
                'sort' => (int) $sort,
                'broj' => $broj,
                'naziv' => $naziv,
                'naziv_en' => $naziv_en,
                'cijena' => $cijena,
            ]);
        } catch (Exception $e) {
            error_log('Error updating dish: ' . $e->getMessage());

            return false;
        }
    }
}
