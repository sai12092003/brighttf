<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\SiteSetting;
use App\Models\ActivityLog;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/settings.php');

    $fields = [
        'org_name', 'org_tagline', 'contact_email', 'contact_phone_1', 'contact_phone_2',
        'office_address_public', 'registered_address_trust_deed',
        'pan_number', 'reg_12a_number', 'reg_12a_validity', 'reg_80g_number', 'reg_80g_validity',
        'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube', 'social_linkedin',
        'donation_bank_account_name', 'donation_bank_account_number', 'donation_bank_ifsc', 'donation_bank_name', 'donation_upi_id',
        'google_maps_embed_url', 'google_analytics_id',
        'default_meta_title', 'default_meta_description',
        'footer_about_text', 'footer_copyright_text',
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            SiteSetting::set($field, Sanitizer::str($_POST[$field]));
        }
    }
    SiteSetting::set('maintenance_mode', isset($_POST['maintenance_mode']) ? '1' : '0');

    $uploadError = null;
    $qrPath = Uploader::storeImage($_FILES['donation_upi_qr_image'] ?? [], 'settings', $uploadError);
    if ($uploadError) {
        flash_error($uploadError);
        redirect('/admin/settings.php');
    }
    if ($qrPath) {
        SiteSetting::set('donation_upi_qr_image', $qrPath);
    }

    ActivityLog::record(Auth::id(), 'update', 'site_settings', null, 'Updated site settings');
    flash_success('Settings saved.');
    redirect('/admin/settings.php');
}

View::renderAdmin('settings', ['pageTitle' => 'Site Settings', 'settings' => SiteSetting::all()]);
