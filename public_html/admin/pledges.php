<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\DonationPledge;
use App\Models\ActivityLog;

if (($_GET['export'] ?? '') === 'csv') {
    $pledges = DonationPledge::all();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="donation-pledges.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Donor Name', 'Email', 'Phone', 'Amount', 'Mode', 'Reference', 'Status', 'Date']);
    foreach ($pledges as $p) {
        fputcsv($out, [$p['id'], $p['donor_name'], $p['email'], $p['phone'], $p['amount'], $p['mode'], $p['reference_utr'], $p['status'], $p['created_at']]);
    }
    fclose($out);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/pledges.php');
    $id = (int) ($_POST['id'] ?? 0);

    if (($_POST['_method'] ?? '') === 'delete') {
        DonationPledge::delete($id);
        ActivityLog::record(Auth::id(), 'delete', 'donation_pledge', $id, 'Deleted a donation pledge');
        flash_success('Pledge deleted.');
    } else {
        $status = $_POST['status'] ?? 'contacted';
        $notes = Sanitizer::str($_POST['admin_notes'] ?? '');
        DonationPledge::updateStatus($id, $status, $notes !== '' ? $notes : null);
        ActivityLog::record(Auth::id(), 'update', 'donation_pledge', $id, "Updated pledge status to {$status}");
        flash_success('Pledge updated.');
    }
    redirect('/admin/pledges.php');
}

View::renderAdmin('pledges', [
    'pageTitle' => 'Donation Pledges',
    'pledges' => DonationPledge::all(),
]);
