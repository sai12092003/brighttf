<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class SeoMeta
{
    public static function forPage(string $pageKey): ?array
    {
        return Database::fetch('SELECT * FROM seo_meta WHERE page_key = ?', [$pageKey]);
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM seo_meta ORDER BY page_key ASC');
    }

    public static function upsert(string $pageKey, array $data): void
    {
        $existing = self::forPage($pageKey);
        if ($existing) {
            Database::execute(
                'UPDATE seo_meta SET meta_title = ?, meta_description = ?, og_image = ?, canonical_url = ?, updated_at = CURRENT_TIMESTAMP WHERE page_key = ?',
                [$data['meta_title'] ?? null, $data['meta_description'] ?? null, $data['og_image'] ?? null, $data['canonical_url'] ?? null, $pageKey]
            );
        } else {
            Database::insert('seo_meta', array_merge(['page_key' => $pageKey], $data));
        }
    }
}
