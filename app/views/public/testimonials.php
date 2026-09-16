<?php
/** @var array $testimonials */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-16 sm:py-20 min-h-[280px] sm:min-h-[320px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Voices</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Testimonials</h1>
    </div>
</section>

<section class="section">
    <div class="container-custom">
        <?php if (empty($testimonials)): ?>
            <div class="text-center text-brand-neutral-500 py-16">
                <p>Stories from our community will be featured here soon.</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-3 gap-8">
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
        <?php endif; ?>
    </div>
</section>
