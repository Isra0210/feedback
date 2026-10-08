<?php

namespace App\Controllers;

use App\Auth;
use App\View;

class AuthController
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            header('Location: /feedbacks');
            return;
        }

        View::render('login_view', [
            'title' => 'Login',
            'error' => null,
        ]);
    }

    public function login(): void
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::attempt($username, $password)) {
            header('Location: /feedbacks');
            exit;
        }

        http_response_code(401);
        View::render('login_view', [
            'title' => 'Login',
            'error' => 'Usuário ou senha inválidos.',
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: /');
        exit;
    }
}
