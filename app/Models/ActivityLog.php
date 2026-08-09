<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class ActivityLog
{
    public static function record(?int $adminId, string $action, ?string $entityType = null, ?int $entityId = null, ?string $description = null): void
    {
        Database::insert('activity_log', [
            'admin_id' => $adminId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    }

    public static function recent(int $limit = 20): array
    {
        return Database::fetchAll(
            'SELECT al.*, a.name AS admin_name FROM activity_log al
             LEFT JOIN admins a ON a.id = al.admin_id
             ORDER BY al.created_at DESC LIMIT ' . (int) $limit
        );
    }
}
