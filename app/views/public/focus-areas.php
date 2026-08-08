<?php
/** @var array $focusAreas */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20 text-center">
        <p class="eyebrow !text-brand-orange-300">What We Do</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Our Focus Areas</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">Three pillars guide everything we do: education, environment, and welfare.</p>
    </div>
</section>

<section class="section">
    <div class="container-custom grid md:grid-cols-3 gap-8">
        <?php foreach ($focusAreas as $i => $area): ?>
            <?php $colors = ['orange', 'green', 'blue']; $c = $colors[$i % 3]; ?>
            <div class="card p-8 reveal" style="transition-delay: <?= $i * 100 ?>ms">
                <span class="inline-flex h-14 w-14 rounded-2xl bg-brand-<?= $c ?>-50 items-center justify-center text-brand-<?= $c ?>-600 mb-6 font-display text-xl"><?= $i + 1 ?></span>
                <h2 class="font-display text-2xl font-semibold text-brand-blue-900"><?= e($area['title']) ?></h2>
                <p class="mt-3 text-sm font-semibold text-brand-orange-600 uppercase tracking-wide">Goal</p>
                <p class="text-brand-neutral-700"><?= e($area['goal_text']) ?></p>
                <p class="mt-4 text-sm font-semibold text-brand-orange-600 uppercase tracking-wide">Action</p>
                <p class="text-brand-neutral-700"><?= e($area['action_text']) ?></p>
                <a href="<?= base_url('/focus-areas/' . $area['slug']) ?>" class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-blue-800 hover:text-brand-orange-600">
                    Read more
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
