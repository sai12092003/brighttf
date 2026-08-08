<?php
/** @var array|null $document */
/** @var array $docTypes */
use App\Core\Csrf;
$isEdit = $document !== null;
?>
<a href="<?= base_url('/admin/legal-documents.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Legal Documents</a>

<div class="card p-8 mt-4 max-w-xl">
    <form method="POST" action="<?= base_url('/admin/legal-documents.php' . ($isEdit ? '?id=' . $document['id'] : '')) ?>" class="space-y-5" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Title</label>
            <input type="text" name="title" required class="form-input" value="<?= e($document['title'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Document Type</label>
            <select name="doc_type" class="form-input">
                <?php foreach ($docTypes as $type): ?>
                    <option value="<?= e($type) ?>" <?= ($document['doc_type'] ?? '') === $type ? 'selected' : '' ?>><?= e($type) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if ($isEdit): ?>
            <p class="text-sm text-brand-neutral-500">Current file: <a href="<?= upload_url($document['file_path']) ?>" target="_blank" class="text-brand-blue-700 hover:underline"><?= e(basename($document['file_path'])) ?></a></p>
        <?php endif; ?>
        <div>
            <label class="form-label">PDF File <?= $isEdit ? '(leave blank to keep current file)' : '' ?></label>
            <input type="file" name="file" accept="application/pdf" <?= $isEdit ? '' : 'required' ?> class="form-input">
        </div>
        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="2" class="form-input"><?= e($document['description'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-input" value="<?= e((string) ($document['sort_order'] ?? 0)) ?>">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_public" value="1" <?= !$isEdit || (int) ($document['is_public'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Public (visible on Transparency page)</span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Upload Document' ?></button>
    </form>
</div>
