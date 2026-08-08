<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class ContentBlock
{
    /** All blocks for a page, keyed by block_key => content_text (or image_path for image blocks). */
    public static function forPage(string $pageKey): array
    {
        $rows = Database::fetchAll(
            'SELECT block_key, block_type, content_text, image_path FROM content_blocks WHERE page_key = ? ORDER BY sort_order ASC',
            [$pageKey]
        );

        $blocks = [];
        foreach ($rows as $row) {
            $blocks[$row['block_key']] = $row['block_type'] === 'image'
                ? $row['image_path']
                : $row['content_text'];
        }
        return $blocks;
    }

    public static function allGroupedByPage(): array
    {
        $rows = Database::fetchAll('SELECT * FROM content_blocks ORDER BY page_key ASC, sort_order ASC');
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['page_key']][] = $row;
        }
        return $grouped;
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM content_blocks WHERE id = ?', [$id]);
    }

    public static function updateContent(int $id, string $type, ?string $text, ?string $imagePath, ?int $updatedBy): void
    {
        Database::execute(
            'UPDATE content_blocks SET content_text = ?, image_path = ?, updated_by = ?, updated_at = ? WHERE id = ?',
            [
                $type === 'image' ? null : $text,
                $type === 'image' ? $imagePath : null,
                $updatedBy,
                date('Y-m-d H:i:s'),
                $id,
            ]
        );
    }
}
