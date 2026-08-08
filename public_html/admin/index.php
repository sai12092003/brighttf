<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\View;
use App\Models\ContactSubmission;
use App\Models\VolunteerPartnerSubmission;
use App\Models\DonationPledge;
use App\Models\BlogPost;
use App\Models\ActivityLog;

View::renderAdmin('dashboard', [
    'pageTitle' => 'Dashboard',
    'newContact' => ContactSubmission::countNew(),
    'newVolunteer' => VolunteerPartnerSubmission::countNew(),
    'newPledges' => DonationPledge::countNew(),
    'posts' => count(BlogPost::all()),
    'recentActivity' => ActivityLog::recent(10),
]);
