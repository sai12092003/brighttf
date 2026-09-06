<?php
/** @var array $blocks */
use App\Core\Csrf;

$success = flash_success();
$error = flash_error();
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20 text-center">
        <p class="eyebrow !text-brand-orange-300">Join Us</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold"><?= e($blocks['heading'] ?? 'Get Involved') ?></h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg"><?= e($blocks['intro_text'] ?? '') ?></p>
    </div>
</section>

<section class="section">
    <div class="container-custom">
        <?php if ($success): ?>
            <div class="max-w-3xl mx-auto mb-10 rounded-2xl bg-brand-green-50 border border-brand-green-200 text-brand-green-800 px-6 py-4 text-center"><?= e($success) ?></div>
        <?php elseif ($error): ?>
            <div class="max-w-3xl mx-auto mb-10 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-6 py-4 text-center"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-2 gap-10">
            <div class="card p-8 sm:p-10 reveal">
                <h2 class="font-display text-2xl font-semibold text-brand-blue-900"><?= e($blocks['volunteer_heading'] ?? 'Volunteer With Us') ?></h2>
                <p class="mt-2 text-brand-neutral-600"><?= e($blocks['volunteer_intro'] ?? '') ?></p>
                <form method="POST" action="<?= base_url('/get-involved') ?>" class="mt-6 space-y-4">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="submission_type" value="volunteer">
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" required class="form-input" value="<?= e(old('name')) ?>">
                        <?php if (errors('name')): ?><p class="form-error"><?= e(errors('name')) ?></p><?php endif; ?>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" required class="form-input" value="<?= e(old('email')) ?>">
                            <?php if (errors('email')): ?><p class="form-error"><?= e(errors('email')) ?></p><?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" required inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" title="Enter a valid 10-digit mobile number" placeholder="10-digit mobile number" class="form-input" value="<?= e(old('phone')) ?>">
                            <?php if (errors('phone')): ?><p class="form-error"><?= e(errors('phone')) ?></p><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Area of Interest</label>
                        <select name="area_of_interest" class="form-input">
                            <option value="Quality Education">Quality Education</option>
                            <option value="Environmental Sustainability">Environmental Sustainability</option>
                            <option value="Women & Child Welfare">Women &amp; Child Welfare</option>
                            <option value="General">General / Not Sure Yet</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Message (optional)</label>
                        <textarea name="message" rows="3" class="form-input"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Submit as Volunteer</button>
                </form>
            </div>

            <div class="card p-8 sm:p-10 reveal">
                <h2 class="font-display text-2xl font-semibold text-brand-blue-900"><?= e($blocks['partner_heading'] ?? 'Partner With Us') ?></h2>
                <p class="mt-2 text-brand-neutral-600"><?= e($blocks['partner_intro'] ?? '') ?></p>
                <form method="POST" action="<?= base_url('/get-involved') ?>" class="mt-6 space-y-4">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="submission_type" value="partner">
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div>
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="name" required class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Organization Name</label>
                        <input type="text" name="organization_name" required class="form-input">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" required class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" required inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" title="Enter a valid 10-digit mobile number" placeholder="10-digit mobile number" class="form-input" value="<?= e(old('phone')) ?>">
                            <?php if (errors('phone')): ?><p class="form-error"><?= e(errors('phone')) ?></p><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="3" class="form-input" placeholder="Tell us about your organization and how you'd like to partner."></textarea>
                    </div>
                    <button type="submit" class="btn-secondary w-full">Submit Partnership Inquiry</button>
                </form>
            </div>
        </div>
    </div>
</section>
