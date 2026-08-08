<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\Admin;
use App\Models\ActivityLog;

Auth::requireSuperAdmin();

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/users.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        if ($delId === Auth::id()) {
            flash_error('You cannot delete your own account.');
            redirect('/admin/users.php');
        }
        Admin::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'admin', $delId, 'Deleted an admin user');
        flash_success('Admin user deleted.');
        redirect('/admin/users.php');
    }

    $name = Sanitizer::str($_POST['name'] ?? '');
    $email = Sanitizer::email($_POST['email'] ?? '');
    $username = Sanitizer::str($_POST['username'] ?? '');
    $role = in_array($_POST['role'] ?? '', ['super_admin', 'editor'], true) ? $_POST['role'] : 'editor';
    $password = (string) ($_POST['password'] ?? '');

    if ($name === '' || $username === '' || !Sanitizer::isValidEmail($email)) {
        flash_error('Name, username, and a valid email are required.');
        redirect('/admin/users.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    if (!$id && strlen($password) < 8) {
        flash_error('Password must be at least 8 characters.');
        redirect('/admin/users.php?action=create');
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'username' => $username,
        'role' => $role,
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($password !== '') {
        if (strlen($password) < 8) {
            flash_error('Password must be at least 8 characters.');
            redirect('/admin/users.php?action=edit&id=' . $id);
        }
        $data['password_hash'] = password_hash($password, PASSWORD_ARGON2ID);
    }

    if ($id) {
        Admin::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'admin', $id, 'Updated admin user: ' . $username);
        flash_success('Admin user updated.');
    } else {
        $newId = Admin::create($data);
        ActivityLog::record(Auth::id(), 'create', 'admin', $newId, 'Created admin user: ' . $username);
        flash_success('Admin user created.');
    }
    redirect('/admin/users.php');
}

if ($action === 'create' || $action === 'edit') {
    $user = $action === 'edit' && $id ? Admin::findById($id) : null;
    if ($action === 'edit' && !$user) {
        flash_error('Admin user not found.');
        redirect('/admin/users.php');
    }
    View::renderAdmin('users-form', ['pageTitle' => 'Admin Users', 'targetUser' => $user]);
    return;
}

View::renderAdmin('users-list', ['pageTitle' => 'Admin Users', 'users' => Admin::all()]);
