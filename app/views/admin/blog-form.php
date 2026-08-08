<?php
/** @var array|null $post */
/** @var array $categories */
use App\Core\Csrf;
$isEdit = $post !== null;
?>
<a href="<?= base_url('/admin/blog.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Blog Posts</a>

<div class="card p-8 mt-4 max-w-3xl">
    <form method="POST" action="<?= base_url('/admin/blog.php' . ($isEdit ? '?id=' . $post['id'] : '')) ?>" class="space-y-5" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Title</label>
            <input type="text" name="title" required class="form-input" value="<?= e($post['title'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Slug (leave blank to auto-generate)</label>
            <input type="text" name="slug" class="form-input" value="<?= e($post['slug'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Category</label>
            <select name="category_id" class="form-input">
                <option value="">— None —</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['id'] ?>" <?= (int) ($post['category_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if ($isEdit && !empty($post['featured_image'])): ?>
            <img src="<?= upload_url($post['featured_image']) ?>" class="h-32 rounded-lg object-cover">
        <?php endif; ?>
        <div>
            <label class="form-label">Featured Image</label>
            <input type="file" name="featured_image" accept="image/*" class="form-input">
        </div>
        <div>
            <label class="form-label">Excerpt</label>
            <textarea name="excerpt" rows="2" class="form-input"><?= e($post['excerpt'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="form-label">Body (basic HTML tags allowed: p, h2, h3, ul, li, strong, em, a, img, blockquote)</label>
            <textarea name="body" rows="12" required class="form-input font-mono text-sm"><?= e($post['body'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="form-label">Status</label>
            <select name="status" class="form-input">
                <option value="draft" <?= ($post['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
            </select>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Meta Title (SEO)</label>
                <input type="text" name="meta_title" class="form-input" value="<?= e($post['meta_title'] ?? '') ?>">
            </div>
            <div>
                <label class="form-label">Meta Description (SEO)</label>
                <input type="text" name="meta_description" class="form-input" value="<?= e($post['meta_description'] ?? '') ?>">
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Post' ?></button>
    </form>
</div>
