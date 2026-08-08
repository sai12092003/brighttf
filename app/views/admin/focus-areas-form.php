<?php
/** @var array|null $area */
use App\Core\Csrf;
$isEdit = $area !== null;
?>
<a href="<?= base_url('/admin/focus-areas.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Focus Areas</a>

<div class="card p-8 mt-4 max-w-2xl">
    <form method="POST" action="<?= base_url('/admin/focus-areas.php' . ($isEdit ? '?id=' . $area['id'] : '')) ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Title</label>
            <input type="text" name="title" required class="form-input" value="<?= e($area['title'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Slug (leave blank to auto-generate from title)</label>
            <input type="text" name="slug" class="form-input" value="<?= e($area['slug'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Goal (short tagline)</label>
            <input type="text" name="goal_text" class="form-input" value="<?= e($area['goal_text'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Action (what we do)</label>
            <textarea name="action_text" rows="2" class="form-input"><?= e($area['action_text'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="form-label">Long Description (shown on the detail page)</label>
            <textarea name="long_description" rows="4" class="form-input"><?= e($area['long_description'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($area['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($area['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active (shown on site)</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Focus Area' ?></button>
    </form>
</div>
