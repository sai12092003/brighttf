<?php
/** @var array $submissions */
/** @var string|null $activeType */
use App\Core\Csrf;
?>
<div class="flex gap-2 mb-5">
    <a href="<?= base_url('/admin/submissions-volunteer.php') ?>" class="rounded-full px-4 py-2 text-sm font-medium <?= !$activeType ? 'bg-brand-blue-900 text-white' : 'bg-white border border-brand-neutral-200' ?>">All</a>
    <a href="<?= base_url('/admin/submissions-volunteer.php?type=volunteer') ?>" class="rounded-full px-4 py-2 text-sm font-medium <?= $activeType === 'volunteer' ? 'bg-brand-blue-900 text-white' : 'bg-white border border-brand-neutral-200' ?>">Volunteers</a>
    <a href="<?= base_url('/admin/submissions-volunteer.php?type=partner') ?>" class="rounded-full px-4 py-2 text-sm font-medium <?= $activeType === 'partner' ? 'bg-brand-blue-900 text-white' : 'bg-white border border-brand-neutral-200' ?>">Partners</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Received</th>
                <th class="px-5 py-3">Type</th>
                <th class="px-5 py-3">Name / Contact</th>
                <th class="px-5 py-3">Details</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($submissions as $s): ?>
                <tr>
                    <td class="px-5 py-3 text-brand-neutral-500 whitespace-nowrap"><?= e(date('M j, Y', strtotime((string) $s['created_at']))) ?></td>
                    <td class="px-5 py-3 capitalize"><?= e($s['submission_type']) ?></td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-brand-blue-900"><?= e($s['name']) ?><?= $s['organization_name'] ? ' (' . e($s['organization_name']) . ')' : '' ?></p>
                        <p class="text-xs text-brand-neutral-500"><?= e($s['email']) ?> &middot; <?= e($s['phone']) ?></p>
                    </td>
                    <td class="px-5 py-3 text-brand-neutral-600 max-w-sm">
                        <?= e($s['area_of_interest'] ?? '') ?>
                        <?php if (!empty($s['message'])): ?><br><span class="text-xs"><?= e($s['message']) ?></span><?php endif; ?>
                    </td>
                    <td class="px-5 py-3">
                        <form method="POST" class="inline">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-brand-neutral-300">
                                <?php foreach (['new', 'contacted', 'onboarded', 'archived'] as $st): ?>
                                    <option value="<?= $st ?>" <?= $s['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="mailto:<?= e($s['email']) ?>" class="text-brand-blue-700 hover:underline">Reply</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this submission?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($submissions)): ?>
                <tr><td colspan="6" class="px-5 py-8 text-center text-brand-neutral-500">No submissions yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
