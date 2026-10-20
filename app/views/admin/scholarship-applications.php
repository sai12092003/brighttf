<?php
/** @var array $applications */
use App\Core\Csrf;

$statuses = ['new', 'reviewed', 'shortlisted', 'approved', 'rejected'];
?>
<div class="mb-4 flex items-center justify-between">
    <p class="text-sm text-brand-neutral-500"><?= count($applications) ?> application<?= count($applications) === 1 ? '' : 's' ?> received.</p>
    <?php if (!empty($applications)): ?>
        <a href="<?= base_url('/admin/scholarship-applications.php?export=csv') ?>" class="text-sm text-brand-blue-700 hover:underline">Export CSV</a>
    <?php endif; ?>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Received</th>
                <th class="px-5 py-3">Applicant</th>
                <th class="px-5 py-3">Scholarship</th>
                <th class="px-5 py-3">Details</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($applications as $a): ?>
                <tr>
                    <td class="px-5 py-3 text-brand-neutral-500 whitespace-nowrap"><?= e(date('M j, Y', strtotime((string) $a['created_at']))) ?></td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-brand-blue-900"><?= e($a['full_name']) ?></p>
                        <p class="text-xs text-brand-neutral-500"><?= e($a['email']) ?> &middot; <?= e($a['phone']) ?></p>
                        <?php if (!empty($a['city'])): ?><p class="text-xs text-brand-neutral-400"><?= e($a['city']) ?></p><?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-brand-neutral-600 max-w-[14rem]"><?= e($a['scholarship_name']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-600 max-w-sm">
                        <div class="space-y-0.5 text-xs">
                            <?php if (!empty($a['qualification'])): ?><p><span class="text-brand-neutral-400">Qualification:</span> <?= e($a['qualification']) ?></p><?php endif; ?>
                            <?php if (!empty($a['annual_income'])): ?><p><span class="text-brand-neutral-400">Income:</span> <?= e($a['annual_income']) ?></p><?php endif; ?>
                            <?php if (!empty($a['date_of_birth'])): ?><p><span class="text-brand-neutral-400">DOB:</span> <?= e(date('M j, Y', strtotime((string) $a['date_of_birth']))) ?></p><?php endif; ?>
                            <?php if (!empty($a['gender'])): ?><p><span class="text-brand-neutral-400">Gender:</span> <?= e($a['gender']) ?></p><?php endif; ?>
                            <?php if (!empty($a['differently_abled'])): ?><p><span class="text-brand-neutral-400">Differently Abled:</span> <?= e($a['differently_abled']) ?></p><?php endif; ?>
                            <?php if (!empty($a['guardian_name'])): ?><p><span class="text-brand-neutral-400">Guardian:</span> <?= e($a['guardian_name']) ?></p><?php endif; ?>
                            <?php if (!empty($a['address'])): ?><p><span class="text-brand-neutral-400">Address:</span> <?= e($a['address']) ?></p><?php endif; ?>
                            <?php if (!empty($a['message'])): ?><p class="mt-1 text-brand-neutral-600"><?= e($a['message']) ?></p><?php endif; ?>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <form method="POST" class="inline">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-brand-neutral-300">
                                <?php foreach ($statuses as $st): ?>
                                    <option value="<?= $st ?>" <?= $a['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-right space-x-3 whitespace-nowrap">
                        <a href="mailto:<?= e($a['email']) ?>" class="text-brand-blue-700 hover:underline">Email</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this application? This cannot be undone.');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($applications)): ?>
                <tr><td colspan="6" class="px-5 py-8 text-center text-brand-neutral-500">No scholarship applications yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
