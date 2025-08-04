<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acessar Sistema | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.2);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center">
    <div class="w-full max-w-md mx-auto p-6">
        <!-- Logo/Cabeçalho -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Bem-vindo de volta</h1>
            <p class="text-gray-600 mt-2">Entre na sua conta para continuar</p>
        </div>

        <!-- Mensagens de Alerta -->
        <?php if (isset($_SESSION['session_expired'])): ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-yellow-400 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">Sua sessão expirou. Por favor, faça login novamente.</p>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['session_expired']); ?>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulário -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all">
            <div class="p-8">
                <form action="/login" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Endereço de Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm input-focus py-3 transition-all"
                                   placeholder="seu@email.com">
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                            <a href="/forgot-password" class="text-xs text-indigo-600 hover:text-indigo-500">Esqueceu a senha?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm input-focus py-3 transition-all"
                                   placeholder="••••••••">
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Lembrar de mim</label>
                    </div>
                    
                    <button type="submit" class="w-full gradient-bg text-white py-3 px-4 rounded-md font-medium btn-hover transition-all flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                    </button>
                </form>
            </div>
            
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                <p class="text-sm text-center text-gray-600">
                    Não tem uma conta? 
                    <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">Cadastre-se</a>
                </p>
            </div>
        </div>
        
        <!-- Rodapé -->
        <div class="mt-8 text-center text-xs text-gray-500">
            <p>© <?= date('Y') ?> Nome da Empresa. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        // Validação simples do formulário
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos.');
            }
        });
    </script>
</body>
</html>