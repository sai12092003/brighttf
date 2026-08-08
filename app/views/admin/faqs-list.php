<?php
/** @var array $faqs */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/faqs.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add FAQ</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Question</th>
                <th class="px-5 py-3">Active</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($faqs as $f): ?>
                <tr>
                    <td class="px-5 py-3 font-medium text-brand-blue-900 max-w-xl"><?= e($f['question']) ?></td>
                    <td class="px-5 py-3"><?= (int) $f['is_active'] === 1 ? '<span class="badge-trust !py-0.5">Active</span>' : '<span class="text-brand-neutral-400">Inactive</span>' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/faqs.php?action=edit&id=' . $f['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this FAQ?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $f['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($faqs)): ?>
                <tr><td colspan="3" class="px-5 py-8 text-center text-brand-neutral-500">No FAQs yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
