<?php

use App\Controllers\FeedbackController;
use App\Controllers\AuthController;

$router->get('/', [FeedbackController::class, 'form']);
$router->post('/feedback/cadastrar', [FeedbackController::class, 'store']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/feedbacks', [FeedbackController::class, 'index'], true);
$router->get('/feedbacks/{idFeedback}', [FeedbackController::class, 'show'], true);
$router->put('/feedback/atualizar', [FeedbackController::class, 'update'], true);
