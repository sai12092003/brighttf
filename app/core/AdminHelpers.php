<?php

declare(strict_types=1);

namespace App\Core;

/** Small shared helpers for admin CRUD controllers to cut repetition. */
final class AdminHelpers
{
    public static function requireCsrf(string $redirectTo): void
    {
        if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
            flash_error('Your session expired. Please try again.');
            redirect($redirectTo);
        }
    }

    public static function intParam(string $key, ?int $default = null): ?int
    {
        return isset($_GET[$key]) && $_GET[$key] !== '' ? (int) $_GET[$key] : $default;
    }
}
