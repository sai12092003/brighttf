<?php
/** @var array $categories */
use App\Core\Csrf;
?>
<div class="flex justify-end mb-5">
    <a href="<?= base_url('/admin/blog-categories.php?action=create') ?>" class="btn-primary !py-2.5 !px-5 text-sm">+ Add Category</a>
</div>

<div class="card overflow-x-auto max-w-xl">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Name</th>
                <th class="px-5 py-3">Slug</th>
                <th class="px-5 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($categories as $c): ?>
                <tr>
                    <td class="px-5 py-3 font-medium text-brand-blue-900"><?= e($c['name']) ?></td>
                    <td class="px-5 py-3 text-brand-neutral-500"><?= e($c['slug']) ?></td>
                    <td class="px-5 py-3 text-right space-x-3">
                        <a href="<?= base_url('/admin/blog-categories.php?action=edit&id=' . $c['id']) ?>" class="text-brand-blue-700 hover:underline">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $c['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($categories)): ?>
                <tr><td colspan="3" class="px-5 py-8 text-center text-brand-neutral-500">No categories yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
