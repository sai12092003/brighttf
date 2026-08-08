<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class GalleryAlbum
{
    public static function allActive(): array
    {
        return Database::fetchAll('SELECT * FROM gallery_albums WHERE is_active = 1 ORDER BY sort_order ASC');
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM gallery_albums ORDER BY sort_order ASC');
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch('SELECT * FROM gallery_albums WHERE slug = ? AND is_active = 1', [$slug]);
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM gallery_albums WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('gallery_albums', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE gallery_albums SET {$set} WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM gallery_albums WHERE id = ?', [$id]);
    }
}
