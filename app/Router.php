<?php

namespace App;

class Router
{
    private array $routes = [];

    public function get(string $path, array $action, bool $protected = false): void
    {
        $this->add('GET', $path, $action, $protected);
    }

    public function post(string $path, array $action, bool $protected = false): void
    {
        $this->add('POST', $path, $action, $protected);
    }

    public function put(string $path, array $action, bool $protected = false): void
    {
        $this->add('PUT', $path, $action, $protected);
    }

    private function add(string $method, string $path, array $action, bool $protected): void
    {
        $this->routes[] = [
            'method'    => $method,
            'path'      => $path,
            'action'    => $action,
            'protected' => $protected,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = $this->normalize($uri);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = $this->matchRoute($route['path'], $uri);
            if ($params === null) {
                continue;
            }

            if ($route['protected'] && !Auth::check()) {
                header('Location: /login');
                return;
            }

            if ($route['protected']) {
                header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
                header('Pragma: no-cache');
                header('Expires: 0');
            }

            $this->execute($route['action'], $params);
            return;
        }

        http_response_code(404);
        View::render('erro_view', [
            'title'   => 'Página não encontrada',
            'message' => 'A página solicitada não existe (404).',
        ]);
    }

    private function normalize(string $uri): string
    {
        $uri = rtrim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    private function matchRoute(string $path, string $uri): ?array
    {
        $regex = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $path);
        $regex = '#^' . $regex . '$#';

        if (!preg_match($regex, $uri, $matches)) {
            return null;
        }

        array_shift($matches);
        return $matches;
    }

    private function execute(array $action, array $params): void
    {
        [$class, $method] = $action;
        $controller = new $class();
        $controller->$method(...$params);
    }
}
