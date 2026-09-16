<?php
/** @var array $faqs */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-16 sm:py-20 min-h-[280px] sm:min-h-[320px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Questions</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Frequently Asked Questions</h1>
    </div>
</section>

<section class="section">
    <div class="container-custom max-w-3xl divide-y divide-brand-neutral-200 rounded-3xl border border-brand-neutral-200 bg-white shadow-soft">
        <?php foreach ($faqs as $i => $faq): ?>
            <div>
                <button type="button" data-accordion-trigger aria-expanded="false" aria-controls="faq-panel-<?= $i ?>" class="w-full flex items-center justify-between gap-4 px-6 sm:px-8 py-5 text-left">
                    <span class="font-semibold text-brand-blue-900"><?= e($faq['question']) ?></span>
                    <svg data-accordion-icon class="h-5 w-5 shrink-0 text-brand-orange-500 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                </button>
                <div id="faq-panel-<?= $i ?>" class="hidden px-6 sm:px-8 pb-6 text-brand-neutral-600 leading-relaxed">
                    <?= e($faq['answer']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
