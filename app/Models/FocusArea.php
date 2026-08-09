<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class FocusArea
{
    public static function allActive(): array
    {
        return Database::fetchAll('SELECT * FROM focus_areas WHERE is_active = 1 ORDER BY sort_order ASC');
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM focus_areas ORDER BY sort_order ASC');
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch('SELECT * FROM focus_areas WHERE slug = ? AND is_active = 1', [$slug]);
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM focus_areas WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('focus_areas', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE focus_areas SET {$set}, updated_at = CURRENT_TIMESTAMP WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM focus_areas WHERE id = ?', [$id]);
    }
}
