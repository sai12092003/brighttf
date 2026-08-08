<?php
/** @var array $posts */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/blog.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ New Post</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Title</th>
                <th class="px-5 py-3">Category</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Published</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($posts as $p): ?>
                <tr>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($p['title']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($p['category_name'] ?? '—') ?></td>
                    <td class="px-5 py-3">
                        <?php if ($p['status'] === 'published'): ?>
                            <span class="badge-trust !py-0.5">Published</span>
                        <?php else: ?>
                            <span class="text-brand-neutral-400">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= $p['published_at'] ? e(date('M j, Y', strtotime((string) $p['published_at']))) : '—' ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/blog.php?action=edit&id=' . $p['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <tr><td colspan="5" class="px-5 py-8 text-center text-brand-neutral-500">No blog posts yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
