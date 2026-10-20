<?php
/** @var array $applications */
use App\Core\Csrf;

$statuses = ['new', 'reviewed', 'shortlisted', 'approved', 'rejected'];
$badge = [
    'new' => 'bg-brand-blue-50 text-brand-blue-700',
    'reviewed' => 'bg-amber-50 text-amber-700',
    'shortlisted' => 'bg-purple-50 text-purple-700',
    'approved' => 'bg-brand-green-50 text-brand-green-700',
    'rejected' => 'bg-red-50 text-red-700',
];
$fmtDate = static fn ($d) => $d ? date('M j, Y', strtotime((string) $d)) : '—';
?>
<div class="mb-4 flex items-center justify-between">
    <p class="text-sm text-brand-neutral-500"><?= count($applications) ?> application<?= count($applications) === 1 ? '' : 's' ?> received.</p>
    <?php if (!empty($applications)): ?>
        <a href="<?= base_url('/admin/scholarship-applications.php?export=csv') ?>" class="text-sm text-brand-blue-700 hover:underline">Export CSV</a>
    <?php endif; ?>
</div>

<!-- Compact list -->
<div class="card overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-brand-neutral-50 text-left text-xs uppercase tracking-wide text-brand-neutral-500">
            <tr>
                <th class="px-5 py-3">Received</th>
                <th class="px-5 py-3">Applicant</th>
                <th class="px-5 py-3">Scholarship</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-neutral-100">
            <?php foreach ($applications as $a): ?>
                <tr>
                    <td class="px-5 py-3 text-brand-neutral-500 whitespace-nowrap"><?= e($fmtDate($a['created_at'])) ?></td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-brand-blue-900"><?= e($a['full_name']) ?></p>
                        <p class="text-xs text-brand-neutral-500"><?= e($a['phone']) ?></p>
                    </td>
                    <td class="px-5 py-3 text-brand-neutral-600 max-w-[16rem] truncate"><?= e($a['scholarship_name']) ?></td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize <?= $badge[$a['status']] ?? 'bg-brand-neutral-100 text-brand-neutral-600' ?>"><?= e($a['status']) ?></span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <button type="button" data-schol-open="schol-modal-<?= (int) $a['id'] ?>"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-brand-neutral-300 px-3 py-1.5 text-brand-blue-700 hover:bg-brand-blue-50 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($applications)): ?>
                <tr><td colspan="5" class="px-5 py-8 text-center text-brand-neutral-500">No scholarship applications yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Detail modals -->
<?php foreach ($applications as $a): ?>
    <div id="schol-modal-<?= (int) $a['id'] ?>" class="schol-modal hidden fixed inset-0 z-50 items-center justify-center p-4">
        <div class="schol-backdrop absolute inset-0 bg-brand-blue-950/50"></div>
        <div class="relative w-full max-w-xl max-h-[88vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <!-- Header -->
            <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-brand-neutral-200 bg-white px-6 py-4 rounded-t-2xl">
                <div>
                    <h3 class="font-display text-lg font-semibold text-brand-blue-900"><?= e($a['full_name']) ?></h3>
                    <p class="mt-0.5 text-xs text-brand-neutral-500">Applied <?= e($fmtDate($a['created_at'])) ?></p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize <?= $badge[$a['status']] ?? 'bg-brand-neutral-100 text-brand-neutral-600' ?>"><?= e($a['status']) ?></span>
                    <button type="button" class="schol-close -mr-1 rounded-lg p-1.5 text-brand-neutral-400 hover:bg-brand-neutral-100 hover:text-brand-neutral-700" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-brand-orange-600"><?= e($a['scholarship_name']) ?></p>
                <dl class="grid grid-cols-2 gap-x-5 gap-y-4 text-sm">
                    <?php
                    $fields = [
                        'Email' => $a['email'],
                        'Phone' => $a['phone'],
                        'Date of Birth' => $a['date_of_birth'] ? $fmtDate($a['date_of_birth']) : null,
                        'Gender' => $a['gender'],
                        'Differently Abled' => $a['differently_abled'],
                        'City / Town' => $a['city'],
                        'Parent / Guardian' => $a['guardian_name'],
                        'Highest Qualification' => $a['qualification'],
                        'Annual Family Income' => $a['annual_income'],
                    ];
                    foreach ($fields as $label => $value): ?>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-brand-neutral-400"><?= e($label) ?></dt>
                            <dd class="mt-0.5 text-brand-blue-900 break-words"><?= $value !== null && $value !== '' ? e((string) $value) : '<span class="text-brand-neutral-300">—</span>' ?></dd>
                        </div>
                    <?php endforeach; ?>

                    <div class="col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-brand-neutral-400">Address</dt>
                        <dd class="mt-0.5 text-brand-blue-900 break-words"><?= !empty($a['address']) ? e($a['address']) : '<span class="text-brand-neutral-300">—</span>' ?></dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-brand-neutral-400">Why they need this scholarship</dt>
                        <dd class="mt-0.5 text-brand-blue-900 break-words whitespace-pre-line"><?= !empty($a['message']) ? e($a['message']) : '<span class="text-brand-neutral-300">—</span>' ?></dd>
                    </div>
                </dl>
            </div>

            <!-- Footer actions -->
            <div class="sticky bottom-0 flex flex-wrap items-center justify-between gap-3 border-t border-brand-neutral-200 bg-brand-neutral-50 px-6 py-4 rounded-b-2xl">
                <form method="POST" class="flex items-center gap-2">
                    <?= Csrf::field() ?>
                    <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                    <label class="text-xs font-medium text-brand-neutral-500">Status</label>
                    <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border-brand-neutral-300">
                        <?php foreach ($statuses as $st): ?>
                            <option value="<?= $st ?>" <?= $a['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="flex items-center gap-3">
                    <a href="mailto:<?= e($a['email']) ?>" class="text-sm text-brand-blue-700 hover:underline font-medium">Email</a>
                    <form method="POST" onsubmit="return confirm('Delete this application? This cannot be undone.');">
                        <?= Csrf::field() ?>
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                        <button type="submit" class="text-sm text-red-600 hover:underline font-medium">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
(function () {
    function openModal(id) {
        var m = document.getElementById(id);
        if (!m) return;
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(m) {
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('[data-schol-open]').forEach(function (btn) {
        btn.addEventListener('click', function () { openModal(btn.getAttribute('data-schol-open')); });
    });
    document.querySelectorAll('.schol-modal').forEach(function (m) {
        var close = m.querySelector('.schol-close');
        var backdrop = m.querySelector('.schol-backdrop');
        if (close) close.addEventListener('click', function () { closeModal(m); });
        if (backdrop) backdrop.addEventListener('click', function () { closeModal(m); });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.schol-modal.flex').forEach(closeModal);
        }
    });
})();
</script>
