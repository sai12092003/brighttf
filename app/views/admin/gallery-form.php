<?php
/** @var array $image */
/** @var array $albums */
use App\Core\Csrf;
?>
<a href="<?= base_url('/admin/gallery.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Gallery</a>

<div class="card p-8 mt-4 max-w-xl">
    <img src="<?= upload_url($image['image_path']) ?>" class="w-full max-h-64 object-cover rounded-lg mb-6">
    <form method="POST" action="<?= base_url('/admin/gallery.php?id=' . $image['id']) ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Album</label>
            <select name="album_id" class="form-input">
                <option value="">— Uncategorized —</option>
                <?php foreach ($albums as $a): ?>
                    <option value="<?= (int) $a['id'] ?>" <?= (int) ($image['album_id'] ?? 0) === (int) $a['id'] ? 'selected' : '' ?>><?= e($a['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="form-label">Caption</label>
            <input type="text" name="caption" class="form-input" value="<?= e($image['caption'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Alt Text (accessibility)</label>
            <input type="text" name="alt_text" class="form-input" value="<?= e($image['alt_text'] ?? '') ?>">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($image['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= (int) ($image['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary">Save Changes</button>
    </form>
</div>
