<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Admin
{
    public static function findByUsername(string $username): ?array
    {
        return Database::fetch('SELECT * FROM admins WHERE username = ?', [$username]);
    }

    public static function findById(int $id): ?array
    {
        return Database::fetch('SELECT * FROM admins WHERE id = ?', [$id]);
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM admins ORDER BY created_at ASC');
    }

    public static function create(array $data): int
    {
        return Database::insert('admins', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE admins SET {$set} WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM admins WHERE id = ?', [$id]);
    }

    public static function recordFailedAttempt(int $id, int $attempts): void
    {
        $lockedUntil = null;
        if ($attempts >= 5) {
            $lockedUntil = date('Y-m-d H:i:s', time() + 900);
        }
        Database::execute(
            'UPDATE admins SET failed_login_attempts = ?, locked_until = ? WHERE id = ?',
            [$attempts, $lockedUntil, $id]
        );
    }

    public static function recordSuccessfulLogin(int $id, string $ip): void
    {
        Database::execute(
            'UPDATE admins SET failed_login_attempts = 0, locked_until = NULL, last_login_at = ?, last_login_ip = ? WHERE id = ?',
            [date('Y-m-d H:i:s'), $ip, $id]
        );
    }
}
