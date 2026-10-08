<?php

namespace App\Controllers;

use App\Models\Feedback;
use App\View;

class FeedbackController
{
    private Feedback $feedback;

    public function __construct()
    {
        $this->feedback = new Feedback();
    }

    public function form(): void
    {
        View::render('formulario_view', [
            'title'   => 'Enviar Feedback',
            'types'   => Feedback::TYPES,
            'success' => isset($_GET['success']),
            'error'   => $_GET['error'] ?? null,
        ]);
    }

    public function index(): void
    {
        View::render('feedbacks_view', [
            'title'     => 'Feedbacks',
            'feedbacks' => $this->feedback->findAll(),
        ]);
    }

    public function show(string $id): void
    {
        if (!ctype_digit($id)) {
            $this->error('Identificador de feedback inválido.', 400);
            return;
        }

        $feedback = $this->feedback->findById((int) $id);
        if ($feedback === null) {
            $this->error('Feedback não encontrado.', 404);
            return;
        }

        View::render('feedbacks_show_view', [
            'title'      => 'Feedback #' . $feedback['id'],
            'feedback'   => $feedback,
            'statusList' => Feedback::STATUS,
        ]);
    }

    public function store(): void
    {
        $titulo    = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $tipo      = $_POST['tipo'] ?? '';

        if ($titulo === '' || $descricao === '') {
            $this->redirect('/?error=' . rawurlencode('Preencha título e descrição.'));
            return;
        }
        if (mb_strlen($titulo) > Feedback::MAX_TITLE) {
            $this->redirect('/?error=' . rawurlencode('O título deve ter no máximo ' . Feedback::MAX_TITLE . ' caracteres.'));
            return;
        }
        if (mb_strlen($descricao) > Feedback::MAX_DESCRIPTION) {
            $this->redirect('/?error=' . rawurlencode('A descrição deve ter no máximo ' . Feedback::MAX_DESCRIPTION . ' caracteres.'));
            return;
        }
        if (!Feedback::isValidType($tipo)) {
            $this->redirect('/?error=' . rawurlencode('Tipo de feedback inválido.'));
            return;
        }

        $this->feedback->create($titulo, $descricao, $tipo);

        $this->redirect('/?success=1');
    }

    public function update(?string $id = null, ?string $status = null): void
    {
        $id     = $id     ?? ($_POST['id'] ?? null);
        $status = $status ?? ($_POST['status'] ?? null);

        if (!ctype_digit((string) $id)) {
            $this->error('Identificador de feedback inválido.', 400);
            return;
        }
        if (!Feedback::isValidStatus((string) $status)) {
            $this->error('Status inválido.', 400);
            return;
        }

        $existing = $this->feedback->findById((int) $id);
        if ($existing === null) {
            $this->error('Feedback não encontrado.', 404);
            return;
        }

        $this->feedback->updateStatus((int) $id, (string) $status);

        $this->redirect('/feedbacks/' . (int) $id);
    }

    private function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    private function error(string $message, int $code): void
    {
        http_response_code($code);
        View::render('erro_view', [
            'title'   => 'Erro',
            'message' => $message,
        ]);
    }
}
