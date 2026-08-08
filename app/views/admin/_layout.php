<?php
/** @var string $content */
/** @var string $pageTitle */
use App\Core\Auth;

$admin = Auth::user();
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');

$navGroups = [
    'Overview' => [
        'index.php' => 'Dashboard',
    ],
    'Content' => [
        'content-blocks.php' => 'Page Content',
        'focus-areas.php' => 'Focus Areas',
        'team.php' => 'Team Members',
        'testimonials.php' => 'Testimonials',
        'faqs.php' => 'FAQs',
        'stats.php' => 'Stat Counters',
    ],
    'Blog & Gallery' => [
        'blog.php' => 'Blog Posts',
        'blog-categories.php' => 'Blog Categories',
        'gallery.php' => 'Gallery Images',
        'gallery-albums.php' => 'Gallery Albums',
    ],
    'Inbox' => [
        'submissions-contact.php' => 'Contact Messages',
        'submissions-volunteer.php' => 'Volunteer / Partner',
        'pledges.php' => 'Donation Pledges',
    ],
    'Configuration' => [
        'legal-documents.php' => 'Legal Documents',
        'settings.php' => 'Site Settings',
        'seo.php' => 'SEO Meta',
        'users.php' => 'Admin Users',
        'activity-log.php' => 'Activity Log',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>document.documentElement.classList.add('js');</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? 'Admin') ?> | Bright Today Foundation Admin</title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" type="image/png" href="<?= asset('img/favicon-32x32.png') ?>">
<link rel="stylesheet" href="<?= asset('css/app.min.css') ?>">
</head>
<body class="min-h-screen bg-brand-neutral-50">
    <div class="lg:flex">
        <aside class="lg:w-64 shrink-0 bg-brand-blue-950 text-white lg:min-h-screen">
            <div class="p-5 flex items-center gap-3 border-b border-white/10">
                <img src="<?= asset('img/logo-white-160.png') ?>" alt="" class="h-9 w-9">
                <div>
                    <p class="font-display font-semibold leading-tight">Bright Today</p>
                    <p class="text-[11px] text-brand-blue-300 uppercase tracking-wide">Admin Panel</p>
                </div>
            </div>
            <nav class="p-4 space-y-6 text-sm">
                <?php foreach ($navGroups as $group => $links): ?>
                    <div>
                        <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wider text-brand-blue-400"><?= e($group) ?></p>
                        <div class="space-y-1">
                            <?php foreach ($links as $file => $label): ?>
                                <a href="<?= base_url('/admin/' . $file) ?>"
                                   class="block rounded-lg px-3 py-2 transition-colors <?= $currentScript === $file ? 'bg-white/10 text-white font-medium' : 'text-brand-blue-200 hover:bg-white/5 hover:text-white' ?>">
                                    <?= e($label) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="flex-1 min-w-0">
            <header class="bg-white border-b border-brand-neutral-200 px-6 py-4 flex items-center justify-between">
                <h1 class="font-display text-xl font-semibold text-brand-blue-900"><?= e($pageTitle ?? 'Dashboard') ?></h1>
                <div class="flex items-center gap-4 text-sm">
                    <a href="<?= base_url('/') ?>" target="_blank" class="text-brand-neutral-500 hover:text-brand-blue-700">View Site &rarr;</a>
                    <span class="text-brand-neutral-300">|</span>
                    <span class="text-brand-neutral-600"><?= e($admin['name'] ?? '') ?> <span class="text-xs text-brand-neutral-400">(<?= e($admin['role'] ?? '') ?>)</span></span>
                    <a href="<?= base_url('/admin/profile.php') ?>" class="text-brand-neutral-500 hover:text-brand-blue-700">Profile</a>
                    <a href="<?= base_url('/admin/logout.php') ?>" class="text-red-600 hover:text-red-700 font-medium">Logout</a>
                </div>
            </header>

            <main class="p-6">
                <?php $success = flash_success(); $error = flash_error(); ?>
                <?php if ($success): ?>
                    <div class="mb-6 rounded-xl bg-brand-green-50 border border-brand-green-200 text-brand-green-800 px-4 py-3 text-sm"><?= e($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm"><?= e($error) ?></div>
                <?php endif; ?>
                <?= $content ?>
            </main>
        </div>
    </div>
    <script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
