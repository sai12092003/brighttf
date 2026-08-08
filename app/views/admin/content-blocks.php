<?php
/** @var array $grouped */
/** @var string $activePage */
use App\Core\Csrf;

$pageLabels = [
    'home' => 'Home Page',
    'about' => 'About Page',
    'get_involved' => 'Get Involved',
    'donate' => 'Donate',
    'global' => 'Global / Footer',
    'privacy_policy' => 'Privacy Policy',
    'terms' => 'Terms of Use',
    'error_404' => '404 Page',
];
?>
<div class="flex flex-wrap gap-2 mb-6">
    <?php foreach (array_keys($grouped) as $pageKey): ?>
        <a href="<?= base_url('/admin/content-blocks.php?page=' . urlencode($pageKey)) ?>"
           class="rounded-full px-4 py-2 text-sm font-medium <?= $pageKey === $activePage ? 'bg-brand-blue-900 text-white' : 'bg-white border border-brand-neutral-200 text-brand-blue-900 hover:border-brand-blue-400' ?>">
            <?= e($pageLabels[$pageKey] ?? ucfirst(str_replace('_', ' ', $pageKey))) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="card p-8">
    <form method="POST" action="<?= base_url('/admin/content-blocks.php') ?>" enctype="multipart/form-data" class="space-y-6">
        <?= Csrf::field() ?>
        <input type="hidden" name="page_key" value="<?= e($activePage) ?>">

        <?php foreach ($grouped[$activePage] ?? [] as $block): ?>
            <div class="border-b border-brand-neutral-100 pb-6 last:border-none">
                <input type="hidden" name="block_id[]" value="<?= (int) $block['id'] ?>">
                <input type="hidden" name="block_type[<?= (int) $block['id'] ?>]" value="<?= e($block['block_type']) ?>">
                <label class="form-label"><?= e($block['label']) ?> <span class="text-brand-neutral-400 font-normal">(<?= e($block['block_key']) ?>)</span></label>

                <?php if ($block['block_type'] === 'richtext'): ?>
                    <textarea name="content[<?= (int) $block['id'] ?>]" rows="5" class="form-input"><?= e($block['content_text'] ?? '') ?></textarea>
                <?php elseif ($block['block_type'] === 'text' && str_contains($block['block_key'], 'text') || $block['block_type'] === 'text' && str_ends_with($block['block_key'], 'note')): ?>
                    <textarea name="content[<?= (int) $block['id'] ?>]" rows="2" class="form-input"><?= e($block['content_text'] ?? '') ?></textarea>
                <?php elseif ($block['block_type'] === 'image'): ?>
                    <?php if (!empty($block['image_path'])): ?>
                        <img src="<?= upload_url($block['image_path']) ?>" class="h-20 rounded-lg mb-2 object-cover">
                    <?php endif; ?>
                    <input type="file" name="image[<?= (int) $block['id'] ?>]" accept="image/*" class="form-input">
                <?php else: ?>
                    <input type="text" name="content[<?= (int) $block['id'] ?>]" class="form-input" value="<?= e($block['content_text'] ?? '') ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (empty($grouped[$activePage])): ?>
            <p class="text-brand-neutral-500">No content blocks for this page.</p>
        <?php else: ?>
            <button type="submit" class="btn-primary">Save Page Content</button>
        <?php endif; ?>
    </form>
</div>
