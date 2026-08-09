<?php

declare(strict_types=1);

// app/ is either inside public_html (fallback layout, i.e. dirname(__DIR__)/app) or
// beside public_html (preferred layout, i.e. dirname(__DIR__, 2)/app).
$bootstrap = dirname(__DIR__) . '/app/bootstrap.php';
if (!is_file($bootstrap)) {
    $bootstrap = dirname(__DIR__, 2) . '/app/bootstrap.php';
}
require $bootstrap;

use App\Core\Auth;

Auth::requireLogin();
