<?php
/** @var array $settings */
/** @var array|null $seo */
/** @var string|null $title */
/** @var string|null $metaDescription */

$pageTitle = $title ?? $settings['default_meta_title'] ?? 'Bright Today Foundation';
$fullTitle = str_contains($pageTitle, 'Bright Today Foundation') ? $pageTitle : $pageTitle . ' | Bright Today Foundation';
$metaTitle = ($seo['meta_title'] ?? '') !== '' ? $seo['meta_title'] : $fullTitle;
$description = $metaDescription ?? (($seo['meta_description'] ?? '') !== '' ? $seo['meta_description'] : ($settings['default_meta_description'] ?? ''));
$ogImage = ($seo['og_image'] ?? '') !== '' ? base_url($seo['og_image']) : asset('img/og-default.jpg');
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($metaTitle) ?></title>
<meta name="description" content="<?= e($description) ?>">
<link rel="canonical" href="<?= e($seo['canonical_url'] ?? base_url($_SERVER['REQUEST_URI'] ?? '/')) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="Bright Today Foundation">
<meta property="og:title" content="<?= e($metaTitle) ?>">
<meta property="og:description" content="<?= e($description) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">

<link rel="icon" type="image/png" sizes="32x32" href="<?= asset('img/favicon-32x32.png') ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= asset('img/favicon-16x16.png') ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?= asset('img/apple-touch-icon.png') ?>">

<link rel="stylesheet" href="<?= asset('css/app.min.css') ?>?v=<?= @filemtime(config('paths.public') . '/assets/css/app.min.css') ?: 1 ?>">
