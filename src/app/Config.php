<?php

namespace Peking;

class Config
{
    private static array $config = [];

    public static function load(): void
    {
        self::$config = [
            'database' => [
                'host' => $_ENV['DB_HOST'],
                'name' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
                'charset' => 'utf8',
                'options' => [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            ],
            'security' => [
                'salt' => $_ENV['SALT'],
                'password_algo' => PASSWORD_ARGON2ID,
                'password_options' => [
                    'memory_cost' => 65536,
                    'time_cost' => 4,
                    'threads' => 3
                ]
            ],
            'app' => [
                'env' => $_ENV['APP_ENV'],
                'debug' => filter_var($_ENV['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN),
                'key' => $_ENV['APP_KEY'] ?? ''
            ],
            'session' => [
                'lifetime' => (int)$_ENV['SESSION_LIFETIME'],
                'secure' => filter_var($_ENV['SESSION_SECURE'], FILTER_VALIDATE_BOOLEAN),
                'httponly' => filter_var($_ENV['SESSION_HTTP_ONLY'], FILTER_VALIDATE_BOOLEAN),
                'samesite' => $_ENV['SESSION_SAME_SITE']
            ]
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = self::$config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    public static function database(): array
    {
        return self::get('database');
    }

    public static function security(): array
    {
        return self::get('security');
    }

    public static function isDebug(): bool
    {
        return self::get('app.debug', false);
    }
}