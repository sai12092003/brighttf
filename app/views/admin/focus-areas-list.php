<?php
/** @var array $areas */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/focus-areas.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add Focus Area</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Order</th>
                <th class="px-5 py-3">Title</th>
                <th class="px-5 py-3">Slug</th>
                <th class="px-5 py-3">Active</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($areas as $area): ?>
                <tr>
                    <td class="px-5 py-3"><?= (int) $area['sort_order'] ?></td>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($area['title']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($area['slug']) ?></td>
                    <td class="px-5 py-3">
                        <?php if ((int) $area['is_active'] === 1): ?>
                            <span class="badge-trust !py-0.5">Active</span>
                        <?php else: ?>
                            <span class="text-brand-neutral-400">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/focus-areas.php?action=edit&id=' . $area['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this focus area?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $area['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($areas)): ?>
                <tr><td colspan="5" class="px-5 py-8 text-center text-brand-neutral-500">No focus areas yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
