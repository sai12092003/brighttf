<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\ScholarshipApplication;
use App\Models\ActivityLog;

if (($_GET['export'] ?? '') === 'csv') {
    $applications = ScholarshipApplication::all();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="scholarship-applications.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Scholarship', 'Full Name', 'Email', 'Phone', 'DOB', 'Gender', 'Differently Abled', 'City', 'Guardian', 'Qualification', 'Annual Income', 'Message', 'Status', 'Date']);
    foreach ($applications as $a) {
        fputcsv($out, [
            $a['id'], $a['scholarship_name'], $a['full_name'], $a['email'], $a['phone'],
            $a['date_of_birth'], $a['gender'], $a['differently_abled'], $a['city'], $a['guardian_name'],
            $a['qualification'], $a['annual_income'], $a['message'], $a['status'], $a['created_at'],
        ]);
    }
    fclose($out);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/scholarship-applications.php');
    $id = (int) ($_POST['id'] ?? 0);

    if (($_POST['_method'] ?? '') === 'delete') {
        ScholarshipApplication::delete($id);
        ActivityLog::record(Auth::id(), 'delete', 'scholarship_application', $id, 'Deleted a scholarship application');
        flash_success('Application deleted.');
    } else {
        $status = $_POST['status'] ?? 'reviewed';
        $notes = Sanitizer::str($_POST['admin_notes'] ?? '');
        ScholarshipApplication::updateStatus($id, $status, $notes !== '' ? $notes : null);
        ActivityLog::record(Auth::id(), 'update', 'scholarship_application', $id, "Updated application status to {$status}");
        flash_success('Application updated.');
    }
    redirect('/admin/scholarship-applications.php');
}

View::renderAdmin('scholarship-applications', [
    'pageTitle' => 'Scholarship Requests',
    'applications' => ScholarshipApplication::all(),
]);
