<?php
/**
 * =====================================================
 * CLUBEMIX - DASHBOARD REPRESENTANTE
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Dashboard para usuários representantes
 * =====================================================
 */

require_once '../includes/auth_check.php';
requireUserType('representante');

$user = getCurrentUser();
$userId = $user['id'];
$userEmail = $user['email'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClubeMix - Dashboard Representante</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .dashboard-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>🤝 Dashboard Representante</h1>
            <p>Bem-vindo, <?php echo htmlspecialchars($userEmail); ?>!</p>
            <p>Painel de controle de representantes do ClubeMix</p>
        </div>
        
        <div class="dashboard-content">
            <h2>✅ Login Realizado com Sucesso!</h2>
            <p>Você está acessando o dashboard de <strong>Representante</strong>.</p>
            
            <div style="margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h3>💼 Funcionalidades do Representante:</h3>
                <ul>
                    <li>Gerenciar rede de afiliados</li>
                    <li>Acompanhar comissões e bonificações</li>
                    <li>Relatórios de performance da equipe</li>
                    <li>Gestão de clientes indicados</li>
                    <li>Ferramentas de marketing</li>
                    <li>Suporte e tickets</li>
                </ul>
            </div>
            
            <p><em>Este é um painel de demonstração. As funcionalidades completas serão implementadas em breve.</em></p>
            
            <a href="../logout.php" class="logout-btn">🚪 Sair do Sistema</a>
        </div>
    </div>
</body>
</html>
