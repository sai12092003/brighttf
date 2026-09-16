<?php
/** @var array $focusAreas */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-8 sm:py-10 min-h-[170px] sm:min-h-[200px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">What We Do</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Our Focus Areas</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">Three pillars guide everything we do: education, environment, and welfare.</p>
    </div>
</section>

<section class="section">
    <div class="container-custom">
        <?php
            $focusColors = [
                'orange' => 'bg-brand-orange-500',
                'green'  => 'bg-brand-green-500',
                'blue'   => 'bg-brand-blue-700',
            ];
        ?>
        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($focusAreas as $i => $area): ?>
                <?php $colors = ['orange', 'green', 'blue']; $c = $colors[$i % 3]; ?>
                <a href="<?= base_url('/focus-areas/' . $area['slug']) ?>" class="group reveal flex flex-col h-full rounded-md overflow-hidden shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all" style="transition-delay: <?= $i * 100 ?>ms">
                    <?php if (!empty($area['icon_path'])): ?>
                        <img src="<?= upload_url($area['icon_path']) ?>" alt="<?= e($area['title']) ?>" class="h-48 w-full object-cover shrink-0">
                    <?php else: ?>
                        <div class="h-48 w-full shrink-0 <?= $focusColors[$c] ?>"></div>
                    <?php endif; ?>
                    <div class="flex-1 <?= $focusColors[$c] ?> p-8">
                        <h2 class="font-display text-xl font-semibold text-white"><?= e($area['title']) ?></h2>
                        <p class="mt-3 font-display text-xs font-bold text-white uppercase tracking-wide">Goal</p>
                        <p class="mt-1 text-sm text-white/85 leading-relaxed"><?= e($area['goal_text']) ?></p>
                        <p class="mt-3 font-display text-xs font-bold text-white uppercase tracking-wide">Action</p>
                        <p class="mt-1 text-sm text-white/85 leading-relaxed"><?= e($area['action_text']) ?></p>
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
