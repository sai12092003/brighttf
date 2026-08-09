<?php

declare(strict_types=1);

// app/ is either inside public_html (fallback layout) or beside it (preferred layout).
$bootstrap = __DIR__ . '/app/bootstrap.php';
if (!is_file($bootstrap)) {
    $bootstrap = dirname(__DIR__) . '/app/bootstrap.php';
}
require $bootstrap;

use App\Core\Router;

$router = new Router();
require __DIR__ . '/routes.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'] ?? '/');
