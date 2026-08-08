<?php
/** @var array $settings */
use App\Core\Csrf;
$s = static fn(string $key): string => e($settings[$key] ?? '');
?>
<form method="POST" action="<?= base_url('/admin/settings.php') ?>" enctype="multipart/form-data" class="space-y-8 max-w-3xl">
    <?= Csrf::field() ?>

    <div class="card p-8">
        <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-5">Organization &amp; Contact</h2>
        <div class="grid sm:grid-cols-2 gap-5">
            <div><label class="form-label">Organization Name</label><input type="text" name="org_name" class="form-input" value="<?= $s('org_name') ?>"></div>
            <div><label class="form-label">Tagline</label><input type="text" name="org_tagline" class="form-input" value="<?= $s('org_tagline') ?>"></div>
            <div><label class="form-label">Contact Email</label><input type="email" name="contact_email" class="form-input" value="<?= $s('contact_email') ?>"></div>
            <div><label class="form-label">Phone 1</label><input type="text" name="contact_phone_1" class="form-input" value="<?= $s('contact_phone_1') ?>"></div>
            <div><label class="form-label">Phone 2</label><input type="text" name="contact_phone_2" class="form-input" value="<?= $s('contact_phone_2') ?>"></div>
            <div class="sm:col-span-2"><label class="form-label">Public Office Address</label><textarea name="office_address_public" rows="2" class="form-input"><?= $s('office_address_public') ?></textarea></div>
            <div class="sm:col-span-2"><label class="form-label">Registered (Trust Deed) Address</label><textarea name="registered_address_trust_deed" rows="2" class="form-input"><?= $s('registered_address_trust_deed') ?></textarea></div>
        </div>
    </div>

    <div class="card p-8">
        <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-5">Legal &amp; Tax Registration</h2>
        <div class="grid sm:grid-cols-2 gap-5">
            <div><label class="form-label">PAN Number</label><input type="text" name="pan_number" class="form-input" value="<?= $s('pan_number') ?>"></div>
            <div></div>
            <div><label class="form-label">12A Registration No.</label><input type="text" name="reg_12a_number" class="form-input" value="<?= $s('reg_12a_number') ?>"></div>
            <div><label class="form-label">12A Validity</label><input type="text" name="reg_12a_validity" class="form-input" value="<?= $s('reg_12a_validity') ?>"></div>
            <div><label class="form-label">80G Registration No.</label><input type="text" name="reg_80g_number" class="form-input" value="<?= $s('reg_80g_number') ?>"></div>
            <div><label class="form-label">80G Validity</label><input type="text" name="reg_80g_validity" class="form-input" value="<?= $s('reg_80g_validity') ?>"></div>
        </div>
    </div>

    <div class="card p-8">
        <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-5">Donation Details</h2>
        <div class="grid sm:grid-cols-2 gap-5">
            <div><label class="form-label">Bank Account Name</label><input type="text" name="donation_bank_account_name" class="form-input" value="<?= $s('donation_bank_account_name') ?>"></div>
            <div><label class="form-label">Bank Account Number</label><input type="text" name="donation_bank_account_number" class="form-input" value="<?= $s('donation_bank_account_number') ?>"></div>
            <div><label class="form-label">IFSC Code</label><input type="text" name="donation_bank_ifsc" class="form-input" value="<?= $s('donation_bank_ifsc') ?>"></div>
            <div><label class="form-label">Bank Name</label><input type="text" name="donation_bank_name" class="form-input" value="<?= $s('donation_bank_name') ?>"></div>
            <div><label class="form-label">UPI ID</label><input type="text" name="donation_upi_id" class="form-input" value="<?= $s('donation_upi_id') ?>"></div>
            <div>
                <label class="form-label">UPI QR Code Image</label>
                <?php if (!empty($settings['donation_upi_qr_image'])): ?>
                    <img src="<?= upload_url($settings['donation_upi_qr_image']) ?>" class="h-16 mb-2">
                <?php endif; ?>
                <input type="file" name="donation_upi_qr_image" accept="image/*" class="form-input">
            </div>
        </div>
    </div>

    <div class="card p-8">
        <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-5">Social &amp; Integrations</h2>
        <div class="grid sm:grid-cols-2 gap-5">
            <div><label class="form-label">Facebook URL</label><input type="url" name="social_facebook" class="form-input" value="<?= $s('social_facebook') ?>"></div>
            <div><label class="form-label">Instagram URL</label><input type="url" name="social_instagram" class="form-input" value="<?= $s('social_instagram') ?>"></div>
            <div><label class="form-label">Twitter / X URL</label><input type="url" name="social_twitter" class="form-input" value="<?= $s('social_twitter') ?>"></div>
            <div><label class="form-label">YouTube URL</label><input type="url" name="social_youtube" class="form-input" value="<?= $s('social_youtube') ?>"></div>
            <div><label class="form-label">LinkedIn URL</label><input type="url" name="social_linkedin" class="form-input" value="<?= $s('social_linkedin') ?>"></div>
            <div><label class="form-label">Google Analytics ID</label><input type="text" name="google_analytics_id" class="form-input" value="<?= $s('google_analytics_id') ?>"></div>
            <div class="sm:col-span-2"><label class="form-label">Google Maps Embed URL</label><input type="url" name="google_maps_embed_url" class="form-input" value="<?= $s('google_maps_embed_url') ?>"></div>
        </div>
    </div>

    <div class="card p-8">
        <h2 class="font-display text-lg font-semibold text-brand-blue-900 mb-5">SEO Defaults &amp; Footer</h2>
        <div class="grid gap-5">
            <div><label class="form-label">Default Meta Title</label><input type="text" name="default_meta_title" class="form-input" value="<?= $s('default_meta_title') ?>"></div>
            <div><label class="form-label">Default Meta Description</label><textarea name="default_meta_description" rows="2" class="form-input"><?= $s('default_meta_description') ?></textarea></div>
            <div><label class="form-label">Footer About Text</label><textarea name="footer_about_text" rows="2" class="form-input"><?= $s('footer_about_text') ?></textarea></div>
            <div><label class="form-label">Footer Copyright Text</label><input type="text" name="footer_copyright_text" class="form-input" value="<?= $s('footer_copyright_text') ?>"></div>
            <div>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="maintenance_mode" value="1" <?= ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' ?> class="rounded border-brand-neutral-300 text-brand-orange-600">
                    <span class="text-sm text-brand-blue-900">Maintenance Mode</span>
                </label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn-primary">Save All Settings</button>
</form>
