<?php
/** @var array $pledges */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/pledges.php?export=csv') ?>" class="btn-secondary !py-2.5 !px-5 text-sm">Export CSV</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Date</th>
                <th class="px-5 py-3">Donor</th>
                <th class="px-5 py-3">Amount</th>
                <th class="px-5 py-3">Mode / Ref.</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($pledges as $p): ?>
                <tr>
                    <td class="px-5 py-3 text-brand-neutral-500 whitespace-nowrap"><?= e(date('M j, Y', strtotime((string) $p['created_at']))) ?></td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-brand-blue-900"><?= e($p['donor_name']) ?></p>
                        <p class="text-xs text-brand-neutral-500"><?= e($p['phone']) ?><?= $p['email'] ? ' &middot; ' . e($p['email']) : '' ?></p>
                    </td>
                    <td class="px-5 py-3 font-semibold text-brand-blue-900">&#8377;<?= e(number_format((float) $p['amount'], 2)) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e(ucfirst(str_replace('_', ' ', $p['mode']))) ?><?= $p['reference_utr'] ? ' &middot; ' . e($p['reference_utr']) : '' ?></td>
                    <td class="px-5 py-3">
                        <form method="POST" class="inline">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-brand-neutral-300">
                                <?php foreach (['new', 'contacted', 'confirmed', 'closed'] as $st): ?>
                                    <option value="<?= $st ?>" <?= $p['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this pledge record?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pledges)): ?>
                <tr><td colspan="6" class="px-5 py-8 text-center text-brand-neutral-500">No pledges yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
