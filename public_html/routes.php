<?php

declare(strict_types=1);

use App\Core\View;
use App\Core\Csrf;
use App\Core\Sanitizer;
use App\Models\ContentBlock;
use App\Models\FocusArea;
use App\Models\TeamMember;
use App\Models\Faq;
use App\Models\StatsCounter;
use App\Models\Testimonial;
use App\Models\BlogPost;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\LegalDocument;
use App\Models\ContactSubmission;
use App\Models\VolunteerPartnerSubmission;
use App\Models\DonationPledge;

/** @var App\Core\Router $router */

$router->get('/', function () {
    View::renderPublic('home', [
        'blocks' => ContentBlock::forPage('home'),
        'focusAreas' => FocusArea::allActive(),
        'stats' => StatsCounter::allActive(),
        'testimonials' => Testimonial::allActive(),
        'posts' => BlogPost::published(3),
    ], 'home');
});

$router->get('/about', function () {
    View::renderPublic('about', [
        'blocks' => ContentBlock::forPage('about'),
        'team' => TeamMember::allActive(),
        'title' => 'About Us',
    ], 'about');
});

$router->get('/focus-areas', function () {
    View::renderPublic('focus-areas', [
        'blocks' => ContentBlock::forPage('about'),
        'focusAreas' => FocusArea::allActive(),
        'title' => 'Our Focus Areas',
    ], 'focus_areas');
});

$router->get('/focus-areas/{slug}', function (array $params) {
    $area = FocusArea::findBySlug($params['slug']);
    if (!$area) {
        http_response_code(404);
        View::renderPublic('404', ['title' => 'Not Found']);
        return;
    }
    View::renderPublic('focus-area-single', [
        'area' => $area,
        'title' => $area['title'],
    ]);
});

$router->get('/team', function () {
    View::renderPublic('team', [
        'team' => TeamMember::allActive(),
        'title' => 'Our Team',
    ], 'team');
});

$router->get('/get-involved', function () {
    View::renderPublic('get-involved', [
        'blocks' => ContentBlock::forPage('get_involved'),
        'title' => 'Get Involved',
    ], 'get_involved');
});

$router->post('/get-involved', function () {
    $type = $_POST['submission_type'] ?? '';
    $type = in_array($type, ['volunteer', 'partner'], true) ? $type : 'volunteer';

    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        flash_error('Your session expired. Please try again.');
        redirect('/get-involved');
    }

    // Honeypot: legitimate users never fill this hidden field.
    if (!empty($_POST['website'])) {
        redirect('/get-involved');
    }

    $name = Sanitizer::str($_POST['name'] ?? '');
    $email = Sanitizer::email($_POST['email'] ?? '');
    $phone = Sanitizer::str($_POST['phone'] ?? '');
    $org = Sanitizer::str($_POST['organization_name'] ?? '');
    $interest = Sanitizer::str($_POST['area_of_interest'] ?? '');
    $message = Sanitizer::str($_POST['message'] ?? '');

    $errors = [];
    if ($name === '') $errors['name'] = 'Name is required.';
    if (!Sanitizer::isValidEmail($email)) $errors['email'] = 'A valid email is required.';
    if ($phone === '') {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!Sanitizer::isValidPhone($phone)) {
        $errors['phone'] = 'Enter a valid 10-digit mobile number.';
    }
    if ($type === 'partner' && $org === '') $errors['organization_name'] = 'Organization name is required.';

    if ($errors) {
        flash_old($_POST, $errors);
        redirect('/get-involved');
    }

    VolunteerPartnerSubmission::create([
        'submission_type' => $type,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'organization_name' => $org !== '' ? $org : null,
        'area_of_interest' => $interest !== '' ? $interest : null,
        'message' => $message !== '' ? $message : null,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    clear_old();
    flash_success("Thank you! Our team will get in touch with you shortly.");
    redirect('/get-involved');
});

$router->get('/donate', function () {
    View::renderPublic('donate', [
        'blocks' => ContentBlock::forPage('donate'),
        'title' => 'Donate',
    ], 'donate');
});

$router->post('/donate', function () {
    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        flash_error('Your session expired. Please try again.');
        redirect('/donate');
    }
    if (!empty($_POST['website'])) {
        redirect('/donate');
    }

    $name = Sanitizer::str($_POST['donor_name'] ?? '');
    $email = Sanitizer::email($_POST['email'] ?? '');
    $phone = Sanitizer::str($_POST['phone'] ?? '');
    $amount = Sanitizer::decimal($_POST['amount'] ?? 0);
    $mode = in_array($_POST['mode'] ?? '', ['bank_transfer', 'upi', 'cash', 'other'], true) ? $_POST['mode'] : 'upi';
    $reference = Sanitizer::str($_POST['reference_utr'] ?? '');
    $message = Sanitizer::str($_POST['message'] ?? '');

    $errors = [];
    if ($name === '') $errors['donor_name'] = 'Name is required.';
    if ($phone === '') {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!Sanitizer::isValidPhone($phone)) {
        $errors['phone'] = 'Enter a valid 10-digit mobile number.';
    }
    if ($amount <= 0) $errors['amount'] = 'Please enter a valid donation amount.';

    if ($errors) {
        flash_old($_POST, $errors);
        redirect('/donate');
    }

    DonationPledge::create([
        'donor_name' => $name,
        'email' => $email !== '' ? $email : null,
        'phone' => $phone,
        'amount' => $amount,
        'mode' => $mode,
        'reference_utr' => $reference !== '' ? $reference : null,
        'message' => $message !== '' ? $message : null,
    ]);

    clear_old();
    flash_success('Thank you for your generosity! Our team will confirm your donation shortly.');
    redirect('/donate');
});

$router->get('/gallery', function () {
    View::renderPublic('gallery', [
        'albums' => GalleryAlbum::allActive(),
        'images' => GalleryImage::allActive(),
        'title' => 'Gallery',
    ], 'gallery');
});

$router->get('/blog', function () {
    View::renderPublic('blog-list', [
        'posts' => BlogPost::published(),
        'title' => 'Blog & News',
    ], 'blog');
});

$router->get('/blog/{slug}', function (array $params) {
    $post = BlogPost::findBySlug($params['slug']);
    if (!$post) {
        http_response_code(404);
        View::renderPublic('404', ['title' => 'Not Found']);
        return;
    }
    BlogPost::incrementViews((int) $post['id']);
    View::renderPublic('blog-single', [
        'post' => $post,
        'title' => $post['meta_title'] ?: $post['title'],
        'metaDescription' => $post['meta_description'] ?: $post['excerpt'],
    ]);
});

$router->get('/testimonials', function () {
    View::renderPublic('testimonials', [
        'testimonials' => Testimonial::allActive(),
        'title' => 'Testimonials',
    ]);
});

$router->get('/faq', function () {
    View::renderPublic('faq', [
        'faqs' => Faq::allActive(),
        'title' => 'Frequently Asked Questions',
    ], 'faq');
});

$router->get('/contact', function () {
    View::renderPublic('contact', [
        'title' => 'Contact Us',
    ], 'contact');
});

$router->post('/contact', function () {
    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        flash_error('Your session expired. Please try again.');
        redirect('/contact');
    }
    if (!empty($_POST['website'])) {
        redirect('/contact');
    }

    $name = Sanitizer::str($_POST['name'] ?? '');
    $email = Sanitizer::email($_POST['email'] ?? '');
    $phone = Sanitizer::str($_POST['phone'] ?? '');
    $subject = Sanitizer::str($_POST['subject'] ?? '');
    $message = Sanitizer::str($_POST['message'] ?? '');

    $errors = [];
    if ($name === '') $errors['name'] = 'Name is required.';
    if (!Sanitizer::isValidEmail($email)) $errors['email'] = 'A valid email is required.';
    if ($phone !== '' && !Sanitizer::isValidPhone($phone)) $errors['phone'] = 'Enter a valid 10-digit mobile number.';
    if ($message === '') $errors['message'] = 'Please enter a message.';

    if ($errors) {
        flash_old($_POST, $errors);
        redirect('/contact');
    }

    ContactSubmission::create([
        'name' => $name,
        'email' => $email,
        'phone' => $phone !== '' ? $phone : null,
        'subject' => $subject !== '' ? $subject : null,
        'message' => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
    ]);

    clear_old();
    flash_success("Thanks for reaching out! We'll respond as soon as we can.");
    redirect('/contact');
});

$router->get('/transparency', function () {
    View::renderPublic('transparency', [
        'documents' => LegalDocument::allPublic(),
        'title' => 'Transparency & Legal',
    ], 'transparency');
});

$router->get('/privacy-policy', function () {
    View::renderPublic('legal-page', [
        'blocks' => ContentBlock::forPage('privacy_policy'),
        'title' => 'Privacy Policy',
    ]);
});

$router->get('/terms', function () {
    View::renderPublic('legal-page', [
        'blocks' => ContentBlock::forPage('terms'),
        'title' => 'Terms of Use',
    ]);
});

$router->get('/sitemap.xml', function () {
    header('Content-Type: application/xml; charset=UTF-8');
    $staticPaths = [
        '/', '/about', '/focus-areas', '/team', '/get-involved', '/donate',
        '/gallery', '/blog', '/testimonials', '/faq', '/contact', '/transparency',
        '/privacy-policy', '/terms',
    ];
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($staticPaths as $path) {
        echo '<url><loc>' . e(base_url($path)) . '</loc></url>' . "\n";
    }
    foreach (FocusArea::allActive() as $area) {
        echo '<url><loc>' . e(base_url('/focus-areas/' . $area['slug'])) . '</loc></url>' . "\n";
    }
    foreach (BlogPost::published() as $post) {
        echo '<url><loc>' . e(base_url('/blog/' . $post['slug'])) . '</loc><lastmod>' . e(date('Y-m-d', strtotime((string) $post['updated_at']))) . '</lastmod></url>' . "\n";
    }
    echo '</urlset>';
});
