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
