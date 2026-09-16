<?php
use App\Core\Csrf;
use App\Models\SiteSetting;

$settings = SiteSetting::all();
$success = flash_success();
$error = flash_error();
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-8 sm:py-10 min-h-[170px] sm:min-h-[200px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Get In Touch</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Contact Us</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">Questions, ideas, or want to collaborate? We'd love to hear from you.</p>
    </div>
</section>

<section class="section pt-8 sm:pt-10">
    <div class="container-custom grid lg:grid-cols-5 gap-10">
        <div class="lg:col-span-2 reveal space-y-6">
            <div class="card p-6 flex items-start gap-4">
                <span class="inline-flex h-12 w-12 shrink-0 rounded-2xl bg-brand-orange-50 text-brand-orange-600 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-orange-600 font-semibold">Office Address</p>
                    <p class="mt-2 text-brand-blue-900"><?= e($settings['office_address_public'] ?? '') ?></p>
                </div>
            </div>
            <div class="card p-6 flex items-start gap-4">
                <span class="inline-flex h-12 w-12 shrink-0 rounded-2xl bg-brand-green-50 text-brand-green-600 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a11.25 11.25 0 01-5.223-5.223l1.293-.97a1.125 1.125 0 00.417-1.173L8.963 3.102a1.125 1.125 0 00-1.091-.852H6.5A2.25 2.25 0 004.25 4.5v.75z" /></svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-green-600 font-semibold">Phone</p>
                    <p class="mt-2 text-brand-blue-900">
                        <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone_1'] ?? '')) ?>" class="hover:text-brand-orange-600"><?= e($settings['contact_phone_1'] ?? '') ?></a>
                        <?php if (!empty($settings['contact_phone_2'])): ?>
                            <br><a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone_2'])) ?>" class="hover:text-brand-orange-600"><?= e($settings['contact_phone_2']) ?></a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="card p-6 flex items-start gap-4">
                <span class="inline-flex h-12 w-12 shrink-0 rounded-2xl bg-brand-blue-50 text-brand-blue-700 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-blue-700 font-semibold">Email</p>
                    <p class="mt-2 text-brand-blue-900"><a href="mailto:<?= e($settings['contact_email'] ?? '') ?>" class="hover:text-brand-orange-600"><?= e($settings['contact_email'] ?? '') ?></a></p>
                </div>
            </div>
            <?php if (!empty($settings['google_maps_embed_url'])): ?>
                <div class="rounded-2xl overflow-hidden shadow-soft">
                    <iframe src="<?= e($settings['google_maps_embed_url']) ?>" class="w-full h-64 border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-3 reveal">
            <div class="card p-8 sm:p-10">
                <?php if ($success): ?>
                    <div class="mb-6 rounded-2xl bg-brand-green-50 border border-brand-green-200 text-brand-green-800 px-5 py-4"><?= e($success) ?></div>
                <?php elseif ($error): ?>
                    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4"><?= e($error) ?></div>
                <?php endif; ?>
                <form method="POST" action="<?= base_url('/contact') ?>" class="space-y-4">
                    <?= Csrf::field() ?>
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" required class="form-input" value="<?= e(old('name')) ?>">
                            <?php if (errors('name')): ?><p class="form-error"><?= e(errors('name')) ?></p><?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" required class="form-input" value="<?= e(old('email')) ?>">
                            <?php if (errors('email')): ?><p class="form-error"><?= e(errors('email')) ?></p><?php endif; ?>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Phone (optional)</label>
                            <input type="tel" name="phone" inputmode="numeric" pattern="[0-9]{10,12}" maxlength="12" title="Enter a 10 to 12 digit phone number (numbers only)" placeholder="10 to 12 digit phone number" class="form-input" value="<?= e(old('phone')) ?>">
                            <?php if (errors('phone')): ?><p class="form-error"><?= e(errors('phone')) ?></p><?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-input" value="<?= e(old('subject')) ?>">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="5" required class="form-input"><?= e(old('message')) ?></textarea>
                        <?php if (errors('message')): ?><p class="form-error"><?= e(errors('message')) ?></p><?php endif; ?>
                    </div>
                    <button type="submit" class="btn-primary w-full sm:w-auto">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
