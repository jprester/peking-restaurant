<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct($config)
    {
        $host = $config['host'];
        $port = isset($config['port']) ? ";port={$config['port']}" : '';
        $socket = ($host === 'localhost' || $host === 'localhost:/var/run/mysqld/mysqld.sock')
         ? ';unix_socket=/var/run/mysqld/mysqld.sock'
        : '';
            $dsn = "mysql:host={$host}{$socket}{$port};dbname={$config['name']};charset={$config['charset']}";

        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new PDOException('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance($config = [])
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
