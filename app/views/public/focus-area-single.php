<?php
/** @var array $area */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20">
        <a href="<?= base_url('/focus-areas') ?>" class="text-sm text-brand-blue-200 hover:text-white">&larr; All Focus Areas</a>
        <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold"><?= e($area['title']) ?></h1>
        <p class="mt-4 max-w-2xl text-lg text-brand-blue-100"><?= e($area['goal_text']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container-custom max-w-3xl">
        <div class="card p-8 sm:p-10 reveal">
            <h2 class="font-display text-xl font-semibold text-brand-blue-900">What We Do</h2>
            <p class="mt-3 text-brand-neutral-700 leading-relaxed"><?= e($area['action_text']) ?></p>
            <?php if (!empty($area['long_description'])): ?>
                <hr class="my-6 border-brand-neutral-200">
                <p class="text-brand-neutral-700 leading-relaxed"><?= e($area['long_description']) ?></p>
            <?php endif; ?>
        </div>
        <div class="mt-10 text-center">
            <a href="<?= base_url('/get-involved') ?>" class="btn-primary">Support This Program</a>
        </div>
    </div>
</section>
