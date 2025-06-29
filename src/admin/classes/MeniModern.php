<?php

use Peking\Admin\MenuRepository;

/**
 * Modern adapter for legacy Meni class
 * Maintains backward compatibility while using secure modern Database class.
 */
class MeniModern
{
    private MenuRepository $repository;

    public function __construct()
    {
        $this->repository = new MenuRepository();
    }

    public function getMeni(): array
    {
        try {
            return $this->repository->getAll();
        } catch (Exception $e) {
            error_log('Error fetching menu: ' . $e->getMessage());

            return [];
        }
    }

    public function chooseMeni($value): ?string
    {
        try {
            return $this->repository->getMenuName((int) $value);
        } catch (Exception $e) {
            error_log('Error fetching menu name: ' . $e->getMessage());

            return null;
        }
    }
}
