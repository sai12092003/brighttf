<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\StatsCounter;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/stats.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        StatsCounter::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'stats_counter', $delId, 'Deleted a stat counter');
        flash_success('Stat counter deleted.');
        redirect('/admin/stats.php');
    }

    $data = [
        'label' => Sanitizer::str($_POST['label'] ?? ''),
        'number_value' => Sanitizer::int($_POST['number_value'] ?? 0),
        'suffix' => Sanitizer::str($_POST['suffix'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($data['label'] === '') {
        flash_error('Label is required.');
        redirect('/admin/stats.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    if ($id) {
        StatsCounter::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'stats_counter', $id, 'Updated stat counter: ' . $data['label']);
        flash_success('Stat counter updated.');
    } else {
        $newId = StatsCounter::create($data);
        ActivityLog::record(Auth::id(), 'create', 'stats_counter', $newId, 'Created stat counter: ' . $data['label']);
        flash_success('Stat counter created.');
    }
    redirect('/admin/stats.php');
}

if ($action === 'create' || $action === 'edit') {
    $stat = $action === 'edit' && $id ? StatsCounter::find($id) : null;
    if ($action === 'edit' && !$stat) {
        flash_error('Stat counter not found.');
        redirect('/admin/stats.php');
    }
    View::renderAdmin('stats-form', ['pageTitle' => 'Stat Counters', 'stat' => $stat]);
    return;
}

View::renderAdmin('stats-list', ['pageTitle' => 'Stat Counters', 'stats' => StatsCounter::all()]);
