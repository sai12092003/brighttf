<?php
/** @var array $pages */
/** @var string $activePage */
/** @var array|null $current */
use App\Core\Csrf;
?>
<div class="flex flex-wrap gap-2 mb-6">
    <?php foreach ($pages as $key => $label): ?>
        <a href="<?= base_url('/admin/seo.php?page=' . urlencode($key)) ?>"
           class="rounded-full px-4 py-2 text-sm font-medium <?= $key === $activePage ? 'bg-brand-blue-900 text-white' : 'bg-white border border-brand-neutral-200 text-brand-blue-900 hover:border-brand-blue-400' ?>">
            <?= e($label) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="card p-8 max-w-2xl">
    <form method="POST" action="<?= base_url('/admin/seo.php') ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <input type="hidden" name="page_key" value="<?= e($activePage) ?>">
        <div>
            <label class="form-label">Meta Title</label>
            <input type="text" name="meta_title" class="form-input" value="<?= e($current['meta_title'] ?? '') ?>" placeholder="Leave blank to use site default">
        </div>
        <div>
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" rows="3" class="form-input" placeholder="Leave blank to use site default"><?= e($current['meta_description'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="form-label">Canonical URL (optional)</label>
            <input type="url" name="canonical_url" class="form-input" value="<?= e($current['canonical_url'] ?? '') ?>">
        </div>
        <button type="submit" class="btn-primary">Save SEO Settings</button>
    </form>
</div>
