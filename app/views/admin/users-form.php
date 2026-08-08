<?php
/** @var array|null $targetUser */
use App\Core\Csrf;
$isEdit = $targetUser !== null;
?>
<a href="<?= base_url('/admin/users.php') ?>" class="text-sm text-brand-neutral-500 hover:text-brand-blue-700">&larr; Back to Admin Users</a>

<div class="card p-8 mt-4 max-w-lg">
    <form method="POST" action="<?= base_url('/admin/users.php' . ($isEdit ? '?id=' . $targetUser['id'] : '')) ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-input" value="<?= e($targetUser['name'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Username</label>
            <input type="text" name="username" required class="form-input" value="<?= e($targetUser['username'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" required class="form-input" value="<?= e($targetUser['email'] ?? '') ?>">
        </div>
        <div>
            <label class="form-label">Role</label>
            <select name="role" class="form-input">
                <option value="editor" <?= ($targetUser['role'] ?? '') === 'editor' ? 'selected' : '' ?>>Editor</option>
                <option value="super_admin" <?= ($targetUser['role'] ?? '') === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
            </select>
        </div>
        <div>
            <label class="form-label">Password <?= $isEdit ? '(leave blank to keep current password)' : '' ?></label>
            <input type="password" name="password" class="form-input" minlength="8" <?= $isEdit ? '' : 'required' ?>>
        </div>
        <div>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" <?= !$isEdit || (int) ($targetUser['is_active'] ?? 1) === 1 ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                <span class="text-sm text-brand-blue-900">Active</span>
            </label>
        </div>
        <button type="submit" class="btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Admin User' ?></button>
    </form>
</div>
