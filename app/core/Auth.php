<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\Admin;
use App\Models\ActivityLog;

final class Auth
{
    private const SESSION_KEY = 'admin_id';

    public static function attempt(string $username, string $password): array
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        if (RateLimiter::isLoginLocked($username, $ip)) {
            $wait = RateLimiter::secondsUntilUnlock($username, $ip);
            return ['ok' => false, 'message' => 'Too many failed attempts. Try again in ' . ceil($wait / 60) . ' minute(s).'];
        }

        $admin = Admin::findByUsername($username);

        if ($admin && !empty($admin['locked_until']) && strtotime((string) $admin['locked_until']) > time()) {
            return ['ok' => false, 'message' => 'This account is temporarily locked. Please try again later.'];
        }

        $valid = $admin && (int) $admin['is_active'] === 1 && password_verify($password, $admin['password_hash']);

        RateLimiter::recordLoginAttempt($username, $ip, $valid);

        if (!$valid) {
            if ($admin) {
                Admin::recordFailedAttempt((int) $admin['id'], (int) $admin['failed_login_attempts'] + 1);
            }
            return ['ok' => false, 'message' => 'Invalid username or password.'];
        }

        Admin::recordSuccessfulLogin((int) $admin['id'], $ip);
        Session::regenerate();
        $_SESSION[self::SESSION_KEY] = (int) $admin['id'];
        Csrf::rotate();
        ActivityLog::record((int) $admin['id'], 'login', 'admin', (int) $admin['id'], 'Admin logged in');

        return ['ok' => true, 'message' => 'Welcome back.'];
    }

    public static function logout(): void
    {
        $id = self::id();
        if ($id !== null) {
            ActivityLog::record($id, 'logout', 'admin', $id, 'Admin logged out');
        }
        Session::destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION[self::SESSION_KEY]);
    }

    public static function id(): ?int
    {
        return isset($_SESSION[self::SESSION_KEY]) ? (int) $_SESSION[self::SESSION_KEY] : null;
    }

    public static function user(): ?array
    {
        $id = self::id();
        return $id !== null ? Admin::findById($id) : null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            redirect('/admin/login.php');
        }
    }

    public static function requireSuperAdmin(): void
    {
        self::requireLogin();
        $user = self::user();
        if (!$user || $user['role'] !== 'super_admin') {
            http_response_code(403);
            exit('Forbidden: super admin access required.');
        }
    }
}
