<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\BlogCategory;
use App\Models\ActivityLog;

$action = $_GET['action'] ?? 'list';
$id = AdminHelpers::intParam('id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/blog-categories.php');

    if (($_POST['_method'] ?? '') === 'delete') {
        $delId = (int) $_POST['id'];
        BlogCategory::delete($delId);
        ActivityLog::record(Auth::id(), 'delete', 'blog_category', $delId, 'Deleted a blog category');
        flash_success('Category deleted.');
        redirect('/admin/blog-categories.php');
    }

    $name = Sanitizer::str($_POST['name'] ?? '');
    if ($name === '') {
        flash_error('Name is required.');
        redirect('/admin/blog-categories.php?action=' . ($id ? "edit&id={$id}" : 'create'));
    }
    $data = ['name' => $name, 'slug' => Sanitizer::slug((($_POST['slug'] ?? '') !== '') ? $_POST['slug'] : $name)];

    if ($id) {
        BlogCategory::update($id, $data);
        ActivityLog::record(Auth::id(), 'update', 'blog_category', $id, 'Updated blog category: ' . $name);
        flash_success('Category updated.');
    } else {
        $newId = BlogCategory::create($data);
        ActivityLog::record(Auth::id(), 'create', 'blog_category', $newId, 'Created blog category: ' . $name);
        flash_success('Category created.');
    }
    redirect('/admin/blog-categories.php');
}

if ($action === 'create' || $action === 'edit') {
    $category = $action === 'edit' && $id ? BlogCategory::find($id) : null;
    if ($action === 'edit' && !$category) {
        flash_error('Category not found.');
        redirect('/admin/blog-categories.php');
    }
    View::renderAdmin('blog-categories-form', ['pageTitle' => 'Blog Categories', 'category' => $category]);
    return;
}

View::renderAdmin('blog-categories-list', ['pageTitle' => 'Blog Categories', 'categories' => BlogCategory::all()]);
