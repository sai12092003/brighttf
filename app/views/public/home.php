<?php
/** @var array $blocks */
/** @var array $focusAreas */
/** @var array $stats */
/** @var array $testimonials */
/** @var array $posts */
?>

<section class="relative overflow-hidden bg-brand-neutral-50">
    <div class="absolute inset-y-0 left-0 w-16 sm:w-24 lg:w-40 pointer-events-none"
        style="background-image: url('<?= asset('img/hero-support.jpg') ?>'); background-size: cover; background-position: left center; filter: blur(1px); opacity: 0.3; -webkit-mask-image: linear-gradient(to right, black 15%, transparent 88%); mask-image: linear-gradient(to right, black 15%, transparent 88%);"></div>
    <div class="absolute inset-y-0 right-0 w-16 sm:w-24 lg:w-40 pointer-events-none"
        style="background-image: url('<?= asset('img/hero-support.jpg') ?>'); background-size: cover; background-position: right center; filter: blur(1px); opacity: 0.3; -webkit-mask-image: linear-gradient(to left, black 15%, transparent 88%); mask-image: linear-gradient(to left, black 15%, transparent 88%);"></div>
    <div class="container-custom relative py-20 sm:py-24 lg:py-28">
        <h1 class="text-center font-display font-black leading-[0.85] tracking-tight bg-clip-text text-transparent bg-cover reveal"
            style="font-size: clamp(2.75rem, 11vw, 9rem); background-image: url('<?= asset('img/hero-support.jpg') ?>'); background-position: center 35%;">
            <span class="block">Bright Today</span>
            <span class="block">Foundation</span>
        </h1>
        <div class="mt-10 max-w-xl mx-auto text-center reveal">
            <p class="text-lg text-brand-neutral-600 leading-relaxed">
                <?= e($blocks['hero_subtitle'] ?? '') ?>
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4">
                <a href="<?= base_url($blocks['hero_cta_link'] ?? '/donate') ?>" class="btn-primary">
                    <?= e($blocks['hero_cta_text'] ?? 'Donate Now') ?>
                </a>
                <a href="<?= base_url($blocks['hero_secondary_cta_link'] ?? '/get-involved') ?>" class="btn-secondary">
                    <?= e($blocks['hero_secondary_cta_text'] ?? 'Get Involved') ?>
                </a>
            </div>
            <div class="mt-6 flex justify-center reveal">
                <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-brand-neutral-500">
                    <svg class="h-4 w-4 text-brand-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    12A &amp; 80G Registered Trust
                </span>
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
            <a href="<?= base_url('/about') ?>" class="group inline-flex items-center gap-2 mt-8 rounded-full border border-brand-blue-200 bg-white px-6 py-3 text-sm sm:text-base font-semibold text-brand-blue-800 transition-colors duration-300 hover:border-transparent hover:bg-brand-orange-500 hover:text-white">
                Read Our Full Story
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-5 reveal">
            <div class="rounded-md bg-brand-green-500 p-7 min-h-[240px] flex flex-col items-start gap-3 shadow-soft hover:shadow-soft-lg transition-shadow">
                <span class="h-11 w-11 rounded-md bg-white/15 flex items-center justify-center text-white font-display text-xl">1</span>
                <p class="mt-1 font-semibold text-white">Community-Led</p>
                <p class="text-sm text-white/85">Programs shaped with, not just for, the communities we serve.</p>
            </div>
            <div class="rounded-md bg-brand-blue-700 p-7 min-h-[240px] flex flex-col items-start gap-3 shadow-soft hover:shadow-soft-lg transition-shadow">
                <span class="h-11 w-11 rounded-md bg-white/15 flex items-center justify-center text-white font-display text-xl">2</span>
                <p class="mt-1 font-semibold text-white">Youth-Powered</p>
                <p class="text-sm text-white/85">A volunteering movement driven by India's younger generation.</p>
            </div>
            <div class="rounded-md bg-brand-orange-500 p-7 min-h-[240px] flex flex-col items-start gap-3 shadow-soft hover:shadow-soft-lg transition-shadow">
                <span class="h-11 w-11 rounded-md bg-white/15 flex items-center justify-center text-white font-display text-xl">3</span>
                <p class="mt-1 font-semibold text-white">100% Transparent</p>
                <p class="text-sm text-white/85">12A &amp; 80G registered, with public registration documents.</p>
            </div>
        </div>
    </div>
</section>

<section class="section pb-8 sm:pb-10 lg:pb-12 bg-brand-neutral-50">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto text-center reveal">
            <p class="eyebrow">What We Do</p>
            <h2 class="section-title"><?= e($blocks['focus_areas_heading'] ?? 'Our Core Focus Areas') ?></h2>
        </div>
        <?php
            $focusColors = [
                'orange' => 'bg-brand-orange-500',
                'green'  => 'bg-brand-green-500',
                'blue'   => 'bg-brand-blue-700',
            ];
        ?>
        <div class="mt-14 grid md:grid-cols-3 gap-8">
            <?php foreach ($focusAreas as $i => $area): ?>
                <?php $colors = ['orange', 'green', 'blue']; $c = $colors[$i % 3]; ?>
                <a href="<?= base_url('/focus-areas/' . $area['slug']) ?>" class="group reveal block rounded-md overflow-hidden shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all" style="transition-delay: <?= $i * 100 ?>ms">
                    <?php if (!empty($area['icon_path'])): ?>
                        <img src="<?= upload_url($area['icon_path']) ?>" alt="<?= e($area['title']) ?>" class="h-48 w-full object-cover">
                    <?php else: ?>
                        <div class="h-48 w-full <?= $focusColors[$c] ?>"></div>
                    <?php endif; ?>
                    <div class="<?= $focusColors[$c] ?> p-8">
                        <h3 class="font-display text-xl font-semibold text-white"><?= e($area['title']) ?></h3>
                        <p class="mt-3 text-sm text-white/85 leading-relaxed"><?= e($area['goal_text']) ?></p>
                        <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-white">
                            Learn more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

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

<?php if (!empty($testimonials)): ?>
<?php
    $testimonialCount = count($testimonials);
    // Duplicating the list is what makes the CSS marquee loop seamlessly
    // (translateX(-50%) needs a doubled track) — but with too few cards
    // that just reads as an obvious repeat, so only loop/animate once
    // there are enough to fill the view before the seam is visible.
    $testimonialShouldLoop = $testimonialCount >= 4;
    $testimonialLoop = $testimonialShouldLoop ? array_merge($testimonials, $testimonials) : $testimonials;
    $marqueeDuration = max($testimonialCount * 10, 24);
    $testimonialColors = [
        ['bg' => 'bg-brand-orange-500', 'fill' => 'text-brand-orange-600', 'soft' => 'bg-brand-orange-50'],
        ['bg' => 'bg-brand-green-500', 'fill' => 'text-brand-green-600', 'soft' => 'bg-brand-green-50'],
        ['bg' => 'bg-brand-blue-600', 'fill' => 'text-brand-blue-600', 'soft' => 'bg-brand-blue-50'],
    ];
?>
<section class="section pt-8 sm:pt-10 lg:pt-12 overflow-hidden bg-brand-neutral-50">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto text-center reveal">
            <p class="eyebrow">Voices</p>
            <h2 class="section-title">Stories From Our Community</h2>
        </div>
    </div>
    <div class="mt-14 reveal">
        <div class="flex <?= $testimonialShouldLoop ? 'w-max' : 'flex-wrap justify-center' ?> gap-7 px-6" data-testimonial-track<?= $testimonialShouldLoop ? ' style="animation: marquee ' . (int) $marqueeDuration . 's linear infinite;"' : '' ?>>
            <?php foreach ($testimonialLoop as $idx => $t): ?>
                <?php $c = $testimonialColors[$idx % $testimonialCount % 3]; ?>
                <button type="button"
                    class="group w-[300px] sm:w-[360px] flex-shrink-0 rounded-3xl bg-white shadow-soft hover:shadow-soft-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden text-left"
                    data-testimonial-open
                    data-quote="<?= e($t['quote']) ?>"
                    data-name="<?= e($t['name']) ?>"
                    data-role="<?= e($t['role_or_location'] ?? '') ?>"
                    data-photo="<?= !empty($t['photo_path']) ? e(upload_url($t['photo_path'])) : '' ?>"
                    <?= $idx >= $testimonialCount ? ' aria-hidden="true" tabindex="-1"' : '' ?>>
                    <div class="p-7 pb-5">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl <?= $c['soft'] ?> mb-5">
                            <svg class="h-6 w-6 <?= $c['fill'] ?>" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zm14 0c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/></svg>
                        </span>
                        <p class="text-brand-neutral-600 leading-relaxed line-clamp-5 min-h-[130px]">&ldquo;<?= e($t['quote']) ?>&rdquo;</p>
                    </div>
                    <div class="<?= $c['bg'] ?> px-7 py-5 flex items-center gap-4">
                        <?php if (!empty($t['photo_path'])): ?>
                            <img src="<?= upload_url($t['photo_path']) ?>" alt="<?= e($t['name']) ?>" data-lightbox-src="<?= upload_url($t['photo_path']) ?>" class="h-14 w-14 rounded-full object-cover border-2 border-white/80 flex-shrink-0 cursor-zoom-in hover:scale-105 transition-transform">
                        <?php else: ?>
                            <span class="h-14 w-14 rounded-full bg-white/20 border-2 border-white/80 flex-shrink-0"></span>
                        <?php endif; ?>
                        <div class="min-w-0">
                            <p class="font-semibold text-white truncate"><?= e($t['name']) ?></p>
                            <?php if (!empty($t['role_or_location'])): ?>
                                <p class="text-sm text-white/80 truncate"><?= e($t['role_or_location']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div id="testimonial-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="relative w-full max-w-lg max-h-[85vh] overflow-y-auto rounded-3xl bg-white p-8 sm:p-10 shadow-soft-lg">
        <button type="button" id="testimonial-modal-close" class="absolute right-5 top-5 text-brand-neutral-400 hover:text-brand-neutral-700" aria-label="Close">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <img id="testimonial-modal-photo" src="" alt="" class="mx-auto h-20 w-20 rounded-full object-cover border-4 border-white shadow-soft-lg hidden cursor-zoom-in hover:scale-105 transition-transform">
        <svg class="h-9 w-9 text-brand-orange-500 mx-auto mt-4 mb-5" fill="currentColor" viewBox="0 0 32 32"><path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H8c0-1.1.9-2 2-2V8zm14 0c-3.3 0-6 2.7-6 6v10h10V14h-6c0-1.1.9-2 2-2V8z"/></svg>
        <p id="testimonial-modal-quote" class="text-brand-neutral-700 leading-relaxed text-center text-lg"></p>
        <p id="testimonial-modal-name" class="mt-6 text-center font-semibold text-brand-blue-900"></p>
        <p id="testimonial-modal-role" class="text-center text-sm text-brand-neutral-500"></p>
    </div>
</div>
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
