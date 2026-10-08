<?php

namespace App;

class Auth
{
    private const USERNAME = 'admin';
    private const PASSWORD = '123456';

    public static function check(): bool
    {
        return !empty($_SESSION['logged_in']);
    }

    public static function attempt(string $username, string $password): bool
    {
        if ($username === self::USERNAME && $password === self::PASSWORD) {
            $_SESSION['logged_in'] = true;
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
