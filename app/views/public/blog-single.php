<?php
/** @var array $post */
?>
<article>
    <section class="bg-brand-gradient text-white">
        <div class="container-custom py-16">
            <a href="<?= base_url('/blog') ?>" class="text-sm text-brand-blue-200 hover:text-white">&larr; Back to Blog</a>
            <p class="mt-4 eyebrow !text-brand-orange-300"><?= e($post['category_name'] ?? 'Update') ?> &middot; <?= e(date('F j, Y', strtotime((string) $post['published_at']))) ?></p>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl lg:text-5xl font-semibold max-w-3xl"><?= e($post['title']) ?></h1>
        </div>
    </section>

    <?php if (!empty($post['featured_image'])): ?>
        <div class="container-custom -mt-10">
            <img src="<?= upload_url($post['featured_image']) ?>" alt="<?= e($post['title']) ?>" class="w-full max-h-[420px] object-cover rounded-3xl shadow-soft-lg">
        </div>
    <?php endif; ?>

    <section class="section">
        <div class="container-custom max-w-3xl prose prose-lg prose-headings:font-display prose-headings:text-brand-blue-900 prose-a:text-brand-orange-600">
            <?= $post['body'] ?>
        </div>
    </section>
</article>
