<?php
/** @var array|null $member */
use App\Core\Csrf;
$isEdit = $member !== null;
?>
<a href="<?= base_url('/admin/team.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Team Members</a>

<div class="card p-8 mt-4 max-w-2xl">
    <form method="POST" action="<?= base_url('/admin/team.php' . ($isEdit ? '?id=' . $member['id'] : '')) ?>" class="space-y-5" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <?php if ($isEdit && !empty($member['photo_path'])): ?>
            <img src="<?= upload_url($member['photo_path']) ?>" class="h-20 w-20 rounded-full object-cover">
        <?php endif; ?>
        <div>
            <label class="form-label">Photo</label>
            <input type="file" name="photo" accept="image/*" class="form-input">
        </div>
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-input" value="<?= e($member['name'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Role Title</label>
            <input type="text" name="role_title" class="form-input" placeholder="e.g. Founder" value="<?= e($member['role_title'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Bio</label>
            <textarea name="bio" rows="6" class="form-input"><?= e($member['bio'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="form-label">Quote (optional)</label>
            <textarea name="quote" rows="2" class="form-input"><?= e($member['quote'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($member['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($member['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active (shown on site)</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Add Team Member' ?></button>
    </form>
</div>
