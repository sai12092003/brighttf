<?php
/** @var array $albums */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/gallery-albums.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add Album</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Cover</th>
                <th class="px-5 py-3">Title</th>
                <th class="px-5 py-3">Active</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($albums as $a): ?>
                <tr>
                    <td class="px-5 py-3">
                        <?php if (!empty($a['cover_image'])): ?>
                            <img src="<?= upload_url($a['cover_image']) ?>" class="h-10 w-10 rounded-lg object-cover">
                        <?php else: ?>
                            <span class="h-10 w-10 rounded-lg bg-brand-neutral-200 inline-block"></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($a['title']) ?></td>
                    <td class="px-5 py-3"><?= (int) $a['is_active'] === 1 ? '<span class="badge-trust !py-0.5">Active</span>' : '<span class="text-brand-neutral-400">Inactive</span>' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/gallery-albums.php?action=edit&id=' . $a['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this album? Images inside will become uncategorized.');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($albums)): ?>
                <tr><td colspan="4" class="px-5 py-8 text-center text-brand-neutral-500">No albums yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
