<?php
use App\Core\Csrf;
use App\Models\SiteSetting;

$settings = SiteSetting::all();
$success = flash_success();
$error = flash_error();
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20 text-center">
        <p class="eyebrow !text-brand-orange-300">Get In Touch</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Contact Us</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">Questions, ideas, or want to collaborate? We'd love to hear from you.</p>
    </div>
</section>

<section class="section">
    <div class="container-custom grid lg:grid-cols-5 gap-10">
        <div class="lg:col-span-2 reveal space-y-6">
            <div class="card p-6">
                <p class="text-xs uppercase tracking-wide text-brand-orange-600 font-semibold">Office Address</p>
                <p class="mt-2 text-brand-blue-900"><?= e($settings['office_address_public'] ?? '') ?></p>
            </div>
            <div class="card p-6">
                <p class="text-xs uppercase tracking-wide text-brand-orange-600 font-semibold">Phone</p>
                <p class="mt-2 text-brand-blue-900">
                    <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone_1'] ?? '')) ?>" class="hover:text-brand-orange-600"><?= e($settings['contact_phone_1'] ?? '') ?></a>
                    <?php if (!empty($settings['contact_phone_2'])): ?>
                        <br><a href="tel:<?= e(preg_replace('/\s+/', '', $settings['contact_phone_2'])) ?>" class="hover:text-brand-orange-600"><?= e($settings['contact_phone_2']) ?></a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="card p-6">
                <p class="text-xs uppercase tracking-wide text-brand-orange-600 font-semibold">Email</p>
                <p class="mt-2 text-brand-blue-900"><a href="mailto:<?= e($settings['contact_email'] ?? '') ?>" class="hover:text-brand-orange-600"><?= e($settings['contact_email'] ?? '') ?></a></p>
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
                            <input type="tel" name="phone" inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" title="Enter a valid 10-digit mobile number" placeholder="10-digit mobile number" class="form-input" value="<?= e(old('phone')) ?>">
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
