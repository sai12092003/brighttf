<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOStatement;

/**
 * Thin PDO wrapper. Supports both "mysql" (cPanel production) and "pgsql"
 * (local development) drivers via DB_DRIVER in .env — all model code must
 * stick to portable SQL (no backticks, no MySQL-only functions) so the same
 * queries run unchanged against either driver.
 */
final class Database
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $driver = config('db.driver', 'mysql');
        $host = config('db.host');
        $port = config('db.port');
        $name = config('db.name');
        $user = config('db.user');
        $pass = config('db.pass');

        $dsn = match ($driver) {
            'pgsql' => "pgsql:host={$host};port={$port};dbname={$name}",
            default => "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4",
        };

        self::$instance = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$instance;
    }

    public static function driver(): string
    {
        return config('db.driver', 'mysql');
    }

    public static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetch(string $sql, array $params = []): ?array
    {
        $row = self::query($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function execute(string $sql, array $params = []): int
    {
        return self::query($sql, $params)->rowCount();
    }

    /**
     * Insert a row and return the new primary key.
     * $sequence is only used by the pgsql driver (table_id_seq convention).
     */
    public static function insert(string $table, array $data, ?string $sequence = null): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(static fn(string $c): string => ':' . $c, $columns);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $params = [];
        foreach ($data as $column => $value) {
            $params[':' . $column] = $value;
        }

        self::query($sql, $params);

        if (self::driver() === 'pgsql') {
            $seq = $sequence ?? "{$table}_id_seq";
            return (int) self::connection()->lastInsertId($seq);
        }

        return (int) self::connection()->lastInsertId();
    }
}
