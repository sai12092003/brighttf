<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class GalleryImage
{
    public static function allActive(?int $albumId = null): array
    {
        if ($albumId !== null) {
            return Database::fetchAll(
                'SELECT * FROM gallery_images WHERE is_active = 1 AND album_id = ? ORDER BY sort_order ASC',
                [$albumId]
            );
        }
        return Database::fetchAll('SELECT * FROM gallery_images WHERE is_active = 1 ORDER BY sort_order ASC');
    }

    public static function all(): array
    {
        return Database::fetchAll(
            'SELECT gi.*, ga.title AS album_title FROM gallery_images gi
             LEFT JOIN gallery_albums ga ON ga.id = gi.album_id
             ORDER BY gi.sort_order ASC'
        );
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM gallery_images WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('gallery_images', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE gallery_images SET {$set} WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM gallery_images WHERE id = ?', [$id]);
    }
}
