<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\Faq;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/faqs.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        Faq::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'faq', $delId, 'Deleted a FAQ');
        flash_success('FAQ deleted.');
        redirect('/admin/faqs.php');
    }

    $data = [
        'question' => Sanitizer::str($_POST['question'] ?? ''),
        'answer' => Sanitizer::str($_POST['answer'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($data['question'] === '' || $data['answer'] === '') {
        flash_error('Question and answer are required.');
        redirect('/admin/faqs.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    if ($id) {
        Faq::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'faq', $id, 'Updated a FAQ');
        flash_success('FAQ updated.');
    } else {
        $newId = Faq::create($data);
        ActivityLog::record(Auth::id(), 'create', 'faq', $newId, 'Created a FAQ');
        flash_success('FAQ created.');
    }
    redirect('/admin/faqs.php');
}

if ($action === 'create' || $action === 'edit') {
    $faq = $action === 'edit' && $id ? Faq::find($id) : null;
    if ($action === 'edit' && !$faq) {
        flash_error('FAQ not found.');
        redirect('/admin/faqs.php');
    }
    View::renderAdmin('faqs-form', ['pageTitle' => 'FAQs', 'faq' => $faq]);
    return;
}

View::renderAdmin('faqs-list', ['pageTitle' => 'FAQs', 'faqs' => Faq::all()]);
