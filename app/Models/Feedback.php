<?php

namespace App\Models;

use PDO;

class Feedback extends Conexao
{
    public const TYPES = ['bug', 'sugestão', 'reclamação', 'feedback'];

    public const STATUS = ['recebido', 'em análise', 'em desenvolvimento', 'finalizado'];

    public const MAX_TITLE = 150;
    public const MAX_DESCRIPTION = 2000;

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM feedbacks ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM feedbacks WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $record = $stmt->fetch();
        return $record ?: null;
    }

    public function create(string $titulo, string $descricao, string $tipo): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO feedbacks (titulo, descricao, tipo, status)
             VALUES (:titulo, :descricao, :tipo, :status)'
        );
        $stmt->execute([
            ':titulo'    => $titulo,
            ':descricao' => $descricao,
            ':tipo'      => $tipo,
            ':status'    => 'recebido',
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE feedbacks SET status = :status WHERE id = :id'
        );
        $stmt->execute([
            ':status' => $status,
            ':id'     => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public static function isValidType(string $tipo): bool
    {
        return in_array($tipo, self::TYPES, true);
    }

    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::STATUS, true);
    }
}
