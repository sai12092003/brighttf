<?php
/** @var array $documents */
use App\Models\SiteSetting;
$settings = SiteSetting::all();
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-16 sm:py-20 min-h-[280px] sm:min-h-[320px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Accountability</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Transparency &amp; Legal</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">Bright Today Foundation operates as a registered charitable trust in India. Our registration details and certificates are public.</p>
    </div>
</section>

<section class="section">
    <div class="container-custom max-w-3xl">
        <div class="card p-8 sm:p-10 reveal">
            <h2 class="font-display text-xl font-semibold text-brand-blue-900">Registration Details</h2>
            <dl class="mt-6 divide-y divide-brand-neutral-200 text-sm">
                <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">PAN</dt><dd class="font-medium text-brand-blue-900"><?= e($settings['pan_number'] ?? '') ?></dd></div>
                <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">12A Registration No.</dt><dd class="font-medium text-brand-blue-900"><?= e($settings['reg_12a_number'] ?? '') ?></dd></div>
                <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">12A Validity</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['reg_12a_validity'] ?? '') ?></dd></div>
                <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">80G Registration No.</dt><dd class="font-medium text-brand-blue-900"><?= e($settings['reg_80g_number'] ?? '') ?></dd></div>
                <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">80G Validity</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['reg_80g_validity'] ?? '') ?></dd></div>
                <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">Registered Office</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['registered_address_trust_deed'] ?? '') ?></dd></div>
            </dl>
        </div>

        <div class="mt-10 reveal">
            <h2 class="font-display text-xl font-semibold text-brand-blue-900 mb-5">Certificates &amp; Documents</h2>
            <div class="grid sm:grid-cols-2 gap-5">
                <?php foreach ($documents as $doc): ?>
                    <a href="<?= upload_url($doc['file_path']) ?>" target="_blank" rel="noopener" class="card p-6 flex items-center gap-4 group">
                        <span class="h-12 w-12 rounded-xl bg-brand-orange-50 flex items-center justify-center text-brand-orange-600 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        </span>
                        <span>
                            <span class="block font-semibold text-brand-blue-900 group-hover:text-brand-orange-600 transition-colors"><?= e($doc['title']) ?></span>
                            <span class="block text-xs text-brand-neutral-500 mt-0.5">View / Download PDF</span>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
