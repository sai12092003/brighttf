<?php
/** @var array $settings */
/** @var array $global */

$navLinks = [
    '/' => 'Home',
    '/about' => 'About',
    '/focus-areas' => 'Focus Areas',
    '/get-involved' => 'Get Involved',
    '/gallery' => 'Gallery',
    '/blog' => 'Blog',
    '/contact' => 'Contact',
];
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
?>
<?php if (!empty($global['announcement_bar_text'])): ?>
<div class="bg-brand-blue-900 text-white text-center text-sm py-2 px-4">
    <?= e($global['announcement_bar_text']) ?>
</div>
<?php endif; ?>

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-brand-neutral-200/70">
    <div class="w-full flex items-center gap-6 py-2 px-5 sm:px-8 lg:px-10">
        <a href="<?= base_url('/') ?>" class="flex items-center gap-3 shrink-0">
            <img src="<?= asset('img/logo-color-160.png') ?>" alt="Bright Today Foundation" class="h-20 w-20 sm:h-24 sm:w-24">
            <span class="hidden sm:inline-flex items-baseline gap-1.5 whitespace-nowrap font-display font-bold text-xl lg:text-2xl">
                <span class="text-brand-orange-600">Bright Today</span><span class="text-brand-blue-900">Foundation</span>
            </span>
        </a>

        <nav class="hidden lg:flex items-center gap-7 lg:ml-auto">
            <?php foreach ($navLinks as $href => $label): ?>
                <a href="<?= base_url($href) ?>"
                   class="nav-link <?= $currentPath === $href ? 'text-brand-orange-600' : '' ?>">
                    <?= e($label) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="hidden lg:flex items-center gap-3">
            <a href="<?= base_url('/donate') ?>" class="btn-primary !py-2.5 !px-5 text-sm">Donate Now</a>
        </div>

        <div class="ml-auto lg:hidden"></div>

        <button type="button" id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg text-brand-blue-900 hover:bg-brand-neutral-100" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg id="menu-icon-open" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg id="menu-icon-close" class="hidden h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden border-t border-brand-neutral-200 bg-white">
        <div class="container-custom py-4 flex flex-col gap-1">
            <?php foreach ($navLinks as $href => $label): ?>
                <a href="<?= base_url($href) ?>" class="py-2.5 text-brand-blue-900 font-medium border-b border-brand-neutral-100 last:border-none">
                    <?= e($label) ?>
                </a>
            <?php endforeach; ?>
            <a href="<?= base_url('/donate') ?>" class="btn-primary mt-4 w-full">Donate Now</a>
        </div>
    </div>
</header>
