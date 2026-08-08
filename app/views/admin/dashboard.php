<?php
/** @var int $newContact */
/** @var int $newVolunteer */
/** @var int $newPledges */
/** @var int $posts */
/** @var array $recentActivity */
?>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <a href="<?= base_url('/admin/submissions-contact.php') ?>" class="card p-6 hover:shadow-soft-lg">
        <p class="text-xs uppercase tracking-wide text-brand-neutral-500">New Contact Messages</p>
        <p class="mt-2 font-display text-3xl font-semibold text-brand-blue-900"><?= (int) $newContact ?></p>
    </a>
    <a href="<?= base_url('/admin/submissions-volunteer.php') ?>" class="card p-6 hover:shadow-soft-lg">
        <p class="text-xs uppercase tracking-wide text-brand-neutral-500">New Volunteer / Partner</p>
        <p class="mt-2 font-display text-3xl font-semibold text-brand-blue-900"><?= (int) $newVolunteer ?></p>
    </a>
    <a href="<?= base_url('/admin/pledges.php') ?>" class="card p-6 hover:shadow-soft-lg">
        <p class="text-xs uppercase tracking-wide text-brand-neutral-500">New Donation Pledges</p>
        <p class="mt-2 font-display text-3xl font-semibold text-brand-blue-900"><?= (int) $newPledges ?></p>
    </a>
    <a href="<?= base_url('/admin/blog.php') ?>" class="card p-6 hover:shadow-soft-lg">
        <p class="text-xs uppercase tracking-wide text-brand-neutral-500">Blog Posts</p>
        <p class="mt-2 font-display text-3xl font-semibold text-brand-blue-900"><?= (int) $posts ?></p>
    </a>
</div>

<div class="card p-6">
    <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-4">Recent Activity</h2>
    <?php if (empty($recentActivity)): ?>
        <p class="text-sm text-brand-neutral-500">No activity recorded yet.</p>
    <?php else: ?>
        <div class="divide-y divide-brand-neutral-100 text-sm">
            <?php foreach ($recentActivity as $log): ?>
                <div class="py-3 flex justify-between gap-4">
                    <div>
                        <span class="font-medium text-brand-blue-900"><?= e($log['admin_name'] ?? 'System') ?></span>
                        <span class="text-brand-neutral-500"> &mdash; <?= e($log['description'] ?? $log['action']) ?></span>
                    </div>
                    <span class="text-brand-neutral-400 whitespace-nowrap"><?= e(date('M j, g:ia', strtotime((string) $log['created_at']))) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
