<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "DEBUG DO FLUXO DE LOGIN\n";
echo "========================\n\n";

// Testar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "Session ID: " . session_id() . "\n";

// Simular usuário
$_SESSION['user_id'] = 1;
$_SESSION['user_type'] = 'admin';

echo "Usuario logado: " . ($_SESSION['user_id'] ?? 'NÃO') . "\n";
echo "Tipo: " . ($_SESSION['user_type'] ?? 'NÃO') . "\n";

// Testar auth_check
try {
    require_once 'public/includes/auth_check.php';
    echo "auth_check.php carregado\n";
    
    $user = getCurrentUser();
    if ($user) {
        echo "getCurrentUser OK\n";
    } else {
        echo "getCurrentUser FALHOU\n";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}

echo "Debug concluido\n";
?>
