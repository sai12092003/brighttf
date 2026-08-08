<?php

declare(strict_types=1);

namespace App\Core;

final class Uploader
{
    private const ALLOWED_IMAGE_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    private const ALLOWED_DOC_TYPES = [
        'application/pdf' => 'pdf',
    ];

    private const MAX_IMAGE_BYTES = 5 * 1024 * 1024; // 5MB
    private const MAX_DOC_BYTES = 10 * 1024 * 1024; // 10MB

    /**
     * Validate and move an uploaded image into public_html/uploads/{subdir}.
     * Returns the relative path (e.g. "team/ab12cd34.jpg") on success, or
     * null with $error populated on failure.
     */
    public static function storeImage(array $file, string $subdir, ?string &$error = null): ?string
    {
        return self::store($file, $subdir, self::ALLOWED_IMAGE_TYPES, self::MAX_IMAGE_BYTES, $error);
    }

    public static function storeDocument(array $file, string $subdir, ?string &$error = null): ?string
    {
        return self::store($file, $subdir, self::ALLOWED_DOC_TYPES, self::MAX_DOC_BYTES, $error);
    }

    private static function store(array $file, string $subdir, array $allowedTypes, int $maxBytes, ?string &$error): ?string
    {
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $error = null;
            return null; // no file submitted — not necessarily an error for optional fields
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = 'Upload failed (error code ' . $file['error'] . ').';
            return null;
        }

        if ($file['size'] > $maxBytes) {
            $error = 'File is too large. Maximum size is ' . (int) ($maxBytes / 1024 / 1024) . 'MB.';
            return null;
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            $error = 'Invalid upload.';
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!isset($allowedTypes[$mime])) {
            $error = 'Unsupported file type.';
            return null;
        }

        $extension = $allowedTypes[$mime];
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;

        $uploadRoot = rtrim((string) config('paths.uploads'), '/');
        $targetDir = $uploadRoot . '/' . trim($subdir, '/');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            $error = 'Could not save uploaded file.';
            return null;
        }

        chmod($targetPath, 0644);

        return trim($subdir, '/') . '/' . $filename;
    }
}
