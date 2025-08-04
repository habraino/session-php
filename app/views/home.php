<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .transition-all {
            transition: all 0.3s ease;
        }

        #session-timer {
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
            transition: color 0.3s ease;
        }

        #session-timer.warning {
            color: #f59e0b;
        }

        #session-timer.danger {
            color: #ef4444;
            animation: pulse 1s infinite;
        }

        .animate-spin {
            animation: spin 1s linear;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lock-open text-2xl"></i>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="/home" class="px-3 py-2 rounded-md text-sm font-medium bg-black bg-opacity-25">Dashboard</a>
                            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-black hover:bg-opacity-10">Perfil</a>
                            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-black hover:bg-opacity-10">Configurações</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['name']) ?>&background=random" alt="Avatar">
                                <a href="/logout" class="text-sm text-white hover:text-gray-200 ml-2">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Banner -->
        <div class="gradient-bg text-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Bem-vindo, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h1>
                    <p class="mt-2 opacity-90">Você está logado como <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-user-shield text-5xl opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Sessões Ativas Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Sessão Ativa</h3>
                                    <p class="text-sm text-gray-500"><?= $activeSessions ?> dispositivo(s) conectado(s)</p>
                                </div>
                                <button onclick="syncSessionTimer()" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <div class="mt-2 flex items-baseline">
                                <p class="text-sm text-gray-500 mr-2">Tempo restante:</p>
                                <p id="session-timer" class="font-mono text-lg font-bold text-blue-600">00:00:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Segurança</h3>
                            <p class="mt-1 text-sm text-gray-500">Conta protegida</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Configurações</h3>
                            <p class="mt-1 text-sm text-gray-500">Personalize sua conta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessões Ativas Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Suas Sessões Ativas</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <?php if ($activeSessions > 0): ?>
                    <div class="p-6 hover:bg-gray-50 transition-all">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full text-blue-600">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Esta sessão</p>
                                <p class="text-sm text-gray-500">Dispositivo atual - <?= $_SERVER['HTTP_USER_AGENT'] ?></p>
                                <p class="text-xs text-gray-400 mt-1">IP: <?= $_SERVER['REMOTE_ADDR'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($activeSessions > 1): ?>
                        <div class="p-6 hover:bg-gray-50 transition-all">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-100 p-2 rounded-full text-yellow-600">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Outra sessão ativa</p>
                                    <p class="text-sm text-gray-500"><?= $activeSessions - 1 ?> dispositivo(s) adicional(is)</p>
                                    <a href="/sessions" class="text-xs text-blue-600 hover:underline mt-1">Gerenciar sessões</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-500">
                        Nenhuma outra sessão ativa no momento
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500">
                &copy; <?= date('Y') ?> Sistema de Autenticação. Todos os direitos reservados.
            </p>
        </div>
    </footer>
</body>
<script>
// Timer de sessão persistente
function updateSessionTimer() {
    // Tenta obter o tempo restante do localStorage
    let remaining = localStorage.getItem('sessionRemaining');
    
    if (remaining === null) {
        // Se não existir no localStorage, calcula do servidor
        const sessionExpires = <?= $sessionExpires ?>;
        const now = Math.floor(Date.now() / 1000);
        remaining = sessionExpires - now;
    } else {
        remaining = parseInt(remaining);
    }
    
    // Atualiza o localStorage com o novo valor
    localStorage.setItem('sessionRemaining', remaining - 1);
    
    if (remaining <= 0) {
        localStorage.removeItem('sessionRemaining');
        document.getElementById('session-timer').innerHTML = 'Sessão expirada';
        window.location.href = '/login?session_expired=1';
        return;
    }
    
    const hours = Math.floor(remaining / 3600);
    const minutes = Math.floor((remaining % 3600) / 60);
    const seconds = remaining % 60;
    
    document.getElementById('session-timer').innerHTML = 
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    // Atualiza a cada segundo
    setTimeout(updateSessionTimer, 1000);
}

function syncSessionTimer() {
    fetch('/auth/session-status')
        .then(response => response.json())
        .then(data => {
            if (data.remaining <= 0) {
                window.location.href = '/login?session_expired=1';
            } else {
                localStorage.setItem('sessionRemaining', data.remaining);
                updateSessionTimer();
                // Feedback visual
                const icon = document.querySelector('[onclick="syncSessionTimer"] i');
                icon.classList.add('animate-spin');
                setTimeout(() => icon.classList.remove('animate-spin'), 1000);
            }
        });
}


// Inicia o timer quando a página carrega
document.addEventListener('DOMContentLoaded', function() {
    updateSessionTimer();
    
    // Verificação periódica com o servidor
    setInterval(function() {
        fetch('/auth/session-status')
            .then(response => response.json())
            .then(data => {
                if (data.remaining <= 0) {
                    localStorage.removeItem('sessionRemaining');
                    window.location.href = '/login?session_expired=1';
                } else {
                    // Sincroniza com o servidor
                    localStorage.setItem('sessionRemaining', data.remaining);
                }
            });
    }, 30000); // Verifica a cada 30 segundos
});

// Limpa o localStorage ao fazer logout
document.querySelector('[href="/logout"]').addEventListener('click', function() {
    localStorage.removeItem('sessionRemaining');
});
</script>
</script>
</html>