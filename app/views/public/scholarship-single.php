<?php
/** @var array $scholarship */
use App\Core\Csrf;

$s = $scholarship;
$isOpen = ($s['status'] ?? 'open') === 'open';
$success = flash_success();
$error = flash_error();
$action = base_url('/scholarship/' . $s['slug']);
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-8 sm:py-10 min-h-[170px] sm:min-h-[200px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300"><?= e($s['subtitle']) ?></p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold"><?= e($s['title']) ?></h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg"><?= e($s['tagline']) ?></p>
        <p class="mt-4">
            <a href="<?= base_url('/scholarship') ?>" class="text-brand-blue-100 hover:text-white text-sm">&larr; Back to all scholarships</a>
        </p>
    </div>
</section>

<section class="section pt-8 sm:pt-10">
    <div class="container-custom grid lg:grid-cols-5 gap-10">
        <!-- Details -->
        <div class="lg:col-span-2 reveal space-y-6">
            <div class="card p-6">
                <h2 class="font-display text-xl font-semibold text-brand-blue-900"><?= e($s['institute']) ?></h2>
                <p class="mt-1 text-sm text-brand-neutral-500"><?= e($s['school']) ?></p>
                <p class="mt-4 text-brand-neutral-600"><?= e($s['summary']) ?></p>

                <dl class="mt-5 space-y-2.5 text-sm">
                    <div class="flex gap-2"><dt class="font-semibold text-brand-blue-900 shrink-0">Course:</dt><dd class="text-brand-neutral-600"><?= e($s['course']) ?></dd></div>
                    <div class="flex gap-2"><dt class="font-semibold text-brand-blue-900 shrink-0">Affiliation:</dt><dd class="text-brand-neutral-600"><?= e($s['affiliation']) ?></dd></div>
                    <div class="flex gap-2"><dt class="font-semibold text-brand-blue-900 shrink-0">Approval:</dt><dd class="text-brand-neutral-600"><?= e($s['approval']) ?></dd></div>
                    <div class="flex gap-2"><dt class="font-semibold text-brand-blue-900 shrink-0">Location:</dt><dd class="text-brand-neutral-600"><?= e($s['location']) ?></dd></div>
                    <div class="flex gap-2"><dt class="font-semibold text-brand-blue-900 shrink-0">Email:</dt><dd class="text-brand-neutral-600"><a href="mailto:<?= e($s['email']) ?>" class="text-brand-blue-700 hover:underline"><?= e($s['email']) ?></a></dd></div>
                    <div class="flex gap-2"><dt class="font-semibold text-brand-blue-900 shrink-0">Website:</dt><dd class="text-brand-neutral-600"><?= e($s['website']) ?></dd></div>
                </dl>
            </div>

            <div class="card p-6">
                <h3 class="font-display text-lg font-semibold text-brand-blue-900">What you get</h3>
                <ul class="mt-4 space-y-3">
                    <?php foreach ($s['highlights'] as $h): ?>
                        <li class="flex items-start gap-3 text-sm text-brand-neutral-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-green-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            <span><?= e($h) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card p-6">
                <h3 class="font-display text-lg font-semibold text-brand-blue-900">For further details, contact</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <?php foreach ($s['contacts'] as $c): ?>
                        <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                            <span class="text-brand-neutral-600"><?= e($c['name']) ?></span>
                            <span class="font-medium text-brand-blue-900 whitespace-nowrap"><?= e($c['phone']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Application form -->
        <div class="lg:col-span-3 reveal">
            <div class="card p-6 sm:p-8">
                <h2 class="font-display text-2xl font-semibold text-brand-blue-900">Scholarship Application Form</h2>
                <p class="mt-2 text-brand-neutral-600">Fill in your details below and our scholarship committee will get in touch with you.</p>

                <?php if ($success): ?>
                    <div class="mt-6 rounded-2xl bg-brand-green-50 border border-brand-green-200 text-brand-green-800 px-5 py-4"><?= e($success) ?></div>
                <?php elseif ($error): ?>
                    <div class="mt-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4"><?= e($error) ?></div>
                <?php endif; ?>

                <?php if (!$isOpen): ?>
                    <div class="mt-6 rounded-2xl bg-brand-neutral-100 text-brand-neutral-600 px-5 py-4">Applications for this scholarship are currently closed.</div>
                <?php else: ?>
                <form method="POST" action="<?= e($action) ?>" class="mt-6 space-y-4">
                    <?= Csrf::field() ?>
                    <!-- Honeypot -->
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

                    <div>
                        <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" required class="form-input" value="<?= e(old('full_name')) ?>">
                        <?php if (errors('full_name')): ?><p class="form-error"><?= e(errors('full_name')) ?></p><?php endif; ?>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Phone <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" required inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" title="Enter a valid 10-digit mobile number" placeholder="10-digit mobile number" class="form-input" value="<?= e(old('phone')) ?>">
                            <?php if (errors('phone')): ?><p class="form-error"><?= e(errors('phone')) ?></p><?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required class="form-input" value="<?= e(old('email')) ?>">
                            <?php if (errors('email')): ?><p class="form-error"><?= e(errors('email')) ?></p><?php endif; ?>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-input" value="<?= e(old('date_of_birth')) ?>">
                        </div>
                        <div>
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-input">
                                <?php $g = old('gender'); ?>
                                <option value="">Select</option>
                                <?php foreach (['Male', 'Female', 'Transgender', 'Thirunambi'] as $opt): ?>
                                    <option value="<?= $opt ?>" <?= $g === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Differently Abled</label>
                        <div class="flex items-center gap-6 mt-1">
                            <?php $da = old('differently_abled'); ?>
                            <label class="inline-flex items-center gap-2 text-sm text-brand-neutral-700">
                                <input type="radio" name="differently_abled" value="Yes" <?= $da === 'Yes' ? 'checked' : '' ?> class="text-brand-orange-600 focus:ring-brand-orange-500">
                                Yes
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-brand-neutral-700">
                                <input type="radio" name="differently_abled" value="No" <?= $da === 'No' ? 'checked' : '' ?> class="text-brand-orange-600 focus:ring-brand-orange-500">
                                No
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="form-input"><?= e(old('address')) ?></textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">City / Town</label>
                            <input type="text" name="city" class="form-input" value="<?= e(old('city')) ?>">
                        </div>
                        <div>
                            <label class="form-label">Parent / Guardian Name</label>
                            <input type="text" name="guardian_name" class="form-input" value="<?= e(old('guardian_name')) ?>">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Highest Qualification</label>
                            <input type="text" name="qualification" placeholder="e.g. 12th / Degree" class="form-input" value="<?= e(old('qualification')) ?>">
                        </div>
                        <div>
                            <label class="form-label">Annual Family Income (INR)</label>
                            <input type="text" name="annual_income" placeholder="e.g. 1,20,000" class="form-input" value="<?= e(old('annual_income')) ?>">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Why do you need this scholarship?</label>
                        <textarea name="message" rows="3" class="form-input" placeholder="Tell us briefly about yourself and your need."><?= e(old('message')) ?></textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">Submit Application</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
