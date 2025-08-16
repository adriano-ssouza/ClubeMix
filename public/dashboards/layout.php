<?php
/**
 * =====================================================
 * CLUBEMIX - LAYOUT COMPARTILHADO DOS DASHBOARDS
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Layout base para todos os dashboards
 * =====================================================
 */

// Verificar se o usuário está logado (comentado temporariamente)
// require_once dirname(__DIR__) . '/includes/auth_check.php';
// requireLogin();

// Simular dados de usuário para teste
$userType = 'admin';
$userId = 1;
$userEmail = 'admin@clubemix.com';

// Carregar configurações do dashboard
require_once dirname(__FILE__) . '/config.php';
$dashboardConfig = getDashboardConfig($userType);
$themeColors = getThemeColors($userType);

// Log da atividade
logDashboardActivity($userId, $userType, 'page_access', $_SERVER['PHP_SELF']);

// Verificar se a página atual requer permissões específicas
if (isset($requiredPermission) && !checkPermission($userType, $requiredPermission)) {
    header('Location: ../login.php?error=unauthorized');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dashboardConfig['title']; ?> - ClubeMix</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    
    <style>
        :root {
            --primary-color: <?php echo $themeColors['primary']; ?>;
            --secondary-color: <?php echo $themeColors['secondary']; ?>;
            --dark-color: #212529;
            --white-color: #ffffff;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .dashboard-sidebar {
            width: 280px;
            background: var(--white-color);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white-color);
            padding: 30px 20px;
            text-align: center;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .sidebar-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* Navegação */
        .dashboard-nav {
            padding: 20px 0;
        }

        .nav-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            margin: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: var(--light-gray);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-link.active {
            background: var(--light-gray);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-link i {
            width: 20px;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        /* Conteúdo principal */
        .dashboard-main {
            flex: 1;
            margin-left: 280px;
            padding: 20px;
        }

        .dashboard-header {
            background: var(--white-color);
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .dashboard-title {
            margin: 0;
            color: var(--dark-color);
            font-size: 2rem;
            font-weight: 700;
        }

        .dashboard-subtitle {
            color: var(--text-muted);
            margin: 10px 0 0 0;
        }

        /* Breadcrumb */
        .breadcrumb-nav {
            margin-bottom: 20px;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        /* Conteúdo do dashboard */
        .dashboard-content {
            background: var(--white-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        /* Botão de logout */
        .logout-btn {
            background: #dc3545;
            color: var(--white-color);
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c82333;
            color: var(--white-color);
            transform: translateY(-2px);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .dashboard-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .dashboard-sidebar.show {
                transform: translateX(0);
            }

            .dashboard-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
                background: var(--primary-color);
                color: var(--white-color);
                border: none;
                padding: 10px;
                border-radius: 5px;
            }
        }

        .sidebar-toggle {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Botão toggle para mobile -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <div class="sidebar-header">
                <h3>🎯 ClubeMix</h3>
                <p><?php echo $dashboardConfig['title']; ?></p>
            </div>
            
            <?php echo generateNavigationMenu($userType); ?>
            
            <div style="padding: 20px; text-align: center;">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                    Usuário: <?php echo htmlspecialchars($userEmail); ?>
                </p>
                <a href="../../logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </aside>

        <!-- Conteúdo principal -->
        <main class="dashboard-main">
            <div class="dashboard-header">
                <h1 class="dashboard-title"><?php echo $dashboardConfig['title']; ?></h1>
                <p class="dashboard-subtitle">Bem-vindo ao seu painel de controle</p>
            </div>

            <?php echo generateBreadcrumb($userType, $pageTitle ?? ''); ?>

            <div class="dashboard-content">
                <!-- O conteúdo específico de cada página será inserido aqui -->
                <?php if (isset($dashboardContent)): ?>
                    <?php echo $dashboardContent; ?>
                <?php else: ?>
                    <p>Conteúdo do dashboard será carregado aqui.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Toggle da sidebar em dispositivos móveis
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('dashboardSidebar').classList.toggle('show');
        });

        // Fechar sidebar ao clicar fora em dispositivos móveis
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('dashboardSidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Log de atividades do usuário
        function logUserActivity(action, details = '') {
            fetch('../../api/log/activity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    details: details,
                    user_id: <?php echo $userId; ?>,
                    user_type: '<?php echo $userType; ?>'
                })
            }).catch(error => console.log('Erro ao registrar atividade:', error));
        }

        // Registrar atividade ao carregar a página
        logUserActivity('page_view', window.location.pathname);
    </script>
</body>
</html>
