<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class BlogCategory
{
    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM blog_categories ORDER BY name ASC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM blog_categories WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('blog_categories', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE blog_categories SET {$set} WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM blog_categories WHERE id = ?', [$id]);
    }
}
