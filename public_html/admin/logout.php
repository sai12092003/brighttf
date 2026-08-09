<?php

declare(strict_types=1);

$bootstrap = dirname(__DIR__) . '/app/bootstrap.php';
if (!is_file($bootstrap)) {
    $bootstrap = dirname(__DIR__, 2) . '/app/bootstrap.php';
}
require $bootstrap;

use App\Core\Auth;

Auth::logout();
redirect('/admin/login.php');
