<?php

declare(strict_types=1);

// Central bootstrap: autoloading, config, error handling, session start.
// Required by both public_html/index.php and every public_html/admin/*.php file.

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $path = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($path)) {
        require $path;
    }
});

$config = require __DIR__ . '/config/config.php';

error_reporting(E_ALL);
ini_set('display_errors', $config['app']['debug'] ? '1' : '0');
ini_set('log_errors', '1');
$logDir = $config['paths']['storage'] . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
ini_set('error_log', $logDir . '/error.log');

App\Core\Session::start();

function config(string $key, mixed $default = null): mixed
{
    static $config;
    if ($config === null) {
        $config = require __DIR__ . '/config/config.php';
    }
    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

/** Escape a string for safe HTML output. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string
{
    $base = config('app.url', '');
    if ($base === '') {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $base = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    }
    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return base_url('assets/' . ltrim($path, '/'));
}

function upload_url(string $path): string
{
    return base_url('uploads/' . ltrim($path, '/'));
}

function redirect(string $path): never
{
    header('Location: ' . base_url($path));
    exit;
}

/** Retrieve and clear a flashed old-input/error value (for redisplaying form values/errors after redirect). */
function old(string $key, string $default = ''): string
{
    $value = $_SESSION['_old'][$key] ?? $default;
    return $value;
}

function flash_old(array $data, array $errors = []): void
{
    $_SESSION['_old'] = $data;
    $_SESSION['_errors'] = $errors;
}

function errors(string $key): ?string
{
    return $_SESSION['_errors'][$key] ?? null;
}

function clear_old(): void
{
    unset($_SESSION['_old'], $_SESSION['_errors']);
}

function flash_success(?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash_success'] = $message;
        return null;
    }
    $value = $_SESSION['_flash_success'] ?? null;
    unset($_SESSION['_flash_success']);
    return $value;
}

function flash_error(?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash_error'] = $message;
        return null;
    }
    $value = $_SESSION['_flash_error'] ?? null;
    unset($_SESSION['_flash_error']);
    return $value;
}
