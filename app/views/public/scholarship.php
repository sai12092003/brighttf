<?php
/** @var array $scholarships */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-8 sm:py-10 min-h-[170px] sm:min-h-[200px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Scholarships</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Scholarship Applications</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">
            Bright Today Foundation — supporting students to reach their potential.
            Select the scholarship you wish to apply for.
        </p>
    </div>
</section>

<section class="section pt-10 sm:pt-12">
    <div class="container-custom">
        <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <?php foreach ($scholarships as $s): ?>
                <?php $isOpen = ($s['status'] ?? 'open') === 'open'; ?>
                <div class="card p-7 flex flex-col reveal <?= $isOpen ? '' : 'opacity-80' ?>">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-brand-orange-50 text-brand-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.42A12.08 12.08 0 0112 21a12.08 12.08 0 01-6.16-10.42L12 14z" />
                            </svg>
                        </span>
                        <?php if ($isOpen): ?>
                            <span class="inline-flex items-center rounded-full bg-brand-green-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-green-700">Open</span>
                        <?php else: ?>
                            <span class="inline-flex items-center rounded-full bg-brand-neutral-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-neutral-500">Closed</span>
                        <?php endif; ?>
                    </div>

                    <h2 class="mt-5 font-display text-2xl font-semibold text-brand-blue-900"><?= e($s['title']) ?></h2>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-brand-orange-600"><?= e($s['subtitle']) ?></p>
                    <p class="mt-3 text-brand-neutral-600 flex-1"><?= e($s['summary']) ?></p>

                    <div class="mt-6">
                        <?php if ($isOpen): ?>
                            <a href="<?= base_url('/scholarship/' . $s['slug']) ?>" class="btn-primary !py-2.5 !px-5 text-sm">
                                Apply Now &rarr;
                            </a>
                        <?php else: ?>
                            <span class="inline-flex items-center rounded-full bg-brand-neutral-100 px-5 py-2.5 text-sm font-semibold text-brand-neutral-400 cursor-not-allowed">
                                Applications Closed
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="mt-10 text-center text-sm text-brand-neutral-500">
            All applications are reviewed by our scholarship committee. For questions,
            <a href="<?= base_url('/contact') ?>" class="text-brand-blue-700 font-medium hover:underline">contact Bright Today Foundation</a>.
        </p>
    </div>
</section>
