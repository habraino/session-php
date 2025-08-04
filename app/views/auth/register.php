<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta | Registro</title>
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
        .password-strength {
            height: 4px;
            margin-top: 4px;
            background-color: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center">
    <div class="w-full max-w-md mx-auto p-6">
        <!-- Logo/Cabeçalho -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Crie sua conta</h1>
            <p class="text-gray-600 mt-2">Preencha os campos para se registrar</p>
        </div>

        <!-- Mensagens de Erro -->
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
                <form action="/register" method="POST" class="space-y-6" id="registerForm">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="name" name="name" required
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm input-focus py-3 transition-all"
                                   placeholder="Seu nome completo">
                        </div>
                    </div>
                    
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
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm input-focus py-3 transition-all"
                                   placeholder="••••••••"
                                   oninput="checkPasswordStrength(this.value)">
                            <div class="password-strength">
                                <div class="password-strength-bar" id="passwordStrengthBar"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                A senha deve conter pelo menos 8 caracteres, incluindo números e letras maiúsculas.
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm input-focus py-3 transition-all"
                                   placeholder="••••••••"
                                   oninput="checkPasswordMatch()">
                            <div id="passwordMatch" class="text-xs mt-1"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Eu concordo com os <a href="#" class="text-indigo-600 hover:text-indigo-500">Termos de Serviço</a> e <a href="#" class="text-indigo-600 hover:text-indigo-500">Política de Privacidade</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full gradient-bg text-white py-3 px-4 rounded-md font-medium btn-hover transition-all flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i> Criar Conta
                    </button>
                </form>
            </div>
            
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                <p class="text-sm text-center text-gray-600">
                    Já tem uma conta? 
                    <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">Faça login</a>
                </p>
            </div>
        </div>
        
        <!-- Rodapé -->
        <div class="mt-8 text-center text-xs text-gray-500">
            <p>© <?= date('Y') ?> Nome da Empresa. Todos os direitos reservados.</p>
        </div>
    </div>

    <script>
        // Verifica força da senha
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrengthBar');
            let strength = 0;
            
            // Verifica comprimento
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;
            
            // Verifica caracteres diversos
            if (password.match(/[a-z]/)) strength += 15;
            if (password.match(/[A-Z]/)) strength += 15;
            if (password.match(/[0-9]/)) strength += 10;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 10;
            
            // Atualiza barra de força
            strengthBar.style.width = Math.min(strength, 100) + '%';
            
            // Atualiza cor
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#ef4444'; // Vermelho
            } else if (strength < 70) {
                strengthBar.style.backgroundColor = '#f59e0b'; // Amarelo
            } else {
                strengthBar.style.backgroundColor = '#10b981'; // Verde
            }
        }
        
        // Verifica se as senhas coincidem
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchElement = document.getElementById('passwordMatch');
            
            if (confirmPassword.length === 0) {
                matchElement.textContent = '';
                matchElement.style.color = '';
            } else if (password === confirmPassword) {
                matchElement.textContent = 'As senhas coincidem!';
                matchElement.style.color = '#10b981'; // Verde
            } else {
                matchElement.textContent = 'As senhas não coincidem!';
                matchElement.style.color = '#ef4444'; // Vermelho
            }
        }
        
        // Validação do formulário
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('As senhas não coincidem. Por favor, verifique novamente.');
            }
        });
    </script>
</body>
</html>