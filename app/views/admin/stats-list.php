<?php
/** @var array $stats */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/stats.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add Stat Counter</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Label</th>
                <th class="px-5 py-3">Value</th>
                <th class="px-5 py-3">Active</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($stats as $s): ?>
                <tr>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($s['label']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= (int) $s['number_value'] ?><?= e($s['suffix']) ?></td>
                    <td class="px-5 py-3"><?= (int) $s['is_active'] === 1 ? '<span class="badge-trust !py-0.5">Active</span>' : '<span class="text-brand-neutral-400">Inactive</span>' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/stats.php?action=edit&id=' . $s['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this stat counter?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($stats)): ?>
                <tr><td colspan="4" class="px-5 py-8 text-center text-brand-neutral-500">No stat counters yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
