<?php
/** @var array $documents */
use App\Core\Csrf;
?>
<div class="mb-5 flex items-center justify-between">
    <p class="text-sm text-brand-neutral-500 max-w-xl">Documents marked "Public" appear on the site's Transparency &amp; Legal page. Keep any document containing personal ID numbers (e.g. Aadhaar) set to Private.</p>
    <a href="<?= base_url('/admin/legal-documents.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm whitespace-nowrap">+ Upload Document</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Title</th>
                <th class="px-5 py-3">Type</th>
                <th class="px-5 py-3">Visibility</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($documents as $d): ?>
                <tr>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($d['title']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($d['doc_type']) ?></td>
                    <td class="px-5 py-3"><?= (int) $d['is_public'] === 1 ? '<span class="badge-trust !py-0.5">Public</span>' : '<span class="text-brand-neutral-400">Private</span>' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= upload_url($d['file_path']) ?>" target="_blank" class="text-brand-neutral-500 hover:underline">View</a>
                        <a href="<?= base_url('/admin/legal-documents.php?action=edit&id=' . $d['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this document?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $d['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($documents)): ?>
                <tr><td colspan="4" class="px-5 py-8 text-center text-brand-neutral-500">No documents yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
