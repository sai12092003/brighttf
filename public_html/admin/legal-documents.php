<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\LegalDocument;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');
$docTypes = ['12A', '80G', 'PAN', 'Trust Deed', 'Registration Certificate', 'Other'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/legal-documents.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        LegalDocument::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'legal_document', $delId, 'Deleted a legal document');
        flash_success('Document deleted.');
        redirect('/admin/legal-documents.php');
    }

    $title = Sanitizer::str($_POST['title'] ?? '');
    $docType = in_array($_POST['doc_type'] ?? '', $docTypes, true) ? $_POST['doc_type'] : 'Other';

    if ($title === '') {
        flash_error('Title is required.');
        redirect('/admin/legal-documents.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    $data = [
        'title' => $title,
        'doc_type' => $docType,
        'description' => Sanitizer::str($_POST['description'] ?? ''),
        'is_public' => isset($_POST['is_public']) ? 1 : 0,
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
    ];

    $uploadError = null;
    $filePath = Uploader::storeDocument($_FILES['file'] ?? [], 'legal', $uploadError);
    if ($uploadError) {
        flash_error($uploadError);
        redirect('/admin/legal-documents.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }
    if ($filePath) {
        $data['file_path'] = $filePath;
    } elseif (!$id) {
        flash_error('Please upload a PDF file.');
        redirect('/admin/legal-documents.php?action=create');
    }

    if ($id) {
        LegalDocument::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'legal_document', $id, 'Updated legal document: ' . $title);
        flash_success('Document updated.');
    } else {
        $data['uploaded_by'] = Auth::id();
        $newId = LegalDocument::create($data);
        ActivityLog::record(Auth::id(), 'create', 'legal_document', $newId, 'Uploaded legal document: ' . $title);
        flash_success('Document uploaded.');
    }
    redirect('/admin/legal-documents.php');
}

if ($action === 'create' || $action === 'edit') {
    $document = $action === 'edit' && $id ? LegalDocument::find($id) : null;
    if ($action === 'edit' && !$document) {
        flash_error('Document not found.');
        redirect('/admin/legal-documents.php');
    }
    View::renderAdmin('legal-documents-form', ['pageTitle' => 'Legal Documents', 'document' => $document, 'docTypes' => $docTypes]);
    return;
}

View::renderAdmin('legal-documents-list', ['pageTitle' => 'Legal Documents', 'documents' => LegalDocument::all()]);
