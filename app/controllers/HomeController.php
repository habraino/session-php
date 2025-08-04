<?php
namespace app\controllers;

use app\middleware\AuthMiddleware;

class HomeController {
    public function index() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $sessionModel = new \app\models\Session();
        $activeSessions = $sessionModel->countActiveSessions($_SESSION['user']['id']);
        $session = $sessionModel->findByToken($_SESSION['auth_token']);
        
        // Passa o timestamp de expiração para a view
        $sessionExpires = strtotime($session['expires_at']);
        
        require __DIR__ . '/../views/home.php';
    }
}