<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class VolunteerPartnerSubmission
{
    public static function create(array $data): int
    {
        return Database::insert('volunteer_partner_submissions', $data);
    }

    public static function all(?string $type = null): array
    {
        if ($type !== null) {
            return Database::fetchAll(
                'SELECT * FROM volunteer_partner_submissions WHERE submission_type = ? ORDER BY created_at DESC',
                [$type]
            );
        }
        return Database::fetchAll('SELECT * FROM volunteer_partner_submissions ORDER BY created_at DESC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM volunteer_partner_submissions WHERE id = ?', [$id]);
    }

    public static function countNew(): int
    {
        $row = Database::fetch("SELECT COUNT(*) AS cnt FROM volunteer_partner_submissions WHERE status = 'new'");
        return (int) ($row['cnt'] ?? 0);
    }

    public static function updateStatus(int $id, string $status, ?string $notes = null): void
    {
        Database::execute(
            'UPDATE volunteer_partner_submissions SET status = ?, admin_notes = ? WHERE id = ?',
            [$status, $notes, $id]
        );
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM volunteer_partner_submissions WHERE id = ?', [$id]);
    }
}
