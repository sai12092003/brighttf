<?php
/** @var array $images */
/** @var array $albums */
use App\Core\Csrf;
?>
<div class="card p-6 mb-6">
    <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-4">Upload Images</h2>
    <form method="POST" action="<?= base_url('/admin/gallery.php') ?>" enctype="multipart/form-data" class="grid sm:grid-cols-3 gap-4 items-end">
        <?= Csrf::field() ?>
        <input type="hidden" name="_form" value="upload">
        <div class="sm:col-span-2">
            <label class="form-label">Select Images (multiple allowed)</label>
            <input type="file" name="images[]" accept="image/*" multiple required class="form-input">
        </div>
        <div>
            <label class="form-label">Album (optional)</label>
            <select name="album_id" class="form-input">
                <option value="">— Uncategorized —</option>
                <?php foreach ($albums as $a): ?>
                    <option value="<?= (int) $a['id'] ?>"><?= e($a['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="sm:col-span-3">
            <button type="submit" class="btn-primary">Upload</button>
        </div>
    </form>
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
    <?php foreach ($images as $img): ?>
        <div class="card p-2">
            <img src="<?= upload_url($img['image_path']) ?>" class="w-full aspect-square object-cover rounded-lg">
            <p class="text-xs text-brand-neutral-500 mt-2 truncate"><?= e($img['album_title'] ?? 'Uncategorized') ?></p>
            <div class="flex justify-between items-center mt-1">
                <a href="<?= base_url('/admin/gallery.php?action=edit&id=' . $img['id']) ?>" class="text-xs text-brand-blue-700 hover:underline">Edit</a>
                <form method="POST" onsubmit="return confirm('Delete this image?');">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="_method" value="delete">
                    <input type="hidden" name="id" value="<?= (int) $img['id'] ?>">
                    <button type="submit" class="text-xs text-red-600 hover:underline">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($images)): ?>
        <p class="col-span-full text-center text-brand-neutral-500 py-8">No images uploaded yet.</p>
    <?php endif; ?>
</div>
