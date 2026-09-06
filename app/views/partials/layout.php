<?php
/** @var string $content */
/** @var array $settings */
/** @var array|null $seo */
/** @var array $global */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>document.documentElement.classList.add('js');</script>
<?php \App\Core\View::partial('meta-tags', ['settings' => $settings, 'seo' => $seo, 'title' => $title ?? null, 'metaDescription' => $metaDescription ?? null]); ?>
</head>
<body class="min-h-screen flex flex-col">
    <?php \App\Core\View::partial('header', ['settings' => $settings, 'global' => $global]); ?>

    <main class="flex-1">
        <?= $content ?>
    </main>

    <?php \App\Core\View::partial('footer', ['settings' => $settings]); ?>
    <?php \App\Core\View::partial('enquire-widget', ['settings' => $settings]); ?>

    <div id="lightbox" class="hidden fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-6 cursor-zoom-out">
        <img id="lightbox-img" src="" alt="" class="max-h-[85vh] max-w-full rounded-lg shadow-2xl">
    </div>
</body>
</html>
