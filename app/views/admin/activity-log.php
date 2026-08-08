<?php
/** @var array $logs */
?>
<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">When</th>
                <th class="px-5 py-3">Admin</th>
                <th class="px-5 py-3">Action</th>
                <th class="px-5 py-3">Description</th>
                <th class="px-5 py-3">IP Address</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td class="px-5 py-3 text-brand-neutral-500 whitespace-nowrap"><?= e(date('M j, Y g:ia', strtotime((string) $log['created_at']))) ?></td>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($log['admin_name'] ?? 'System') ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($log['action']) ?></td>
                    <td class="px-5 py-3"><?= e($log['description'] ?? '') ?></td>
                    <td class="px-5 py-3 text-brand-neutral-400"><?= e($log['ip_address'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($logs)): ?>
                <tr><td colspan="5" class="px-5 py-8 text-center text-brand-neutral-500">No activity recorded yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
