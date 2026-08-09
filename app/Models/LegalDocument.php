<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class LegalDocument
{
    public static function allPublic(): array
    {
        return Database::fetchAll('SELECT * FROM legal_documents WHERE is_public = 1 ORDER BY sort_order ASC');
    }

    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM legal_documents ORDER BY sort_order ASC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM legal_documents WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        return Database::insert('legal_documents', $data);
    }

    public static function update(int $id, array $data): void
    {
        $set = implode(', ', array_map(static fn(string $c): string => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        Database::execute("UPDATE legal_documents SET {$set} WHERE id = :id", array_combine(
            array_map(static fn(string $c): string => ':' . $c, array_keys($data)),
            array_values($data)
        ));
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM legal_documents WHERE id = ?', [$id]);
    }
}
