<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class SiteSetting
{
    private static ?array $cache = null;

    public static function all(): array
    {
        if (self::$cache === null) {
            $rows = Database::fetchAll('SELECT setting_key, setting_value FROM site_settings');
            self::$cache = [];
            foreach ($rows as $row) {
                self::$cache[$row['setting_key']] = $row['setting_value'];
            }
        }
        return self::$cache;
    }

    public static function get(string $key, string $default = ''): string
    {
        $all = self::all();
        return $all[$key] ?? $default;
    }

    public static function set(string $key, string $value): void
    {
        $existing = Database::fetch('SELECT id FROM site_settings WHERE setting_key = ?', [$key]);
        if ($existing) {
            Database::execute('UPDATE site_settings SET setting_value = ? WHERE setting_key = ?', [$value, $key]);
        } else {
            Database::insert('site_settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
        self::$cache = null;
    }

    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            self::set($key, (string) $value);
        }
    }
}
