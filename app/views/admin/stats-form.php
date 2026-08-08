<?php
/** @var array|null $stat */
use App\Core\Csrf;
$isEdit = $stat !== null;
?>
<a href="<?= base_url('/admin/stats.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Stat Counters</a>

<div class="card p-8 mt-4 max-w-xl">
    <form method="POST" action="<?= base_url('/admin/stats.php' . ($isEdit ? '?id=' . $stat['id'] : '')) ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Label</label>
            <input type="text" name="label" required class="form-input" value="<?= e($stat['label'] ?? '') ?>">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Number</label>
                <input type="number" name="number_value" required class="form-input" value="<?= e((string) ($stat['number_value'] ?? 0)) ?>">
            </div>
            <div>
                <label class="form-label">Suffix (e.g. +, %)</label>
                <input type="text" name="suffix" class="form-input" value="<?= e($stat['suffix'] ?? '') ?>">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($stat['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($stat['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Add Stat Counter' ?></button>
    </form>
</div>
