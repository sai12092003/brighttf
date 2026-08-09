<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class ContactSubmission
{
    public static function create(array $data): int
    {
        return Database::insert('contact_submissions', $data);
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM contact_submissions ORDER BY created_at DESC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM contact_submissions WHERE id = ?', [$id]);
    }

    public static function countNew(): int
    {
        $row = Database::fetch("SELECT COUNT(*) AS cnt FROM contact_submissions WHERE status = 'new'");
        return (int) ($row['cnt'] ?? 0);
    }

    public static function updateStatus(int $id, string $status): void
    {
        Database::execute('UPDATE contact_submissions SET status = ? WHERE id = ?', [$status, $id]);
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM contact_submissions WHERE id = ?', [$id]);
    }
}
