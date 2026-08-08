<?php
/** @var array|null $faq */
use App\Core\Csrf;
$isEdit = $faq !== null;
?>
<a href="<?= base_url('/admin/faqs.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to FAQs</a>

<div class="card p-8 mt-4 max-w-2xl">
    <form method="POST" action="<?= base_url('/admin/faqs.php' . ($isEdit ? '?id=' . $faq['id'] : '')) ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Question</label>
            <input type="text" name="question" required class="form-input" value="<?= e($faq['question'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Answer</label>
            <textarea name="answer" rows="5" required class="form-input"><?= e($faq['answer'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($faq['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($faq['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Active</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Add FAQ' ?></button>
    </form>
</div>
