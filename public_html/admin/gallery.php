<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\GalleryImage;
use App\Models\GalleryAlbum;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/gallery.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        GalleryImage::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'gallery_image', $delId, 'Deleted a gallery image');
        flash_success('Image deleted.');
        redirect('/admin/gallery.php');
    }

    if (($_POST['_form'] ?? '') === 'upload') {
        $albumId = Sanitizer::int($_POST['album_id'] ?? 0) ?: null;
        $files = $_FILES['images'] ?? null;
        $uploaded = 0;
        if ($files && is_array($files['name'])) {
            foreach ($files['name'] as $i => $name) {
                if ($name === '') continue;
                $single = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i],
                ];
                $error = null;
                $path = Uploader::storeImage($single, 'gallery', $error);
                if ($path) {
                    GalleryImage::create([
                        'album_id' => $albumId,
                        'image_path' => $path,
                        'alt_text' => Sanitizer::str($_POST['alt_text'] ?? ''),
                        'is_active' => 1,
                    ]);
                    $uploaded++;
                }
            }
        }
        ActivityLog::record(Auth::id(), 'create', 'gallery_image', null, "Uploaded {$uploaded} gallery image(s)");
        flash_success("{$uploaded} image(s) uploaded.");
        redirect('/admin/gallery.php');
    }

    // Edit metadata for a single image
    $data = [
        'album_id' => Sanitizer::int($_POST['album_id'] ?? 0) ?: null,
        'caption' => Sanitizer::str($_POST['caption'] ?? ''),
        'alt_text' => Sanitizer::str($_POST['alt_text'] ?? ''),
        'sort_order' => Sanitizer::int($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    GalleryImage::update($id, $data);
    ActivityLog::record(Auth::id(), 'update', 'gallery_image', $id, 'Updated a gallery image');
    flash_success('Image updated.');
    redirect('/admin/gallery.php');
}

if ($action === 'edit' && $id) {
    $image = GalleryImage::find($id);
    if (!$image) {
        flash_error('Image not found.');
        redirect('/admin/gallery.php');
    }
    View::renderAdmin('gallery-form', ['pageTitle' => 'Gallery Images', 'image' => $image, 'albums' => GalleryAlbum::all()]);
    return;
}

View::renderAdmin('gallery-list', ['pageTitle' => 'Gallery Images', 'images' => GalleryImage::all(), 'albums' => GalleryAlbum::all()]);
