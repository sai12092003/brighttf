<?php
/** @var array $posts */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-8 sm:py-10 min-h-[170px] sm:min-h-[200px] flex flex-col justify-center text-center">
        <p class="eyebrow !text-brand-orange-300">Stories &amp; Updates</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Blog &amp; News</h1>
    </div>
</section>

<section class="section">
    <div class="container-custom">
        <?php if (empty($posts)): ?>
            <div class="text-center text-brand-neutral-500 py-16">
                <p>No posts published yet. Check back soon for updates from our programs.</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                    <a href="<?= base_url('/blog/' . $post['slug']) ?>" class="card overflow-hidden group reveal">
                        <?php if (!empty($post['featured_image'])): ?>
                            <img src="<?= upload_url($post['featured_image']) ?>" alt="<?= e($post['title']) ?>" class="h-48 w-full object-cover">
                        <?php else: ?>
                            <div class="h-48 w-full bg-brand-gradient"></div>
                        <?php endif; ?>
                        <div class="p-6">
                            <p class="text-xs uppercase tracking-wide text-brand-orange-600 font-semibold"><?= e($post['category_name'] ?? 'Update') ?> &middot; <?= e(date('M j, Y', strtotime((string) $post['published_at']))) ?></p>
                            <h2 class="mt-2 font-display text-lg font-semibold text-brand-blue-900 group-hover:text-brand-orange-600 transition-colors"><?= e($post['title']) ?></h2>
                            <p class="mt-2 text-sm text-brand-neutral-600 line-clamp-3"><?= e($post['excerpt'] ?? '') ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
