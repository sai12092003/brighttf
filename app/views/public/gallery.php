<?php
/** @var array $albums */
/** @var array $images */
?>
<section class="bg-brand-gradient text-white">
    <div class="container-custom py-20 text-center">
        <p class="eyebrow !text-brand-orange-300">Moments</p>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold">Gallery</h1>
        <p class="mt-5 max-w-2xl mx-auto text-brand-blue-100 text-lg">A glimpse into our programs and the communities we work with.</p>
    </div>
</section>

<section class="section">
    <div class="container-custom">
        <?php if (empty($images)): ?>
            <div class="text-center text-brand-neutral-500 py-16">
                <p>Photos from our programs will appear here soon.</p>
            </div>
        <?php else: ?>
            <?php $galleryColors = ['bg-brand-orange-500', 'bg-brand-green-500', 'bg-brand-blue-700']; ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php foreach ($images as $i => $img): ?>
                    <button type="button" data-lightbox-src="<?= upload_url($img['image_path']) ?>" class="group relative aspect-[16/10] overflow-hidden rounded-2xl reveal">
                        <img src="<?= upload_url($img['image_path']) ?>" alt="<?= e($img['alt_text'] ?? '') ?>" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <?php if (!empty($img['album_title'])): ?>
                            <span class="absolute inset-x-0 bottom-0 <?= $galleryColors[$i % 3] ?> px-3 py-1.5 text-center text-xs font-semibold text-white truncate">
                                <?= e($img['album_title']) ?>
                            </span>
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
