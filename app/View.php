<?php

namespace App;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        ob_start();
        require __DIR__ . '/Views/' . $view . '.php';
        $content = ob_get_clean();

        $title = $data['title'] ?? 'Sistema de Feedback';
        require __DIR__ . '/Views/layout.php';
    }

    public static function e(?string $text): string
    {
        return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
    }

    public static function statusSlug(string $status): string
    {
        $map = [
            'recebido'           => 'received',
            'em análise'         => 'analysis',
            'em desenvolvimento' => 'development',
            'finalizado'         => 'finished',
        ];
        return $map[$status] ?? 'received';
    }
}
