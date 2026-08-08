<?php

declare(strict_types=1);

use App\Core\Env;

Env::load(dirname(__DIR__, 2) . '/.env');

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
        'root' => dirname(__DIR__, 2),
        'app' => dirname(__DIR__),
        'public' => dirname(__DIR__, 2) . '/public_html',
        'storage' => dirname(__DIR__, 2) . '/storage',
        'uploads' => dirname(__DIR__, 2) . '/public_html/uploads',
    ],
];
