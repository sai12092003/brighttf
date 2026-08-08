<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\Admin;
use App\Models\ActivityLog;

$me = Auth::user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/profile.php');

    $name = Sanitizer::str($_POST['name'] ?? '');
    $email = Sanitizer::email($_POST['email'] ?? '');
    $currentPassword = (string) ($_POST['current_password'] ?? '');
    $newPassword = (string) ($_POST['new_password'] ?? '');

    if ($name === '' || !Sanitizer::isValidEmail($email)) {
        flash_error('Name and a valid email are required.');
        redirect('/admin/profile.php');
    }

    $data = ['name' => $name, 'email' => $email];

    if ($newPassword !== '') {
        if (!password_verify($currentPassword, $me['password_hash'])) {
            flash_error('Current password is incorrect.');
            redirect('/admin/profile.php');
        }
        if (strlen($newPassword) < 8) {
            flash_error('New password must be at least 8 characters.');
            redirect('/admin/profile.php');
        }
        $data['password_hash'] = password_hash($newPassword, PASSWORD_ARGON2ID);
    }

    Admin::update((int) $me['id'], $data);
    ActivityLog::record(Auth::id(), 'update', 'admin', (int) $me['id'], 'Updated own profile');
    flash_success('Profile updated.');
    redirect('/admin/profile.php');
}

View::renderAdmin('profile', ['pageTitle' => 'My Profile', 'me' => Admin::findById((int) $me['id'])]);
