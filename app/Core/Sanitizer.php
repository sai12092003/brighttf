<?php

declare(strict_types=1);

namespace App\Core;

final class Sanitizer
{
    public static function str(mixed $value): string
    {
        return is_string($value) ? trim($value) : '';
    }

    public static function email(mixed $value): string
    {
        $value = self::str($value);
        $filtered = filter_var($value, FILTER_SANITIZE_EMAIL);
        return $filtered !== false ? $filtered : '';
    }

    public static function isValidEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function slug(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        return trim($value, '-');
    }

    /**
     * Allow-list HTML filter for admin-authored rich text (blog body, content
     * blocks). Strips scripts/handlers/styles instead of trusting raw WYSIWYG
     * output, since that output is later rendered unescaped on public pages.
     */
    public static function richText(string $html): string
    {
        $allowed = '<p><br><strong><b><em><i><u><ul><ol><li><h2><h3><h4><a><blockquote><img>';
        $clean = strip_tags($html, $allowed);
        // Strip on*="" event handler attributes and javascript: URLs that survive strip_tags.
        $clean = preg_replace('/\son\w+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $clean) ?? $clean;
        $clean = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1=$2#$2', $clean) ?? $clean;
        return $clean;
    }

    public static function int(mixed $value, int $default = 0): int
    {
        return is_numeric($value) ? (int) $value : $default;
    }

    public static function decimal(mixed $value, float $default = 0.0): float
    {
        return is_numeric($value) ? (float) $value : $default;
    }
}
