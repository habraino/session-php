<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Carrega variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurações de erro
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carrega rotas
$routes = require __DIR__ . '../../app/routes/web.php';

// Obtém método HTTP e path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';

// Verifica se a rota existe
if (isset($routes[$method][$path])) {
    $route = $routes[$method][$path];
    
    // Processa middleware se existir
    if (isset($route['middleware'])) {
        $middleware = new $route['middleware']();
        $middleware->handle();
    }
    
    // Obtém controller e método
    $controllerClass = $route['controller'] ?? $route[0];
    $method = $route['method'] ?? $route[1];
    
    // Verifica se a classe e método existem
    if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
        $controller = new $controllerClass();
        $controller->$method();
    } else {
        http_response_code(500);
        die("Controller ou método inválido");
    }
} else {
    http_response_code(404);
    die("Página não encontrada");
}