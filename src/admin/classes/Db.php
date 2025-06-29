<?php

class Db
{
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $pdo;

    public function __construct()
    {
        try {
            $host = DB_HOST;
            $dbname = DB_NAME;
            $user = DB_USER;
            $pass = DB_PASS;
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log error securely without exposing details to users
            error_log('DEPRECATED: Legacy Db class used. Database connection error: ' . $e->getMessage());

            // Throw generic exception for security
            throw new Exception('Database connection failed. Please check your configuration.');
        }
    }
}
