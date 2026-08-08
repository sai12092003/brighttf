<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\View;
use App\Models\ActivityLog;

View::renderAdmin('activity-log', [
    'pageTitle' => 'Activity Log',
    'logs' => ActivityLog::recent(150),
]);
