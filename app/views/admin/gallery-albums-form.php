<?php
/** @var array|null $album */
use App\Core\Csrf;
$isEdit = $album !== null;
?>
<a href="<?= base_url('/admin/gallery-albums.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Albums</a>

<div class="card p-8 mt-4 max-w-xl">
    <form method="POST" action="<?= base_url('/admin/gallery-albums.php' . ($isEdit ? '?id=' . $album['id'] : '')) ?>" class="space-y-5" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <?php if ($isEdit && !empty($album['cover_image'])): ?>
            <img src="<?= upload_url($album['cover_image']) ?>" class="h-24 rounded-lg object-cover">
        <?php endif; ?>
        <div>
            <label class="form-label">Cover Image</label>
            <input type="file" name="cover_image" accept="image/*" class="form-input">
        </div>
        <div>
            <label class="form-label">Title</label>
            <input type="text" name="title" required class="form-input" value="<?= e($album['title'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Slug (leave blank to auto-generate)</label>
            <input type="text" name="slug" class="form-input" value="<?= e($album['slug'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-input"><?= e($album['description'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($album['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($album['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Album' ?></button>
    </form>
</div>
