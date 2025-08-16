<?php
/**
 * =====================================================
 * CLUBEMIX - ROTEAMENTO DE DASHBOARDS
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Roteamento para dashboards específicos por tipo de usuário
 * =====================================================
 */

// Iniciar buffer de saída para evitar problemas de headers
ob_start();

// Iniciar sessão se necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/auth_check.php';
requireLogin();

$user = getCurrentUser();
$userType = $user['type'];
$userId = $user['id'];

// Roteamento baseado no tipo de usuário
switch ($userType) {
            case 'admin':
            header('Location: dashboards/admin/');
            break;
            
        case 'cliente':
            header('Location: dashboards/cliente/');
            break;
            
        case 'empresa':
            header('Location: dashboards/empresa/');
            break;
            
        case 'representante':
            header('Location: dashboards/representante/');
            break;
            
        case 'suporte':
            header('Location: dashboards/suporte/');
            break;
        
    default:
        // Tipo de usuário desconhecido
        session_destroy();
        header('Location: login.php?error=invalid_user_type');
        exit;
}

exit;
?>
