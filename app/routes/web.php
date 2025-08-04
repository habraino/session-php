<?php
use app\controllers\AuthController;
use app\controllers\HomeController;
use app\middleware\AuthMiddleware;

return [
    'GET' => [
        '/' => [
            'controller' => HomeController::class,
            'method' => 'index'
        ],
        '/home' => [
            'middleware' => AuthMiddleware::class,
            'controller' => HomeController::class,
            'method' => 'index'
        ],
        '/login' => [
            'controller' => AuthController::class,
            'method' => 'showLogin'
        ],
        '/register' => [
            'controller' => AuthController::class,
            'method' => 'showRegister'
        ],
        '/logout' => [
            'controller' => AuthController::class,
            'method' => 'logout'
        ],
        '/auth/session-status' => [AuthController::class, 'sessionStatus'],
    ],
    'POST' => [
        '/login' => [
            'controller' => AuthController::class,
            'method' => 'login'
        ],
        '/register' => [
            'controller' => AuthController::class,
            'method' => 'register'
        ]
    ]
];