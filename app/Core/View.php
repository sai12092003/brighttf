<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\SiteSetting;
use App\Models\SeoMeta;
use App\Models\ContentBlock;

final class View
{
    public static function renderPublic(string $view, array $data = [], string $pageKey = ''): void
    {
        $settings = SiteSetting::all();
        $seo = $pageKey !== '' ? SeoMeta::forPage($pageKey) : null;
        $global = ContentBlock::forPage('global');

        extract($data, EXTR_SKIP);
        $viewFile = dirname(__DIR__) . '/views/public/' . $view . '.php';

        ob_start();
        if (is_file($viewFile)) {
            require $viewFile;
        } else {
            echo '<p>View not found: ' . e($view) . '</p>';
        }
        $content = ob_get_clean();

        require dirname(__DIR__) . '/views/partials/layout.php';
    }

    public static function renderAdmin(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = dirname(__DIR__) . '/views/admin/' . $view . '.php';

        ob_start();
        if (is_file($viewFile)) {
            require $viewFile;
        } else {
            echo '<p>Admin view not found: ' . e($view) . '</p>';
        }
        $content = ob_get_clean();

        require dirname(__DIR__) . '/views/admin/_layout.php';
    }

    public static function partial(string $name, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $file = dirname(__DIR__) . '/views/partials/' . $name . '.php';
        if (is_file($file)) {
            require $file;
        }
    }
}
