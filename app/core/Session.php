<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    private const IDLE_TIMEOUT = 1800; // 30 minutes
    private const ABSOLUTE_TIMEOUT = 43200; // 12 hours

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

        session_name('btf_session');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
        session_start();

        $now = time();

        if (isset($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > self::IDLE_TIMEOUT) {
            self::destroy();
            session_start();
        }

        if (isset($_SESSION['_started_at']) && ($now - $_SESSION['_started_at']) > self::ABSOLUTE_TIMEOUT) {
            self::destroy();
            session_start();
        }

        if (!isset($_SESSION['_started_at'])) {
            $_SESSION['_started_at'] = $now;
        }
        $_SESSION['_last_activity'] = $now;
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
        $_SESSION['_started_at'] = time();
        $_SESSION['_last_activity'] = time();
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}
