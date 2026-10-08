<?php

declare(strict_types=1);

use App\Router;
use App\View;

require __DIR__ . '/../vendor/autoload.php';

set_exception_handler(function (\Throwable $e): void {
    http_response_code(500);
    View::render('erro_view', [
        'title'   => 'Erro',
        'message' => 'Ocorreu um erro ao processar a solicitação. Tente novamente.',
    ]);
});

session_start();

$router = new Router();

require __DIR__ . '/../rotas.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

$router->dispatch($method, $uri);
