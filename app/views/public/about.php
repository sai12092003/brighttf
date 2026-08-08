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
        <p class="eyebrow !text-brand-orange-300">About Us</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold"><?= e($blocks['about_heading'] ?? 'About Bright Today Foundation') ?></h1>
        <p class="mt-6 max-w-2xl mx-auto text-brand-blue-100 text-lg leading-relaxed"><?= e($blocks['about_body'] ?? '') ?></p>
    </div>
</section>

<section class="section">
    <div class="container-custom grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <p class="eyebrow">Our Vision</p>
            <h2 class="section-title"><?= e($blocks['vision_heading'] ?? 'Our Vision') ?></h2>
            <p class="section-lede"><?= e($blocks['vision_text'] ?? '') ?></p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 reveal">
            <div class="card p-6 text-center">
                <p class="font-display text-lg font-semibold text-brand-blue-900">Education</p>
            </div>
            <div class="card p-6 text-center">
                <p class="font-display text-lg font-semibold text-brand-blue-900">Environment</p>
            </div>
            <div class="card p-6 text-center">
                <p class="font-display text-lg font-semibold text-brand-blue-900">Women &amp; Child Welfare</p>
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
        <div class="mt-14 card p-8 sm:p-10 reveal">
            <div class="flex items-center gap-4">
                <?php if (!empty($founder['photo_path'])): ?>
                    <img src="<?= upload_url($founder['photo_path']) ?>" alt="<?= e($founder['name']) ?>" class="h-16 w-16 rounded-full object-cover">
                <?php else: ?>
                    <div class="h-16 w-16 rounded-full bg-sunrise-gradient flex items-center justify-center text-white font-display text-xl font-semibold"><?= e(substr($founder['name'], 0, 1)) ?></div>
                <?php endif; ?>
                <div>
                    <p class="font-display text-lg font-semibold text-brand-blue-900"><?= e($founder['name']) ?></p>
                    <p class="text-sm text-brand-orange-600 font-medium"><?= e($founder['role_title']) ?></p>
                </div>
            </div>
            <p class="mt-6 text-brand-neutral-700 leading-relaxed"><?= e($founder['bio']) ?></p>
            <?php if (!empty($founder['quote'])): ?>
                <blockquote class="mt-6 border-l-4 border-brand-orange-400 pl-5 italic text-brand-blue-900">&ldquo;<?= e($founder['quote']) ?>&rdquo;</blockquote>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($cofounder): ?>
        <div class="mt-8 card p-8 sm:p-10 reveal">
            <div class="flex items-center gap-4">
                <?php if (!empty($cofounder['photo_path'])): ?>
                    <img src="<?= upload_url($cofounder['photo_path']) ?>" alt="<?= e($cofounder['name']) ?>" class="h-16 w-16 rounded-full object-cover">
                <?php else: ?>
                    <div class="h-16 w-16 rounded-full bg-brand-gradient flex items-center justify-center text-white font-display text-xl font-semibold"><?= e(substr($cofounder['name'], 0, 1)) ?></div>
                <?php endif; ?>
                <div>
                    <p class="font-display text-lg font-semibold text-brand-blue-900"><?= e($cofounder['name']) ?></p>
                    <p class="text-sm text-brand-orange-600 font-medium"><?= e($cofounder['role_title']) ?></p>
                </div>
            </div>
            <p class="mt-6 text-brand-neutral-700 leading-relaxed"><?= e($cofounder['bio']) ?></p>
            <?php if (!empty($cofounder['quote'])): ?>
                <blockquote class="mt-6 border-l-4 border-brand-blue-400 pl-5 italic text-brand-blue-900">&ldquo;<?= e($cofounder['quote']) ?>&rdquo;</blockquote>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($blocks['registered_office_note'])): ?>
            <p class="mt-10 text-center text-sm text-brand-neutral-500"><?= e($blocks['registered_office_note']) ?></p>
        <?php endif; ?>
    </div>
</section>
