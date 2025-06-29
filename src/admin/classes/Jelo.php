<?php

/**
 * DEPRECATED: Legacy Jelo class redirected to modern secure implementation
 * This class now uses JeloModern for backward compatibility.
 */
class Jelo
{
    private $modern;

    public $jid;
    public $sort;
    public $broj;
    public $naziv;
    public $naziv_en;
    public $cijena;
    public $mid;

    public function __construct()
    {
        // Log usage of legacy class
        error_log('INFO: Legacy Jelo class used. Consider migrating to Peking\Admin\DishRepository.');

        // Use modern implementation
        require_once __DIR__ . '/JeloModern.php';
        $this->modern = new JeloModern();
    }

    public function getJela($value)
    {
        return $this->modern->getJela($value);
    }

    public function chooseJelo($value)
    {
        return $this->modern->chooseJelo($value);
    }

    public function insertJelo($sort, $broj, $naziv, $naziv_en, $cijena, $mid)
    {
        return $this->modern->insertJelo($sort, $broj, $naziv, $naziv_en, $cijena, $mid);
    }

    public function deleteJelo($jid)
    {
        return $this->modern->deleteJelo($jid);
    }

    public function editJelo($jid, $broj, $sort, $naziv, $naziv_en, $cijena)
    {
        return $this->modern->editJelo($jid, $broj, $sort, $naziv, $naziv_en, $cijena);
    }
}
