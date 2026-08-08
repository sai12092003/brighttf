<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\View;
use App\Models\ContactSubmission;
use App\Models\ActivityLog;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/submissions-contact.php');
    $id = (int) ($_POST['id'] ?? 0);

    if (($_POST['_method'] ?? '') === 'delete') {
        ContactSubmission::delete($id);
        ActivityLog::record(Auth::id(), 'delete', 'contact_submission', $id, 'Deleted a contact message');
        flash_success('Message deleted.');
    } else {
        $status = $_POST['status'] ?? 'read';
        ContactSubmission::updateStatus($id, $status);
        ActivityLog::record(Auth::id(), 'update', 'contact_submission', $id, "Marked contact message as {$status}");
        flash_success('Status updated.');
    }
    redirect('/admin/submissions-contact.php');
}

View::renderAdmin('submissions-contact', [
    'pageTitle' => 'Contact Messages',
    'submissions' => ContactSubmission::all(),
]);
