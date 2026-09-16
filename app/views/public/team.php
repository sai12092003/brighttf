<?php
/** @var array $team */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-16 sm:py-20 min-h-[280px] sm:min-h-[320px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Our People</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Meet the Team</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">The people behind Bright Today Foundation's mission.</p>
    </div>
</section>

<section class="section">
    <div class="container-custom grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($team as $member): ?>
            <div class="card p-8 text-center reveal">
                <?php if (!empty($member['photo_path'])): ?>
                    <img src="<?= upload_url($member['photo_path']) ?>" alt="<?= e($member['name']) ?>" class="h-24 w-24 rounded-full object-cover mx-auto">
                <?php else: ?>
                    <div class="h-24 w-24 rounded-full bg-sunrise-gradient flex items-center justify-center text-white font-display text-2xl font-semibold mx-auto"><?= e(substr($member['name'], 0, 1)) ?></div>
                <?php endif; ?>
                <h3 class="mt-5 font-display text-lg font-semibold text-brand-blue-900"><?= e($member['name']) ?></h3>
                <p class="text-sm text-brand-orange-600 font-medium"><?= e($member['role_title']) ?></p>
                <?php if (!empty($member['bio'])): ?>
                    <p class="mt-3 text-sm text-brand-neutral-600 line-clamp-4"><?= e($member['bio']) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
