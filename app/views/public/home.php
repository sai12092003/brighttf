<?php
/** @var array $blocks */
/** @var array $focusAreas */
/** @var array $stats */
/** @var array $testimonials */
/** @var array $posts */
?>

<section class="relative overflow-hidden bg-brand-gradient text-white">
    <div class="absolute inset-0 opacity-[0.07] bg-[radial-gradient(circle_at_20%_20%,white,transparent_35%),radial-gradient(circle_at_80%_60%,white,transparent_30%)]"></div>
    <div class="container-custom relative py-24 sm:py-28 lg:py-36 grid lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 reveal">
            <span class="badge-trust !bg-white/10 !text-white !border-white/20">12A &amp; 80G Registered Trust</span>
            <h1 class="mt-6 font-display text-4xl sm:text-5xl lg:text-6xl font-semibold leading-[1.1]">
                <?= e($blocks['hero_title'] ?? '') ?>
            </h1>
            <p class="mt-6 max-w-xl text-lg text-brand-blue-100 leading-relaxed">
                <?= e($blocks['hero_subtitle'] ?? '') ?>
            </p>
            <div class="mt-9 flex flex-wrap gap-4">
                <a href="<?= base_url($blocks['hero_cta_link'] ?? '/donate') ?>" class="btn-primary">
                    <?= e($blocks['hero_cta_text'] ?? 'Donate Now') ?>
                </a>
                <a href="<?= base_url($blocks['hero_secondary_cta_link'] ?? '/get-involved') ?>" class="btn-ghost-light">
                    <?= e($blocks['hero_secondary_cta_text'] ?? 'Get Involved') ?>
                </a>
            </div>
        </div>
        <div class="lg:col-span-5 flex justify-center reveal">
            <div class="relative">
                <div class="absolute -inset-8 rounded-full bg-white/5 blur-2xl"></div>
                <img src="<?= asset('img/logo-color-512.png') ?>" alt="Bright Today Foundation" class="relative w-56 sm:w-72 lg:w-80 drop-shadow-2xl">
            </div>
        </div>
    </div>
</section>

<?php if (!empty($stats)): ?>
<section class="bg-brand-blue-900">
    <div class="container-custom py-10 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
        <?php foreach ($stats as $stat): ?>
            <div>
                <p class="stat-number" data-counter="<?= (int) $stat['number_value'] ?>"><?= (int) $stat['number_value'] ?></p>
                <p class="mt-1 text-sm uppercase tracking-wide text-brand-blue-200"><?= e($stat['label']) ?><?= e($stat['suffix']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container-custom grid lg:grid-cols-12 gap-14 items-center">
        <div class="lg:col-span-5 reveal">
            <p class="eyebrow">Our Story</p>
            <h2 class="section-title"><?= e($blocks['intro_heading'] ?? '') ?></h2>
            <p class="section-lede"><?= e($blocks['intro_text'] ?? '') ?></p>
            <a href="<?= base_url('/about') ?>" class="btn-secondary mt-8">Read Our Full Story</a>
        </div>
        <div class="lg:col-span-7 grid grid-cols-2 gap-5 reveal">
            <div class="card p-8 flex flex-col items-start gap-3">
                <span class="h-11 w-11 rounded-2xl bg-brand-orange-50 flex items-center justify-center text-brand-orange-600 font-display text-xl">01</span>
                <p class="font-semibold text-brand-blue-900">Founded 2025</p>
                <p class="text-sm text-brand-neutral-600">A registered trust built on transparency and accountability.</p>
            </div>
            <div class="card p-8 flex flex-col items-start gap-3 sm:mt-8">
                <span class="h-11 w-11 rounded-2xl bg-brand-green-50 flex items-center justify-center text-brand-green-600 font-display text-xl">02</span>
                <p class="font-semibold text-brand-blue-900">Community-Led</p>
                <p class="text-sm text-brand-neutral-600">Programs shaped with, not just for, the communities we serve.</p>
            </div>
            <div class="card p-8 flex flex-col items-start gap-3">
                <span class="h-11 w-11 rounded-2xl bg-brand-blue-50 flex items-center justify-center text-brand-blue-700 font-display text-xl">03</span>
                <p class="font-semibold text-brand-blue-900">Youth-Powered</p>
                <p class="text-sm text-brand-neutral-600">A volunteering movement driven by India's younger generation.</p>
            </div>
            <div class="card p-8 flex flex-col items-start gap-3 sm:mt-8">
                <span class="h-11 w-11 rounded-2xl bg-brand-orange-50 flex items-center justify-center text-brand-orange-600 font-display text-xl">04</span>
                <p class="font-semibold text-brand-blue-900">100% Transparent</p>
                <p class="text-sm text-brand-neutral-600">12A &amp; 80G registered, with public registration documents.</p>
            </div>
        </div>
    </div>
</section>

<section class="section bg-brand-neutral-50">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto text-center reveal">
            <p class="eyebrow">What We Do</p>
            <h2 class="section-title"><?= e($blocks['focus_areas_heading'] ?? 'Our Core Focus Areas') ?></h2>
        </div>
        <div class="mt-14 grid md:grid-cols-3 gap-8">
            <?php foreach ($focusAreas as $i => $area): ?>
                <?php $colors = ['orange', 'green', 'blue']; $c = $colors[$i % 3]; ?>
                <a href="<?= base_url('/focus-areas/' . $area['slug']) ?>" class="card p-8 group reveal" style="transition-delay: <?= $i * 100 ?>ms">
                    <span class="inline-flex h-14 w-14 rounded-2xl bg-brand-<?= $c ?>-50 items-center justify-center text-brand-<?= $c ?>-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <h3 class="font-display text-xl font-semibold text-brand-blue-900 group-hover:text-brand-orange-600 transition-colors"><?= e($area['title']) ?></h3>
                    <p class="mt-3 text-sm text-brand-neutral-600 leading-relaxed"><?= e($area['goal_text']) ?></p>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-orange-600">
                        Learn more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($testimonials)): ?>
<section class="section">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto text-center reveal">
            <p class="eyebrow">Voices</p>
            <h2 class="section-title">Stories From Our Community</h2>
        </div>
        <div class="mt-14 grid md:grid-cols-3 gap-8">
            <?php foreach ($testimonials as $t): ?>
                <div class="card p-8 reveal">
                    <svg class="h-8 w-8 text-brand-orange-300 mb-4" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zm14 0c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/></svg>
                    <p class="text-brand-neutral-700 leading-relaxed">&ldquo;<?= e($t['quote']) ?>&rdquo;</p>
                    <p class="mt-5 font-semibold text-brand-blue-900"><?= e($t['name']) ?></p>
                    <?php if (!empty($t['role_or_location'])): ?>
                        <p class="text-sm text-brand-neutral-500"><?= e($t['role_or_location']) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($posts)): ?>
<section class="section bg-brand-neutral-50">
    <div class="container-custom">
        <div class="flex flex-wrap items-end justify-between gap-4 reveal">
            <div>
                <p class="eyebrow">Latest</p>
                <h2 class="section-title">News &amp; Updates</h2>
            </div>
            <a href="<?= base_url('/blog') ?>" class="btn-secondary">View All Posts</a>
        </div>
        <div class="mt-12 grid md:grid-cols-3 gap-8">
            <?php foreach ($posts as $post): ?>
                <a href="<?= base_url('/blog/' . $post['slug']) ?>" class="card overflow-hidden group reveal">
                    <?php if (!empty($post['featured_image'])): ?>
                        <img src="<?= upload_url($post['featured_image']) ?>" alt="<?= e($post['title']) ?>" class="h-48 w-full object-cover">
                    <?php else: ?>
                        <div class="h-48 w-full bg-brand-gradient"></div>
                    <?php endif; ?>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-wide text-brand-orange-600 font-semibold"><?= e($post['category_name'] ?? 'Update') ?></p>
                        <h3 class="mt-2 font-display text-lg font-semibold text-brand-blue-900 group-hover:text-brand-orange-600 transition-colors"><?= e($post['title']) ?></h3>
                        <p class="mt-2 text-sm text-brand-neutral-600 line-clamp-2"><?= e($post['excerpt'] ?? '') ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container-custom">
        <div class="rounded-3xl bg-brand-gradient text-white px-8 py-16 sm:px-16 text-center reveal">
            <h2 class="font-display text-3xl sm:text-4xl font-semibold"><?= e($blocks['get_involved_cta_heading'] ?? 'Your Involvement Matters') ?></h2>
            <p class="mt-4 max-w-xl mx-auto text-brand-blue-100"><?= e($blocks['get_involved_cta_text'] ?? '') ?></p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="<?= base_url('/get-involved') ?>" class="btn-primary">Volunteer or Partner</a>
                <a href="<?= base_url('/donate') ?>" class="btn-ghost-light">Donate Now</a>
            </div>
        </div>
    </div>
</section>
