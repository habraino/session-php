<?php
namespace app\controllers;

use app\models\User;
use app\models\Session;
use app\middleware\AuthMiddleware;

class AuthController {
    public function showLogin() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && $userModel->verifyPassword($user, $password)) {
            $this->createSession($user);
            header('Location: /home');
            exit;
        }

        // Se falhar, mostra erro
        $error = "Credenciais inválidas";
        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        require __DIR__ . '/../views/auth/register.php';
    }

    public function register() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm) {
            $error = "As senhas não coincidem";
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $error = "Email já cadastrado";
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        if ($userModel->create($name, $email, $password)) {
            header('Location: /login');
            exit;
        }

        $error = "Erro ao cadastrar usuário";
        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {
        session_start();
        if (!empty($_SESSION['auth_token'])) {
            $sessionModel = new Session();
            $sessionModel->delete($_SESSION['auth_token']);
        }
        
        session_destroy();
        header('Location: /login');
        exit;
    }

    private function createSession($user) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $token = AuthMiddleware::generateToken();
        
        $sessionModel = new Session();
        $sessionModel->create(
            $user['id'],
            $token,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        );

        $_SESSION = [
            'auth_token' => $token,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ],
            'last_activity' => time()
        ];
    }

    public function sessionStatus() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $response = [
            'active' => false,
            'remaining' => 0
        ];

        if (!empty($_SESSION['auth_token'])) {
            $sessionModel = new Session();
            $session = $sessionModel->findByToken($_SESSION['auth_token']);
            
            if ($session) {
                $expires = strtotime($session['expires_at']);
                $remaining = $expires - time();
                
                $response = [
                    'active' => true,
                    'remaining' => $remaining > 0 ? $remaining : 0
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}