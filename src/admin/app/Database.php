<?php

namespace Peking\Admin;

use PDO;
use PDOException;
use Peking\Config;

class Database {
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct() {
        $config = Config::database();

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['name']};charset={$config['charset']}";
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());

            throw new \Exception('Database connection failed');
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): \PDOStatement {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt;
        } catch (PDOException $e) {
            error_log('Query failed: ' . $e->getMessage() . ' SQL: ' . $sql);

            throw new \Exception('Database query failed');
        }
    }

    public function fetch(string $sql, array $params = []): ?array {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->query($sql, $params);

        return $stmt->fetchAll();
    }

    public function insert(string $table, array $data): string {
        $fields = array_keys($data);
        $values = array_map(fn($field) => ":$field", $fields);

        $sql = "INSERT INTO {$table} (" . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';

        $this->query($sql, $data);

        return $this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, array $where): int {
        $fields = array_map(fn($field) => "$field = :$field", array_keys($data));
        $conditions = array_map(fn($field) => "$field = :where_$field", array_keys($where));

        $sql = "UPDATE {$table} SET " . implode(', ', $fields) . ' WHERE ' . implode(' AND ', $conditions);

        $params = array_merge(
            $data,
            array_combine(array_map(fn($key) => "where_$key", array_keys($where)), array_values($where)),
        );

        $stmt = $this->query($sql, $params);

        return $stmt->rowCount();
    }

    public function delete(string $table, array $where): int {
        $conditions = array_map(fn($field) => "$field = :$field", array_keys($where));
        $sql = "DELETE FROM {$table} WHERE " . implode(' AND ', $conditions);

        $stmt = $this->query($sql, $where);

        return $stmt->rowCount();
    }

    public function beginTransaction(): bool {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool {
        return $this->pdo->commit();
    }

    public function rollback(): bool {
        return $this->pdo->rollback();
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {}
}
