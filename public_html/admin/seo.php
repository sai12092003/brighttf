<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Sanitizer;
use App\Core\View;
use App\Models\SeoMeta;
use App\Models\ActivityLog;

$pages = [
    'home' => 'Home',
    'about' => 'About',
    'focus_areas' => 'Focus Areas',
    'team' => 'Team',
    'get_involved' => 'Get Involved',
    'donate' => 'Donate',
    'gallery' => 'Gallery',
    'blog' => 'Blog',
    'faq' => 'FAQ',
    'contact' => 'Contact',
    'transparency' => 'Transparency & Legal',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/seo.php');

    $pageKey = Sanitizer::str($_POST['page_key'] ?? '');
    if (!array_key_exists($pageKey, $pages)) {
        flash_error('Invalid page.');
        redirect('/admin/seo.php');
    }

    SeoMeta::upsert($pageKey, [
        'meta_title' => Sanitizer::str($_POST['meta_title'] ?? ''),
        'meta_description' => Sanitizer::str($_POST['meta_description'] ?? ''),
        'canonical_url' => Sanitizer::str($_POST['canonical_url'] ?? ''),
    ]);

    ActivityLog::record(Auth::id(), 'update', 'seo_meta', null, "Updated SEO meta for page: {$pageKey}");
    flash_success('SEO settings saved.');
    redirect('/admin/seo.php?page=' . urlencode($pageKey));
}

$activePage = $_GET['page'] ?? array_key_first($pages);
$current = SeoMeta::forPage($activePage);

View::renderAdmin('seo', [
    'pageTitle' => 'SEO Meta',
    'pages' => $pages,
    'activePage' => $activePage,
    'current' => $current,
]);
