<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class DonationPledge
{
    public static function create(array $data): int
    {
        return Database::insert('donation_pledges', $data);
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM donation_pledges ORDER BY created_at DESC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM donation_pledges WHERE id = ?', [$id]);
    }

    public static function countNew(): int
    {
        $row = Database::fetch("SELECT COUNT(*) AS cnt FROM donation_pledges WHERE status = 'new'");
        return (int) ($row['cnt'] ?? 0);
    }

    public static function updateStatus(int $id, string $status, ?string $notes = null): void
    {
        Database::execute(
            'UPDATE donation_pledges SET status = ?, admin_notes = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?',
            [$status, $notes, $id]
        );
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM donation_pledges WHERE id = ?', [$id]);
    }
}
