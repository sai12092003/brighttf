<?php
/** @var array|null $testimonial */
use App\Core\Csrf;
$isEdit = $testimonial !== null;
?>
<a href="<?= base_url('/admin/testimonials.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Testimonials</a>

<div class="card p-8 mt-4 max-w-2xl">
    <form method="POST" action="<?= base_url('/admin/testimonials.php' . ($isEdit ? '?id=' . $testimonial['id'] : '')) ?>" class="space-y-5" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <?php if ($isEdit && !empty($testimonial['photo_path'])): ?>
            <img src="<?= upload_url($testimonial['photo_path']) ?>" class="h-16 w-16 rounded-full object-cover">
        <?php endif; ?>
        <div>
            <label class="form-label">Photo (optional)</label>
            <input type="file" name="photo" accept="image/*" class="form-input">
        </div>
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-input" value="<?= e($testimonial['name'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Role / Location</label>
            <input type="text" name="role_or_location" class="form-input" value="<?= e($testimonial['role_or_location'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Quote</label>
            <textarea name="quote" rows="4" required class="form-input"><?= e($testimonial['quote'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($testimonial['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" <?= (int) ($testimonial['is_featured'] ?? 0) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Featured on Home</span>
                </label>
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($testimonial['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Add Testimonial' ?></button>
    </form>
</div>
