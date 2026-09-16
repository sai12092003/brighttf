<?php
/** @var array $area */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20 text-center">
        <p class="eyebrow !text-brand-orange-300">What We Do</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold"><?= e($area['title']) ?></h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg"><?= e($area['goal_text']) ?></p>
    </div>
</section>

<?php if (!empty($area['icon_path'])): ?>
    <div class="container-custom -mt-10">
        <img src="<?= upload_url($area['icon_path']) ?>" alt="<?= e($area['title']) ?>" class="w-full max-h-[420px] object-cover rounded-3xl shadow-soft-lg">
    </div>
<?php endif; ?>

<section class="section">
    <div class="container-custom max-w-3xl">
        <a href="<?= base_url('/focus-areas') ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-blue-800 hover:text-brand-orange-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" /></svg>
            All Focus Areas
        </a>

        <div class="mt-6 card p-8 sm:p-10 reveal">
            <p class="text-sm font-semibold text-brand-orange-600 uppercase tracking-wide">What We Do</p>
            <p class="mt-2 text-brand-neutral-700 leading-relaxed"><?= e($area['action_text']) ?></p>
            <?php if (!empty($area['long_description'])): ?>
                <hr class="my-6 border-brand-neutral-200">
                <p class="text-sm font-semibold text-brand-orange-600 uppercase tracking-wide">Our Approach</p>
                <p class="mt-2 text-brand-neutral-700 leading-relaxed"><?= e($area['long_description']) ?></p>
            <?php endif; ?>
        </div>

        <div class="mt-10 text-center">
            <a href="<?= base_url('/get-involved') ?>" class="btn-primary">Support This Program</a>
        </div>
    </div>
</section>
