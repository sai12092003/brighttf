<?php
/** @var array $settings */
$phone = $settings['contact_phone_1'] ?? '+91 84288 28898';
$email = $settings['contact_email'] ?? 'brighttfhead@gmail.com';
$telHref = 'tel:' . preg_replace('/\s+/', '', $phone);
?>
<div id="enquire-widget" class="fixed right-0 top-1/2 -translate-y-1/2 z-40 flex flex-row-reverse items-center">
    <button type="button" id="enquire-tab" aria-expanded="false" aria-controls="enquire-panel"
            class="bg-brand-gradient text-white font-semibold uppercase tracking-widest text-sm py-5 px-2 rounded-l-xl shadow-soft-lg [writing-mode:vertical-rl] hover:px-2.5 transition-all duration-200">
        Enquire
    </button>

    <div id="enquire-panel" class="hidden flex-col gap-4 bg-white rounded-l-2xl shadow-soft-lg border border-r-0 border-brand-neutral-200 p-5 w-64">
        <div class="flex items-center justify-between">
            <p class="font-display font-semibold text-brand-blue-900">Get in Touch</p>
            <button type="button" id="enquire-close" aria-label="Close" class="text-brand-neutral-500 hover:text-brand-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <a href="<?= e($telHref) ?>" class="flex items-center gap-3 text-sm font-medium text-brand-blue-900 hover:text-brand-orange-600">
            <span class="h-9 w-9 shrink-0 rounded-full bg-brand-orange-50 text-brand-orange-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372a1.5 1.5 0 00-1.006-1.415l-3.44-1.146a1.5 1.5 0 00-1.564.386l-.663.663a1.125 1.125 0 01-1.404.153 12.075 12.075 0 01-5.646-5.646 1.125 1.125 0 01.153-1.404l.663-.663a1.5 1.5 0 00.386-1.564l-1.146-3.44a1.5 1.5 0 00-1.415-1.006H4.5A2.25 2.25 0 002.25 6z" />
                </svg>
            </span>
            <?= e($phone) ?>
        </a>

        <a href="mailto:<?= e($email) ?>" class="flex items-center gap-3 text-sm font-medium text-brand-blue-900 hover:text-brand-orange-600 break-all">
            <span class="h-9 w-9 shrink-0 rounded-full bg-brand-blue-50 text-brand-blue-700 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
            </span>
            <?= e($email) ?>
        </a>
    </div>
</div>
