<?php
/** @var array $blocks */
/** @var array $team */
$founder = null;
$cofounder = null;
foreach ($team as $member) {
    if ($member['role_title'] === 'Founder') $founder = $member;
    if ($member['role_title'] === 'Co-Founder') $cofounder = $member;
}
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20 sm:py-24 text-center">
        <p class="eyebrow !text-brand-orange-300 reveal">About Us</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold reveal"><?= e($blocks['about_heading'] ?? 'About Bright Today Foundation') ?></h1>
        <p class="mt-6 max-w-2xl mx-auto text-brand-blue-100 text-lg leading-relaxed reveal"><?= e($blocks['about_body'] ?? '') ?></p>
    </div>
</section>

<section class="section">
    <div class="container-custom grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <p class="eyebrow">Our Vision</p>
            <h2 class="section-title"><?= e($blocks['vision_heading'] ?? 'Our Vision') ?></h2>
            <p class="section-lede"><?= e($blocks['vision_text'] ?? '') ?></p>
        </div>
        <div class="space-y-4 reveal">
            <div class="card p-5 sm:p-6 flex items-start gap-4 transition-transform duration-300 hover:-translate-y-0.5">
                <span class="h-12 w-12 shrink-0 rounded-xl bg-brand-orange-50 text-brand-orange-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </span>
                <div>
                    <p class="font-display text-lg font-semibold text-brand-blue-900">Education</p>
                    <p class="mt-1 text-sm text-brand-neutral-600 leading-relaxed">Quality learning within reach of every child, without barriers.</p>
                </div>
            </div>
            <div class="card p-5 sm:p-6 flex items-start gap-4 transition-transform duration-300 hover:-translate-y-0.5">
                <span class="h-12 w-12 shrink-0 rounded-xl bg-brand-green-50 text-brand-green-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </span>
                <div>
                    <p class="font-display text-lg font-semibold text-brand-blue-900">Environment</p>
                    <p class="mt-1 text-sm text-brand-neutral-600 leading-relaxed">Protecting the natural world our communities depend on.</p>
                </div>
            </div>
            <div class="card p-5 sm:p-6 flex items-start gap-4 transition-transform duration-300 hover:-translate-y-0.5">
                <span class="h-12 w-12 shrink-0 rounded-xl bg-brand-blue-50 text-brand-blue-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </span>
                <div>
                    <p class="font-display text-lg font-semibold text-brand-blue-900">Women &amp; Child Welfare</p>
                    <p class="mt-1 text-sm text-brand-neutral-600 leading-relaxed">Dignity, safety, and equal opportunity for every woman and child.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-brand-neutral-50">
    <div class="container-custom max-w-3xl">
        <div class="text-center reveal">
            <p class="eyebrow">Our Journey</p>
            <h2 class="section-title"><?= e($blocks['origin_heading'] ?? 'Our Origin Story: Built on Purpose') ?></h2>
            <p class="section-lede mx-auto"><?= e($blocks['origin_intro'] ?? '') ?></p>
        </div>

        <?php if ($founder): ?>
        <div class="mt-8 card p-5 sm:p-7 reveal reveal-left">
            <div class="grid sm:grid-cols-12 gap-5 sm:gap-6 items-center">
                <div class="sm:col-span-4 relative max-w-[220px] sm:max-w-none mx-auto sm:mx-0">
                    <div class="absolute -inset-4 rounded-[1.75rem] bg-sunrise-gradient opacity-10 blur-xl" aria-hidden="true"></div>
                    <div class="relative aspect-[4/5] rounded-2xl overflow-hidden shadow-soft bg-brand-neutral-100">
                        <?php if (!empty($founder['photo_path'])): ?>
                            <img src="<?= upload_url($founder['photo_path']) ?>" alt="<?= e($founder['name']) ?>" class="h-full w-full object-cover transition-transform duration-700 hover:scale-105">
                        <?php else: ?>
                            <div class="h-full w-full bg-sunrise-gradient flex items-center justify-center">
                                <span class="font-display text-5xl font-semibold text-white/90"><?= e(substr($founder['name'], 0, 1)) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sm:col-span-8">
                    <span class="badge-trust !bg-brand-orange-50 !text-brand-orange-700 !border-brand-orange-200"><?= e($founder['role_title']) ?></span>
                    <h3 class="mt-3 font-display text-xl sm:text-2xl font-semibold text-brand-blue-900"><?= e($founder['name']) ?></h3>
                    <p class="mt-3 text-sm text-brand-neutral-700 leading-relaxed"><?= e($founder['bio']) ?></p>
                    <?php if (!empty($founder['quote'])): ?>
                        <div class="mt-4 relative pl-6">
                            <span class="absolute left-0 -top-1 font-display text-4xl leading-none text-brand-orange-300 select-none" aria-hidden="true">&ldquo;</span>
                            <blockquote class="relative italic text-sm text-brand-blue-900 leading-relaxed"><?= e($founder['quote']) ?></blockquote>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($cofounder): ?>
        <div class="mt-6 card p-5 sm:p-7 reveal reveal-right">
            <div class="grid sm:grid-cols-12 gap-5 sm:gap-6 items-center">
                <div class="order-1 sm:order-2 sm:col-span-4 relative max-w-[220px] sm:max-w-none mx-auto sm:mx-0">
                    <div class="absolute -inset-4 rounded-[1.75rem] bg-brand-gradient opacity-10 blur-xl" aria-hidden="true"></div>
                    <div class="relative aspect-[4/5] rounded-2xl overflow-hidden shadow-soft bg-brand-neutral-100">
                        <?php if (!empty($cofounder['photo_path'])): ?>
                            <img src="<?= upload_url($cofounder['photo_path']) ?>" alt="<?= e($cofounder['name']) ?>" class="h-full w-full object-cover transition-transform duration-700 hover:scale-105">
                        <?php else: ?>
                            <div class="h-full w-full bg-brand-gradient flex items-center justify-center">
                                <span class="font-display text-5xl font-semibold text-white/90"><?= e(substr($cofounder['name'], 0, 1)) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="order-2 sm:order-1 sm:col-span-8">
                    <span class="badge-trust !bg-brand-blue-50 !text-brand-blue-700 !border-brand-blue-200"><?= e($cofounder['role_title']) ?></span>
                    <h3 class="mt-3 font-display text-xl sm:text-2xl font-semibold text-brand-blue-900"><?= e($cofounder['name']) ?></h3>
                    <p class="mt-3 text-sm text-brand-neutral-700 leading-relaxed"><?= e($cofounder['bio']) ?></p>
                    <?php if (!empty($cofounder['quote'])): ?>
                        <div class="mt-4 relative pl-6">
                            <span class="absolute left-0 -top-1 font-display text-4xl leading-none text-brand-blue-300 select-none" aria-hidden="true">&ldquo;</span>
                            <blockquote class="relative italic text-sm text-brand-blue-900 leading-relaxed"><?= e($cofounder['quote']) ?></blockquote>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($blocks['registered_office_note'])): ?>
            <p class="mt-10 text-center text-sm text-brand-neutral-500"><?= e($blocks['registered_office_note']) ?></p>
        <?php endif; ?>
    </div>
</section>
