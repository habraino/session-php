<?php
namespace app\middleware;

use app\models\Session;

class AuthMiddleware {
    public function handle() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        // Limpa sessões expiradas
        (new Session())->cleanupExpired();

        // Verifica token de sessão
        if (empty($_SESSION['auth_token'])) {
            $this->redirectToLogin();
        }

        $sessionModel = new Session();
        $session = $sessionModel->findByToken($_SESSION['auth_token']);

        if (!$session) {
            $this->redirectToLogin();
        }

        // Inicializa last_activity se não existir
        $_SESSION['last_activity'] = $_SESSION['last_activity'] ?? time();
        
        // Renova a sessão se estiver ativa
        $this->renewSessionIfNeeded($session);
    }

    private function renewSessionIfNeeded($session) {
        $sessionModel = new Session();
        $lastActivity = $_SESSION['last_activity'] ?? time();
        
        // Renova a sessão a cada 5 minutos de atividade
        if (time() - $lastActivity < 300) {
            $sessionModel->renew($session['token']);
            $_SESSION['last_activity'] = time();
        }
    }

    private function redirectToLogin() {
        $_SESSION['session_expired'] = true;
        header('Location: /login');
        exit;
    }

    public static function generateToken() {
        return bin2hex(random_bytes(32));
    }
}