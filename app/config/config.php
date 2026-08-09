<?php

declare(strict_types=1);

use App\Core\Env;

// app/, database/, and storage/ always sit beside each other. Their shared parent is either
// the project root (preferred layout: app/ is a sibling of public_html/) or public_html/
// itself (fallback layout: app/ was uploaded inside public_html/ because the host doesn't
// allow files above the webroot). Detecting this here means the same codebase deploys
// correctly under either layout with no manual switch.
$sharedParent = dirname(__DIR__, 2);
$isFallbackLayout = basename($sharedParent) === 'public_html';
$publicPath = $isFallbackLayout ? $sharedParent : $sharedParent . '/public_html';
// .env lives beside app/database/storage in both layouts — inside public_html in the
// fallback case (never above it, since some hosts explicitly disallow uploading there).
$rootPath = $sharedParent;

Env::load($rootPath . '/.env');

return [
    'app' => [
        'env' => Env::get('APP_ENV', 'production'),
        'url' => rtrim(Env::get('APP_URL', ''), '/'),
        'key' => Env::get('APP_KEY', ''),
        'debug' => Env::get('APP_ENV', 'production') !== 'production',
    ],
    'db' => [
        'driver' => Env::get('DB_DRIVER', 'mysql'),
        'host' => Env::get('DB_HOST', '127.0.0.1'),
        'port' => Env::get('DB_PORT', '3306'),
        'name' => Env::get('DB_NAME', ''),
        'user' => Env::get('DB_USER', ''),
        'pass' => Env::get('DB_PASS', ''),
    ],
    'mail' => [
        'from_address' => Env::get('MAIL_FROM_ADDRESS', 'brighttfhead@gmail.com'),
        'from_name' => Env::get('MAIL_FROM_NAME', 'Bright Today Foundation'),
        'smtp_host' => Env::get('SMTP_HOST', ''),
        'smtp_port' => (int) Env::get('SMTP_PORT', '587'),
        'smtp_user' => Env::get('SMTP_USER', ''),
        'smtp_pass' => Env::get('SMTP_PASS', ''),
    ],
    'paths' => [
        'root' => $rootPath,
        'app' => dirname(__DIR__),
        'public' => $publicPath,
        'storage' => $sharedParent . '/storage',
        'uploads' => $publicPath . '/uploads',
    ],
];
