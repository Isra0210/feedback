<?php

namespace App\Models;

use PDO;

class Conexao
{
    protected PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        $dir = dirname($config['sqlite_path']);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $newDatabase = !file_exists($config['sqlite_path']);

        $this->pdo = new PDO('sqlite:' . $config['sqlite_path']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if ($newDatabase || !$this->tableExists('feedbacks')) {
            $sql = file_get_contents($config['schema_path']);
            if ($sql !== false) {
                $this->pdo->exec($sql);
            }
        }
    }

    private function tableExists(string $table): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT name FROM sqlite_master WHERE type = 'table' AND name = :name"
        );
        $stmt->execute([':name' => $table]);
        return (bool) $stmt->fetch();
    }
}
