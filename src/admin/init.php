<?php

// Load Composer autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

// Initialize application
use Peking\Bootstrap;
use Peking\Config;

Bootstrap::init();
Config::load();

// Backward compatibility - keep old classes for gradual migration
require_once 'config/config.php';
require_once 'classes/Db.php';
require_once 'classes/Sessions.php';
require_once 'classes/User.php';
require_once 'classes/Jelo.php';
require_once 'classes/Meni.php';
