<?php

declare(strict_types=1);

$bootstrap = dirname(__DIR__) . '/app/bootstrap.php';
if (!is_file($bootstrap)) {
    $bootstrap = dirname(__DIR__, 2) . '/app/bootstrap.php';
}
require $bootstrap;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Sanitizer;

if (Auth::check()) {
    redirect('/admin/index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } else {
        $username = Sanitizer::str($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $result = Auth::attempt($username, $password);
        if ($result['ok']) {
            redirect('/admin/index.php');
        }
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>document.documentElement.classList.add('js');</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Bright Today Foundation</title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" type="image/png" href="<?= asset('img/favicon-32x32.png') ?>">
<link rel="stylesheet" href="<?= asset('css/app.min.css') ?>">
</head>
<body class="min-h-screen flex items-center justify-center bg-brand-gradient px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="<?= asset('img/logo-white-160.png') ?>" alt="Bright Today Foundation" class="h-16 w-16 mx-auto">
            <p class="mt-3 text-white font-display text-xl font-semibold">Bright Today Foundation</p>
            <p class="text-brand-blue-200 text-sm">Admin Panel</p>
        </div>
        <div class="bg-white rounded-3xl shadow-soft-lg p-8 sm:p-10">
            <h1 class="font-display text-2xl font-semibold text-brand-blue-900 mb-6">Sign In</h1>
            <?php if ($error): ?>
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm"><?= e($error) ?></div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <?= Csrf::field() ?>
                <div>
                    <label class="form-label">Username</label>
                    <input type="text" name="username" required autofocus class="form-input" value="<?= e($_POST['username'] ?? '') ?>">
                </div>
                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" required class="form-input">
                </div>
                <button type="submit" class="btn-primary w-full">Sign In</button>
            </form>
        </div>
        <p class="text-center text-brand-blue-200 text-xs mt-6">
            <a href="<?= base_url('/') ?>" class="hover:text-white">&larr; Back to website</a>
        </p>
    </div>
</body>
</html>
