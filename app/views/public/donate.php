<?php
/** @var array $blocks */
use App\Core\Csrf;
use App\Models\SiteSetting;

$settings = SiteSetting::all();
$success = flash_success();
$error = flash_error();
$hasBankDetails = !empty($settings['donation_bank_account_number']) || !empty($settings['donation_upi_id']);
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-16 sm:py-20 min-h-[280px] sm:min-h-[320px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Support Our Mission</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold"><?= e($blocks['heading'] ?? 'Support Our Work') ?></h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg"><?= e($blocks['intro_text'] ?? '') ?></p>
    </div>
</section>

<section class="section">
    <div class="container-custom grid lg:grid-cols-2 gap-10">
        <div class="reveal">
            <div class="card p-8 sm:p-10">
                <h2 class="font-display text-2xl font-semibold text-brand-blue-900">Bank Transfer &amp; UPI</h2>
                <p class="mt-2 text-brand-neutral-600"><?= e($blocks['bank_details_note'] ?? '') ?></p>

                <?php if ($hasBankDetails): ?>
                <dl class="mt-6 divide-y divide-brand-neutral-200 text-sm">
                    <?php if (!empty($settings['donation_bank_account_name'])): ?>
                        <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">Account Name</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['donation_bank_account_name']) ?></dd></div>
                    <?php endif; ?>
                    <?php if (!empty($settings['donation_bank_account_number'])): ?>
                        <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">Account Number</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['donation_bank_account_number']) ?></dd></div>
                    <?php endif; ?>
                    <?php if (!empty($settings['donation_bank_ifsc'])): ?>
                        <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">IFSC Code</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['donation_bank_ifsc']) ?></dd></div>
                    <?php endif; ?>
                    <?php if (!empty($settings['donation_bank_name'])): ?>
                        <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">Bank Name</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['donation_bank_name']) ?></dd></div>
                    <?php endif; ?>
                    <?php if (!empty($settings['donation_upi_id'])): ?>
                        <div class="py-3 flex justify-between gap-4"><dt class="text-brand-neutral-500">UPI ID</dt><dd class="font-medium text-brand-blue-900 text-right"><?= e($settings['donation_upi_id']) ?></dd></div>
                    <?php endif; ?>
                </dl>
                <?php if (!empty($settings['donation_upi_qr_image'])): ?>
                    <img src="<?= upload_url($settings['donation_upi_qr_image']) ?>" alt="Donation UPI QR Code" class="mt-6 w-48 mx-auto rounded-xl border border-brand-neutral-200">
                <?php endif; ?>
                <?php else: ?>
                    <div class="mt-6 rounded-xl bg-brand-neutral-50 border border-dashed border-brand-neutral-300 p-6 text-sm text-brand-neutral-500 text-center">
                        Bank/UPI details will be published here shortly. Please contact us at
                        <a href="mailto:<?= e($settings['contact_email'] ?? '') ?>" class="text-brand-orange-600 font-medium"><?= e($settings['contact_email'] ?? '') ?></a>
                        to arrange your donation.
                    </div>
                <?php endif; ?>

                <div class="mt-6 badge-trust">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 4.556-3.03 8.4-7.183 9.64a1.5 1.5 0 01-1.634 0C7.03 20.4 4 16.556 4 12V6.741a1.5 1.5 0 01.826-1.342l6.75-3.375a1.5 1.5 0 011.348 0l6.75 3.375A1.5 1.5 0 0121 6.741V12z" /></svg>
                    <?= e($blocks['tax_benefit_note'] ?? '') ?>
                </div>
            </div>
        </div>

        <div class="reveal">
            <div class="card p-8 sm:p-10">
                <h2 class="font-display text-2xl font-semibold text-brand-blue-900"><?= e($blocks['pledge_form_heading'] ?? 'Already Donated? Let Us Know') ?></h2>
                <p class="mt-2 text-brand-neutral-600">Fill this in after your transfer so our team can confirm receipt and follow up with an acknowledgement.</p>

                <?php if ($success): ?>
                    <div class="mt-6 rounded-2xl bg-brand-green-50 border border-brand-green-200 text-brand-green-800 px-5 py-4"><?= e($success) ?></div>
                <?php elseif ($error): ?>
                    <div class="mt-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4"><?= e($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('/donate') ?>" class="mt-6 space-y-4">
                    <?= Csrf::field() ?>
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div>
                        <label class="form-label">Your Name</label>
                        <input type="text" name="donor_name" required class="form-input" value="<?= e(old('donor_name')) ?>">
                        <?php if (errors('donor_name')): ?><p class="form-error"><?= e(errors('donor_name')) ?></p><?php endif; ?>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" required inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" title="Enter a valid 10-digit mobile number" placeholder="10-digit mobile number" class="form-input" value="<?= e(old('phone')) ?>">
                            <?php if (errors('phone')): ?><p class="form-error"><?= e(errors('phone')) ?></p><?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label">Email (optional)</label>
                            <input type="email" name="email" class="form-input" value="<?= e(old('email')) ?>">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Amount (INR)</label>
                            <input type="number" min="1" step="1" name="amount" required class="form-input" value="<?= e(old('amount')) ?>">
                            <?php if (errors('amount')): ?><p class="form-error"><?= e(errors('amount')) ?></p><?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label">Mode</label>
                            <select name="mode" class="form-input">
                                <option value="upi">UPI</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Transaction / UTR Reference (optional)</label>
                        <input type="text" name="reference_utr" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Message (optional)</label>
                        <textarea name="message" rows="2" class="form-input"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Confirm My Donation</button>
                </form>
            </div>
        </div>
    </div>
</section>
