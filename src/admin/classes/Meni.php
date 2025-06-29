<?php

/**
 * DEPRECATED: Legacy Meni class redirected to modern secure implementation
 * This class now uses MeniModern for backward compatibility.
 */
class Meni
{
    private $modern;

    public $mid;
    public $meni_ime;
    public $en_ime;

    public function __construct()
    {
        // Log usage of legacy class
        error_log('INFO: Legacy Meni class used. Consider migrating to Peking\Admin\MenuRepository.');

        // Use modern implementation
        require_once __DIR__ . '/MeniModern.php';
        $this->modern = new MeniModern();
    }

    public function getMeni()
    {
        return $this->modern->getMeni();
    }

    public function chooseMeni($value)
    {
        return $this->modern->chooseMeni($value);
    }
}
