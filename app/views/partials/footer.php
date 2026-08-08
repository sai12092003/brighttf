<?php
/** @var array $settings */
$socialLinks = [
    'social_facebook' => 'Facebook',
    'social_instagram' => 'Instagram',
    'social_twitter' => 'Twitter / X',
    'social_youtube' => 'YouTube',
    'social_linkedin' => 'LinkedIn',
];
?>
<footer class="bg-brand-blue-950 text-brand-blue-100">
    <div class="container-custom py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <div class="lg:col-span-1">
            <a href="<?= base_url('/') ?>" class="flex items-center gap-3 mb-4">
                <img src="<?= asset('img/logo-white-160.png') ?>" alt="Bright Today Foundation" class="h-12 w-12">
                <span class="font-display font-semibold text-white text-lg">Bright Today Foundation</span>
            </a>
            <p class="text-sm text-brand-blue-200 leading-relaxed"><?= e($settings['footer_about_text'] ?? '') ?></p>
            <?php if (array_filter($socialLinks, fn($k) => !empty($settings[$k]), ARRAY_FILTER_USE_KEY)): ?>
            <div class="flex gap-3 mt-5">
                <?php foreach ($socialLinks as $key => $label): if (!empty($settings[$key])): ?>
                    <a href="<?= e($settings[$key]) ?>" target="_blank" rel="noopener" class="h-9 w-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange-500 transition-colors text-xs font-semibold" title="<?= e($label) ?>">
                        <?= e(strtoupper(substr($label, 0, 1))) ?>
                    </a>
                <?php endif; endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-4">Explore</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="<?= base_url('/about') ?>" class="hover:text-white transition-colors">About Us</a></li>
                <li><a href="<?= base_url('/focus-areas') ?>" class="hover:text-white transition-colors">Focus Areas</a></li>
                <li><a href="<?= base_url('/team') ?>" class="hover:text-white transition-colors">Our Team</a></li>
                <li><a href="<?= base_url('/gallery') ?>" class="hover:text-white transition-colors">Gallery</a></li>
                <li><a href="<?= base_url('/blog') ?>" class="hover:text-white transition-colors">Blog</a></li>
                <li><a href="<?= base_url('/faq') ?>" class="hover:text-white transition-colors">FAQ</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-4">Get Involved</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="<?= base_url('/get-involved') ?>" class="hover:text-white transition-colors">Volunteer</a></li>
                <li><a href="<?= base_url('/get-involved') ?>" class="hover:text-white transition-colors">Partner With Us</a></li>
                <li><a href="<?= base_url('/donate') ?>" class="hover:text-white transition-colors">Donate</a></li>
                <li><a href="<?= base_url('/transparency') ?>" class="hover:text-white transition-colors">Transparency &amp; Legal</a></li>
                <li><a href="<?= base_url('/privacy-policy') ?>" class="hover:text-white transition-colors">Privacy Policy</a></li>
                <li><a href="<?= base_url('/terms') ?>" class="hover:text-white transition-colors">Terms of Use</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-white font-semibold mb-4">Contact</h3>
            <ul class="space-y-3 text-sm">
                <li class="leading-relaxed"><?= e($settings['office_address_public'] ?? '') ?></li>
                <li><a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone_1'] ?? '')) ?>" class="hover:text-white transition-colors"><?= e($settings['contact_phone_1'] ?? '') ?></a></li>
                <li><a href="mailto:<?= e($settings['contact_email'] ?? '') ?>" class="hover:text-white transition-colors"><?= e($settings['contact_email'] ?? '') ?></a></li>
            </ul>
            <div class="flex flex-wrap gap-2 mt-5">
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium">12A Registered</span>
                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium">80G Approved</span>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-custom py-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-brand-blue-300">
            <p><?= e($settings['footer_copyright_text'] ?? '') ?></p>
            <p>PAN: <?= e($settings['pan_number'] ?? '') ?> &middot; 12A: <?= e($settings['reg_12a_number'] ?? '') ?> &middot; 80G: <?= e($settings['reg_80g_number'] ?? '') ?></p>
        </div>
    </div>
</footer>

<script src="<?= asset('js/main.js') ?>?v=<?= @filemtime(config('paths.public') . '/assets/js/main.js') ?: 1 ?>" defer></script>
