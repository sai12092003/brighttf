<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\VolunteerPartnerSubmission;
use App\Models\ActivityLog;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/submissions-volunteer.php');
    $id = (int) ($_POST['id'] ?? 0);

    if (($_POST['_method'] ?? '') === 'delete') {
        VolunteerPartnerSubmission::delete($id);
        ActivityLog::record(Auth::id(), 'delete', 'volunteer_partner_submission', $id, 'Deleted a volunteer/partner submission');
        flash_success('Submission deleted.');
    } else {
        $status = $_POST['status'] ?? 'contacted';
        $notes = Sanitizer::str($_POST['admin_notes'] ?? '');
        VolunteerPartnerSubmission::updateStatus($id, $status, $notes !== '' ? $notes : null);
        ActivityLog::record(Auth::id(), 'update', 'volunteer_partner_submission', $id, "Updated submission status to {$status}");
        flash_success('Submission updated.');
    }
    redirect('/admin/submissions-volunteer.php');
}

$type = $_GET['type'] ?? null;

View::renderAdmin('submissions-volunteer', [
    'pageTitle' => 'Volunteer / Partner Submissions',
    'submissions' => VolunteerPartnerSubmission::all($type),
    'activeType' => $type,
]);
