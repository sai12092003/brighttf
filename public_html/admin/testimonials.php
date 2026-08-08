<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\Testimonial;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/testimonials.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        Testimonial::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'testimonial', $delId, 'Deleted a testimonial');
        flash_success('Testimonial deleted.');
        redirect('/admin/testimonials.php');
    }

    $data = [
        'name' => Sanitizer::str($_POST['name'] ?? ''),
        'role_or_location' => Sanitizer::str($_POST['role_or_location'] ?? ''),
        'quote' => Sanitizer::str($_POST['quote'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    if ($data['name'] === '' || $data['quote'] === '') {
        flash_error('Name and quote are required.');
        redirect('/admin/testimonials.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    $uploadError = null;
    $photoPath = Uploader::storeImage($_FILES['photo'] ?? [], 'team', $uploadError);
    if ($uploadError) {
        flash_error($uploadError);
        redirect('/admin/testimonials.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }
    if ($photoPath) {
        $data['photo_path'] = $photoPath;
    }

    if ($id) {
        Testimonial::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'testimonial', $id, 'Updated testimonial: ' . $data['name']);
        flash_success('Testimonial updated.');
    } else {
        $newId = Testimonial::create($data);
        ActivityLog::record(Auth::id(), 'create', 'testimonial', $newId, 'Created testimonial: ' . $data['name']);
        flash_success('Testimonial created.');
    }
    redirect('/admin/testimonials.php');
}

if ($action === 'create' || $action === 'edit') {
    $testimonial = $action === 'edit' && $id ? Testimonial::find($id) : null;
    if ($action === 'edit' && !$testimonial) {
        flash_error('Testimonial not found.');
        redirect('/admin/testimonials.php');
    }
    View::renderAdmin('testimonials-form', ['pageTitle' => 'Testimonials', 'testimonial' => $testimonial]);
    return;
}

View::renderAdmin('testimonials-list', ['pageTitle' => 'Testimonials', 'testimonials' => Testimonial::all()]);
