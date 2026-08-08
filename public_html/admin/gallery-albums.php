<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\GalleryAlbum;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/gallery-albums.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        GalleryAlbum::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'gallery_album', $delId, 'Deleted a gallery album');
        flash_success('Album deleted.');
        redirect('/admin/gallery-albums.php');
    }

    $title = Sanitizer::str($_POST['title'] ?? '');
    if ($title === '') {
        flash_error('Title is required.');
        redirect('/admin/gallery-albums.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    $data = [
        'title' => $title,
        'slug' => Sanitizer::slug((($_POST['slug'] ?? '') !== '') ? $_POST['slug'] : $title),
        'description' => Sanitizer::str($_POST['description'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    $uploadError = null;
    $coverPath = Uploader::storeImage($_FILES['cover_image'] ?? [], 'gallery', $uploadError);
    if ($uploadError) {
        flash_error($uploadError);
        redirect('/admin/gallery-albums.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }
    if ($coverPath) {
        $data['cover_image'] = $coverPath;
    }

    if ($id) {
        GalleryAlbum::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'gallery_album', $id, 'Updated gallery album: ' . $title);
        flash_success('Album updated.');
    } else {
        $newId = GalleryAlbum::create($data);
        ActivityLog::record(Auth::id(), 'create', 'gallery_album', $newId, 'Created gallery album: ' . $title);
        flash_success('Album created.');
    }
    redirect('/admin/gallery-albums.php');
}

if ($action === 'create' || $action === 'edit') {
    $album = $action === 'edit' && $id ? GalleryAlbum::find($id) : null;
    if ($action === 'edit' && !$album) {
        flash_error('Album not found.');
        redirect('/admin/gallery-albums.php');
    }
    View::renderAdmin('gallery-albums-form', ['pageTitle' => 'Gallery Albums', 'album' => $album]);
    return;
}

View::renderAdmin('gallery-albums-list', ['pageTitle' => 'Gallery Albums', 'albums' => GalleryAlbum::all()]);
