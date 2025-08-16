<?php
echo "TESTE FINAL DO LOGIN\n";
echo "====================\n\n";

// Iniciar buffer
ob_start();

// Simular sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "Sessao iniciada com sucesso\n";

// Simular usuário logado
$_SESSION['user_id'] = 1;
$_SESSION['user_type'] = 'admin';
$_SESSION['user_email'] = 'admin@clubemix.com';

echo "Usuario simulado:\n";
echo "- ID: {$_SESSION['user_id']}\n";
echo "- Tipo: {$_SESSION['user_type']}\n";
echo "- Email: {$_SESSION['user_email']}\n";

// Testar auth_check
try {
    require_once 'public/includes/auth_check.php';
    echo "\n✅ auth_check.php carregado\n";
    
    $user = getCurrentUser();
    if ($user) {
        echo "✅ getCurrentUser() funcionando:\n";
        echo "   - ID: {$user['id']}\n";
        echo "   - Tipo: {$user['type']}\n";
        echo "   - Email: {$user['email']}\n";
    } else {
        echo "❌ getCurrentUser() falhou\n";
    }
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}

// Testar roteamento
echo "\n🔄 Testando roteamento:\n";
$userType = $_SESSION['user_type'];
$dashboardPath = "public/dashboards/{$userType}/";

echo "Tipo: {$userType}\n";
echo "Caminho: {$dashboardPath}\n";

if (is_dir($dashboardPath)) {
    echo "✅ Pasta existe\n";
    
    if (file_exists($dashboardPath . 'index.php')) {
        echo "✅ index.php existe\n";
        echo "🎯 Redirecionamento funcionando!\n";
    } else {
        echo "❌ index.php não existe\n";
    }
} else {
    echo "❌ Pasta não existe\n";
}

echo "\n✨ TESTE FINALIZADO!\n";
?>
