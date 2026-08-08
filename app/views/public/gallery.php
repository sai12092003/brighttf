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
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                <?php foreach ($images as $img): ?>
                    <button type="button" data-lightbox-src="<?= upload_url($img['image_path']) ?>" class="group relative aspect-square overflow-hidden rounded-2xl reveal">
                        <img src="<?= upload_url($img['image_path']) ?>" alt="<?= e($img['alt_text'] ?? '') ?>" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<div id="lightbox" class="hidden fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-6 cursor-zoom-out">
    <img id="lightbox-img" src="" alt="" class="max-h-[85vh] max-w-full rounded-lg shadow-2xl">
</div>
