<?php

declare(strict_types=1);

namespace App\Core;

final class RateLimiter
{
    private const MAX_ATTEMPTS = 5;
    private const WINDOW_SECONDS = 900; // 15 minutes
    private const LOCKOUT_SECONDS = 900; // 15 minutes

    public static function recordLoginAttempt(string $identifier, string $ip, bool $success): void
    {
        Database::insert('login_attempts', [
            'identifier' => $identifier,
            'ip_address' => $ip,
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
            'success' => $success ? 1 : 0,
        ]);
    }

    /** True when the identifier or IP has too many recent failed attempts. */
    public static function isLoginLocked(string $identifier, string $ip): bool
    {
        $since = self::since();

        $count = Database::fetch(
            'SELECT COUNT(*) AS cnt FROM login_attempts
             WHERE success = 0 AND attempted_at >= ? AND (identifier = ? OR ip_address = ?)',
            [$since, $identifier, $ip]
        );

        return (int) ($count['cnt'] ?? 0) >= self::MAX_ATTEMPTS;
    }

    public static function secondsUntilUnlock(string $identifier, string $ip): int
    {
        $since = self::since();
        $row = Database::fetch(
            'SELECT MAX(attempted_at) AS last_attempt FROM login_attempts
             WHERE success = 0 AND attempted_at >= ? AND (identifier = ? OR ip_address = ?)',
            [$since, $identifier, $ip]
        );

        if (empty($row['last_attempt'])) {
            return 0;
        }

        $lastAttempt = strtotime((string) $row['last_attempt']);
        $unlockAt = $lastAttempt + self::LOCKOUT_SECONDS;
        return max(0, $unlockAt - time());
    }

    private static function since(): string
    {
        return date('Y-m-d H:i:s', time() - self::WINDOW_SECONDS);
    }
}
