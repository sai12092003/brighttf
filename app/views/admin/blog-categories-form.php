<?php
/** @var array|null $category */
use App\Core\Csrf;
$isEdit = $category !== null;
?>
<a href="<?= base_url('/admin/blog-categories.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Categories</a>

<div class="card p-8 mt-4 max-w-lg">
    <form method="POST" action="<?= base_url('/admin/blog-categories.php' . ($isEdit ? '?id=' . $category['id'] : '')) ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-input" value="<?= e($category['name'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Slug (leave blank to auto-generate)</label>
            <input type="text" name="slug" class="form-input" value="<?= e($category['slug'] ?? '') ?>">
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Category' ?></button>
    </form>
</div>
