<?php
/** @var array $me */
use App\Core\Csrf;
?>
<div class="card p-8 max-w-lg">
    <form method="POST" action="<?= base_url('/admin/profile.php') ?>" class="space-y-5">
        <?= Csrf::field() ?>
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-input" value="<?= e($me['name']) ?>">
        </div>
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" required class="form-input" value="<?= e($me['email']) ?>">
        </div>
        <hr class="border-brand-neutral-200">
        <p class="text-sm text-brand-neutral-500">Leave the password fields blank to keep your current password.</p>
        <div>
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-input">
        </div>
        <div>
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-input" minlength="8">
        </div>
        <button type="submit" class="btn-primary">Save Changes</button>
    </form>
</div>
