<?php
/** @var array $users */
use App\Core\Csrf;
use App\Core\Auth;
$myId = Auth::id();
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/users.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add Admin User</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Name</th>
                <th class="px-5 py-3">Username</th>
                <th class="px-5 py-3">Role</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Last Login</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($users as $u): ?>
                <tr>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($u['name']) ?><?= (int) $u['id'] === $myId ? ' <span class="text-xs text-brand-neutral-400">(you)</span>' : '' ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($u['username']) ?></td>
                    <td class="px-5 py-3"><?= e($u['role']) ?></td>
                    <td class="px-5 py-3"><?= (int) $u['is_active'] === 1 ? '<span class="badge-trust !py-0.5">Active</span>' : '<span class="text-brand-neutral-400">Inactive</span>' ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= $u['last_login_at'] ? e(date('M j, Y g:ia', strtotime((string) $u['last_login_at']))) : '—' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/users.php?action=edit&id=' . $u['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <?php if ((int) $u['id'] !== $myId): ?>
                            <form method="POST" class="inline" onsubmit="return confirm('Delete this admin user?');">
                                <?= Csrf::field() ?>
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
