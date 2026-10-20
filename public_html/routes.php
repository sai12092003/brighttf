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
use App\Models\ScholarshipApplication;

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

/**
 * Scholarship programmes. Add future scholarships as new entries keyed by slug.
 * `status` is 'open' (accepting applications) or 'closed'.
 */
$scholarships = [
    'mgr-bed-special-education-hi' => [
        'slug' => 'mgr-bed-special-education-hi',
        'status' => 'open',
        'title' => 'B.Ed – Special Education (HI)',
        'subtitle' => 'Dr. MGR Institute of Special Education & Research',
        'tagline' => 'Scholarships & concessions for meritorious and deserving students',
        'summary' => 'A B.Ed programme that trains candidates to teach all children, including children with Hearing Impairment and Deafness. Meritorious students are awarded scholarships, deserving students receive concessions, and outstation students can avail free accommodation.',
        'institute' => 'Dr. MGR Institute of Special Education and Research',
        'school' => 'Dr. MGR Home and Higher Secondary School for the Speech & Hearing Impaired',
        'course' => 'B.Ed – (Special Education – Hearing Impairment)',
        'affiliation' => 'Affiliated to Tamil Nadu Teachers Education University',
        'approval' => 'Approved by Rehabilitation Council of India',
        'website' => 'www.mgrspecialeducation.com',
        'email' => 'mgrhomeschool@gmail.com',
        'location' => 'MGR Gardens, Chennai - 600 089',
        'highlights' => [
            'Meritorious students will be given scholarships.',
            'Concession will be given to deserving students.',
            'Outstation students can avail free accommodation.',
            'As per G.O.(Ms).No.56 dated 24.4.2012, students completing the B.Ed course can work in Special Schools as well as General / Integrated Schools.',
        ],
        'contacts' => [
            ['name' => 'Mrs. Kavitha', 'phone' => '98842 16979'],
            ['name' => 'Dr. V. Praneetha', 'phone' => '70102 77808'],
            ['name' => 'Ms. S. Kavya', 'phone' => '82208 43793'],
            ['name' => 'Dr. MGR – Janaki College, 11 & 13, Durgabai Deshmukh Road, Chennai - 600 028', 'phone' => '044-2493 7382 / 2493 7392'],
            ['name' => 'Dr. MGR Institute of Special Education & Research, MGR Garden, Chennai - 600 089', 'phone' => '044-2249 0629'],
        ],
    ],
];

$router->get('/scholarship', function () use ($scholarships) {
    View::renderPublic('scholarship', [
        'scholarships' => $scholarships,
        'title' => 'Scholarship Applications',
    ], 'scholarship');
});

$router->get('/scholarship/{slug}', function (array $params) use ($scholarships) {
    $scholarship = $scholarships[$params['slug']] ?? null;
    if (!$scholarship) {
        http_response_code(404);
        View::renderPublic('404', ['title' => 'Not Found']);
        return;
    }
    View::renderPublic('scholarship-single', [
        'scholarship' => $scholarship,
        'title' => $scholarship['title'] . ' Scholarship',
    ]);
});

$router->post('/scholarship/{slug}', function (array $params) use ($scholarships) {
    $scholarship = $scholarships[$params['slug']] ?? null;
    if (!$scholarship) {
        http_response_code(404);
        View::renderPublic('404', ['title' => 'Not Found']);
        return;
    }

    $redirectTo = '/scholarship/' . $scholarship['slug'];

    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        flash_error('Your session expired. Please try again.');
        redirect($redirectTo);
    }
    // Honeypot: legitimate users never fill this hidden field.
    if (!empty($_POST['website'])) {
        redirect($redirectTo);
    }
    if ($scholarship['status'] !== 'open') {
        flash_error('Applications for this scholarship are currently closed.');
        redirect($redirectTo);
    }

    $fullName = Sanitizer::str($_POST['full_name'] ?? '');
    $email = Sanitizer::email($_POST['email'] ?? '');
    $phone = Sanitizer::str($_POST['phone'] ?? '');
    $dob = Sanitizer::str($_POST['date_of_birth'] ?? '');
    $gender = Sanitizer::str($_POST['gender'] ?? '');
    $differentlyAbled = in_array($_POST['differently_abled'] ?? '', ['Yes', 'No'], true) ? $_POST['differently_abled'] : '';
    $address = Sanitizer::str($_POST['address'] ?? '');
    $city = Sanitizer::str($_POST['city'] ?? '');
    $guardian = Sanitizer::str($_POST['guardian_name'] ?? '');
    $qualification = Sanitizer::str($_POST['qualification'] ?? '');
    $income = Sanitizer::str($_POST['annual_income'] ?? '');
    $message = Sanitizer::str($_POST['message'] ?? '');

    $errors = [];
    if ($fullName === '') $errors['full_name'] = 'Full name is required.';
    if (!Sanitizer::isValidEmail($email)) $errors['email'] = 'A valid email is required.';
    if ($phone === '') {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!Sanitizer::isValidPhone($phone)) {
        $errors['phone'] = 'Enter a valid 10-digit mobile number.';
    }

    if ($errors) {
        flash_old($_POST, $errors);
        redirect($redirectTo);
    }

    ScholarshipApplication::create([
        'scholarship_slug' => $scholarship['slug'],
        'scholarship_name' => $scholarship['title'] . ' — ' . $scholarship['subtitle'],
        'full_name' => $fullName,
        'email' => $email,
        'phone' => $phone,
        'date_of_birth' => $dob !== '' ? $dob : null,
        'gender' => $gender !== '' ? $gender : null,
        'differently_abled' => $differentlyAbled !== '' ? $differentlyAbled : null,
        'address' => $address !== '' ? $address : null,
        'city' => $city !== '' ? $city : null,
        'guardian_name' => $guardian !== '' ? $guardian : null,
        'qualification' => $qualification !== '' ? $qualification : null,
        'annual_income' => $income !== '' ? $income : null,
        'message' => $message !== '' ? $message : null,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    clear_old();
    flash_success('Thank you! Your scholarship application has been received. Our team will review it and get in touch with you.');
    redirect($redirectTo);
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
    if ($phone !== '' && !Sanitizer::isDigitsOnly10To12($phone)) $errors['phone'] = 'Enter a valid phone number (10 to 12 digits, numbers only).';
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
        '/scholarship', '/gallery', '/blog', '/testimonials', '/faq', '/contact',
        '/transparency', '/privacy-policy', '/terms',
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
