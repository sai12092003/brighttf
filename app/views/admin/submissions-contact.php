<?php
/** @var array $submissions */
use App\Core\Csrf;
$statusColors = ['new' => 'badge-trust', 'read' => '', 'responded' => 'badge-trust', 'archived' => ''];
?>
<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Received</th>
                <th class="px-5 py-3">Name / Contact</th>
                <th class="px-5 py-3">Subject</th>
                <th class="px-5 py-3">Message</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($submissions as $s): ?>
                <tr>
                    <td class="px-5 py-3 text-brand-neutral-500 whitespace-nowrap"><?= e(date('M j, Y', strtotime((string) $s['created_at']))) ?></td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-brand-blue-900"><?= e($s['name']) ?></p>
                        <p class="text-xs text-brand-neutral-500"><?= e($s['email']) ?><?= $s['phone'] ? ' &middot; ' . e($s['phone']) : '' ?></p>
                    </td>
                    <td class="px-5 py-3 text-brand-neutral-600"><?= e($s['subject'] ?? '') ?></td>
                    <td class="px-5 py-3 text-brand-neutral-600 max-w-sm"><?= e($s['message']) ?></td>
                    <td class="px-5 py-3">
                        <form method="POST" class="inline">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-brand-neutral-300">
                                <?php foreach (['new', 'read', 'responded', 'archived'] as $st): ?>
                                    <option value="<?= $st ?>" <?= $s['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="mailto:<?= e($s['email']) ?>" class="text-brand-blue-700 hover:underline">Reply</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this message?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($submissions)): ?>
                <tr><td colspan="6" class="px-5 py-8 text-center text-brand-neutral-500">No messages yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
