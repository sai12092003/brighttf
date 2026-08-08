<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\TeamMember;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/team.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        TeamMember::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'team_member', $delId, 'Deleted a team member');
        flash_success('Team member deleted.');
        redirect('/admin/team.php');
    }

    $data = [
        'name' => Sanitizer::str($_POST['name'] ?? ''),
        'role_title' => Sanitizer::str($_POST['role_title'] ?? ''),
        'bio' => Sanitizer::str($_POST['bio'] ?? ''),
        'quote' => Sanitizer::str($_POST['quote'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($data['name'] === '') {
        flash_error('Name is required.');
        redirect('/admin/team.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    $uploadError = null;
    $photoPath = Uploader::storeImage($_FILES['photo'] ?? [], 'team', $uploadError);
    if ($uploadError) {
        flash_error($uploadError);
        redirect('/admin/team.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }
    if ($photoPath) {
        $data['photo_path'] = $photoPath;
    }

    if ($id) {
        TeamMember::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'team_member', $id, 'Updated team member: ' . $data['name']);
        flash_success('Team member updated.');
    } else {
        $newId = TeamMember::create($data);
        ActivityLog::record(Auth::id(), 'create', 'team_member', $newId, 'Created team member: ' . $data['name']);
        flash_success('Team member created.');
    }
    redirect('/admin/team.php');
}

if ($action === 'create' || $action === 'edit') {
    $member = $action === 'edit' && $id ? TeamMember::find($id) : null;
    if ($action === 'edit' && !$member) {
        flash_error('Team member not found.');
        redirect('/admin/team.php');
    }
    View::renderAdmin('team-form', ['pageTitle' => 'Team Members', 'member' => $member]);
    return;
}

View::renderAdmin('team-list', ['pageTitle' => 'Team Members', 'members' => TeamMember::all()]);
