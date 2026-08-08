<?php
/** @var array $global */
use App\Models\ContentBlock;

$blocks = ContentBlock::forPage('error_404');
?>
<section class="section">
    <div class="container-custom text-center max-w-xl">
        <p class="eyebrow">404</p>
        <h1 class="section-title"><?= e($blocks['heading'] ?? 'Page Not Found') ?></h1>
        <p class="section-lede mx-auto"><?= e($blocks['message'] ?? "The page you're looking for doesn't exist or may have moved.") ?></p>
        <a href="<?= base_url($blocks['cta_link'] ?? '/') ?>" class="btn-primary mt-8">
            <?= e($blocks['cta_text'] ?? 'Back to Home') ?>
        </a>
    </div>
</section>
