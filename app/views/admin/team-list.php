<?php
/** @var array $members */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/team.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add Team Member</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Photo</th>
                <th class="px-5 py-3">Name</th>
                <th class="px-5 py-3">Role</th>
                <th class="px-5 py-3">Active</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($members as $m): ?>
                <tr>
                    <td class="px-5 py-3">
                        <?php if (!empty($m['photo_path'])): ?>
                            <img src="<?= upload_url($m['photo_path']) ?>" class="h-10 w-10 rounded-full object-cover">
                        <?php else: ?>
                            <span class="h-10 w-10 rounded-full bg-brand-neutral-200 inline-flex items-center justify-center text-xs text-brand-neutral-500"><?= e(substr($m['name'], 0, 1)) ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($m['name']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($m['role_title']) ?></td>
                    <td class="px-5 py-3"><?= (int) $m['is_active'] === 1 ? '<span class="badge-trust !py-0.5">Active</span>' : '<span class="text-brand-neutral-400">Inactive</span>' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/team.php?action=edit&id=' . $m['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this team member?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($members)): ?>
                <tr><td colspan="5" class="px-5 py-8 text-center text-brand-neutral-500">No team members yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
