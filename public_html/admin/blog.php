<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/blog.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        BlogPost::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'blog_post', $delId, 'Deleted a blog post');
        flash_success('Post deleted.');
        redirect('/admin/blog.php');
    }

    $title = Sanitizer::str($_POST['title'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['draft', 'published'], true) ? $_POST['status'] : 'draft';
    $categoryId = Sanitizer::int($_POST['category_id'] ?? 0) ?: null;

    $data = [
        'title' => $title,
        'slug' => Sanitizer::slug((($_POST['slug'] ?? '') !== '') ? $_POST['slug'] : $title),
        'category_id' => $categoryId,
        'excerpt' => Sanitizer::str($_POST['excerpt'] ?? ''),
        'body' => Sanitizer::richText($_POST['body'] ?? ''),
        'status' => $status,
        'published_at' => $status === 'published' ? ($_POST['published_at'] ?: date('Y-m-d H:i:s')) : null,
        'meta_title' => Sanitizer::str($_POST['meta_title'] ?? ''),
        'meta_description' => Sanitizer::str($_POST['meta_description'] ?? ''),
        'author_admin_id' => Auth::id(),
    ];

    if ($title === '' || $data['body'] === '') {
        flash_error('Title and body are required.');
        redirect('/admin/blog.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }

    $uploadError = null;
    $imagePath = Uploader::storeImage($_FILES['featured_image'] ?? [], 'blog', $uploadError);
    if ($uploadError) {
        flash_error($uploadError);
        redirect('/admin/blog.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }
    if ($imagePath) {
        $data['featured_image'] = $imagePath;
    }

    if ($id) {
        BlogPost::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'blog_post', $id, 'Updated blog post: ' . $title);
        flash_success('Post updated.');
    } else {
        $newId = BlogPost::create($data);
        ActivityLog::record(Auth::id(), 'create', 'blog_post', $newId, 'Created blog post: ' . $title);
        flash_success('Post created.');
    }
    redirect('/admin/blog.php');
}

if ($action === 'create' || $action === 'edit') {
    $post = $action === 'edit' && $id ? BlogPost::find($id) : null;
    if ($action === 'edit' && !$post) {
        flash_error('Post not found.');
        redirect('/admin/blog.php');
    }
    View::renderAdmin('blog-form', ['pageTitle' => 'Blog Posts', 'post' => $post, 'categories' => BlogCategory::all()]);
    return;
}

View::renderAdmin('blog-list', ['pageTitle' => 'Blog Posts', 'posts' => BlogPost::all()]);
