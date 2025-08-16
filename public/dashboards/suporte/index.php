<?php
/**
 * =====================================================
 * CLUBEMIX - DASHBOARD SUPORTE
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Dashboard para usuários de suporte
 * =====================================================
 */

require_once '../includes/auth_check.php';
requireUserType('suporte');

$user = getCurrentUser();
$userId = $user['id'];
$userEmail = $user['email'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClubeMix - Dashboard Suporte</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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
            <h1>🆘 Dashboard Suporte</h1>
            <p>Bem-vindo, <?php echo htmlspecialchars($userEmail); ?>!</p>
            <p>Painel de controle de suporte do ClubeMix</p>
        </div>
        
        <div class="dashboard-content">
            <h2>✅ Login Realizado com Sucesso!</h2>
            <p>Você está acessando o dashboard de <strong>Suporte</strong>.</p>
            
            <div style="margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h3>💼 Funcionalidades do Suporte:</h3>
                <ul>
                    <li>Gerenciar tickets de suporte</li>
                    <li>Atender solicitações dos usuários</li>
                    <li>Base de conhecimento e FAQs</li>
                    <li>Relatórios de atendimento</li>
                    <li>Escalação de problemas</li>
                    <li>Chat em tempo real</li>
                </ul>
            </div>
            
            <p><em>Este é um painel de demonstração. As funcionalidades completas serão implementadas em breve.</em></p>
            
            <a href="../logout.php" class="logout-btn">🚪 Sair do Sistema</a>
        </div>
    </div>
</body>
</html>
