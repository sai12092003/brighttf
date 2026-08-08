<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\FocusArea;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/focus-areas.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        FocusArea::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'focus_area', $delId, 'Deleted a focus area');
        flash_success('Focus area deleted.');
        redirect('/admin/focus-areas.php');
    }

    $data = [
        'title' => Sanitizer::str($_POST['title'] ?? ''),
        'slug' => Sanitizer::slug((($_POST['slug'] ?? '') !== '') ? $_POST['slug'] : ($_POST['title'] ?? '')),
        'goal_text' => Sanitizer::str($_POST['goal_text'] ?? ''),
        'action_text' => Sanitizer::str($_POST['action_text'] ?? ''),
        'long_description' => Sanitizer::str($_POST['long_description'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($data['title'] === '') {
        flash_error('Title is required.');
        redirect('/admin/focus-areas.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    if ($id) {
        FocusArea::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'focus_area', $id, 'Updated focus area: ' . $data['title']);
        flash_success('Focus area updated.');
    } else {
        $newId = FocusArea::create($data);
        ActivityLog::record(Auth::id(), 'create', 'focus_area', $newId, 'Created focus area: ' . $data['title']);
        flash_success('Focus area created.');
    }
    redirect('/admin/focus-areas.php');
}

if ($action === 'create' || $action === 'edit') {
    $area = $action === 'edit' && $id ? FocusArea::find($id) : null;
    if ($action === 'edit' && !$area) {
        flash_error('Focus area not found.');
        redirect('/admin/focus-areas.php');
    }
    View::renderAdmin('focus-areas-form', ['pageTitle' => 'Focus Areas', 'area' => $area]);
    return;
}

View::renderAdmin('focus-areas-list', ['pageTitle' => 'Focus Areas', 'areas' => FocusArea::all()]);
