<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class ScholarshipApplication
{
    public static function create(array $data): int
    {
        return Database::insert('scholarship_applications', $data);
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM scholarship_applications ORDER BY created_at DESC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM scholarship_applications WHERE id = ?', [$id]);
    }

    public static function countNew(): int
    {
        $row = Database::fetch("SELECT COUNT(*) AS cnt FROM scholarship_applications WHERE status = 'new'");
        return (int) ($row['cnt'] ?? 0);
    }

    public static function updateStatus(int $id, string $status, ?string $notes = null): void
    {
        Database::execute(
            'UPDATE scholarship_applications SET status = ?, admin_notes = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?',
            [$status, $notes, $id]
        );
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM scholarship_applications WHERE id = ?', [$id]);
    }
}
