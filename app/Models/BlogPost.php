<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class BlogPost
{
    public static function published(int $limit = 0): array
    {
        $sql = "SELECT bp.*, bc.name AS category_name FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bc.id = bp.category_id
                WHERE bp.status = 'published' AND bp.published_at <= ?
                ORDER BY bp.published_at DESC";
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return Database::fetchAll($sql, [date('Y-m-d H:i:s')]);
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch(
            "SELECT bp.*, bc.name AS category_name FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bc.id = bp.category_id
             WHERE bp.slug = ? AND bp.status = 'published' AND bp.published_at <= ?",
            [$slug, date('Y-m-d H:i:s')]
        );
    }

    public static function incrementViews(int $id): void
    {
        Database::execute('UPDATE blog_posts SET views_count = views_count + 1 WHERE id = ?', [$id]);
    }

    public static function all(): array
    {
        return Database::fetchAll(
            'SELECT bp.*, bc.name AS category_name FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bc.id = bp.category_id
             ORDER BY bp.created_at DESC'
        );
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM blog_posts WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('blog_posts', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE blog_posts SET {$set}, updated_at = CURRENT_TIMESTAMP WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM blog_posts WHERE id = ?', [$id]);
    }
}
