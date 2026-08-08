<?php

declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

use App\Core\Auth;
use App\Core\AdminHelpers;
use App\Core\Csrf;
use App\Core\Sanitizer;
use App\Core\Uploader;
use App\Core\View;
use App\Models\ContentBlock;
use App\Models\ActivityLog;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AdminHelpers::requireCsrf('/admin/content-blocks.php?page=' . urlencode($_POST['page_key'] ?? ''));

    $pageKey = Sanitizer::str($_POST['page_key'] ?? '');
    $blockIds = $_POST['block_id'] ?? [];

    foreach ($blockIds as $blockId) {
        $blockId = (int) $blockId;
        $type = Sanitizer::str($_POST['block_type'][$blockId] ?? 'text');

        if ($type === 'image') {
            $uploadError = null;
            $imagePath = Uploader::storeImage($_FILES['image'][$blockId] ?? [], 'settings', $uploadError);
            if ($imagePath) {
                ContentBlock::updateContent($blockId, 'image', null, $imagePath, Auth::id());
            }
            continue;
        }

        $value = $type === 'richtext'
            ? Sanitizer::richText($_POST['content'][$blockId] ?? '')
            : Sanitizer::str($_POST['content'][$blockId] ?? '');

        ContentBlock::updateContent($blockId, $type, $value, null, Auth::id());
    }

    ActivityLog::record(Auth::id(), 'update', 'content_blocks', null, "Updated content blocks for page: {$pageKey}");
    flash_success('Page content updated.');
    redirect('/admin/content-blocks.php?page=' . urlencode($pageKey));
}

$grouped = ContentBlock::allGroupedByPage();
$activePage = $_GET['page'] ?? array_key_first($grouped);

View::renderAdmin('content-blocks', [
    'pageTitle' => 'Page Content',
    'grouped' => $grouped,
    'activePage' => $activePage,
]);
