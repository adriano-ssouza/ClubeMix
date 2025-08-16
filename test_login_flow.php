<?php
/**
 * =====================================================
 * CLUBEMIX - TESTE DO FLUXO DE LOGIN
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Teste para verificar o fluxo de login e redirecionamento
 * =====================================================
 */

echo "🔍 TESTE DO FLUXO DE LOGIN E REDIRECIONAMENTO\n";
echo "==============================================\n\n";

// 1. Verificar se os arquivos necessários existem
echo "📁 Verificando arquivos necessários:\n";
$arquivos = [
    'public/login.php' => 'Página de Login',
    'public/dashboard.php' => 'Roteamento de Dashboards',
    'public/includes/auth_check.php' => 'Verificação de Autenticação',
    'api/auth/login.php' => 'API de Login'
];

foreach ($arquivos as $arquivo => $descricao) {
    if (file_exists($arquivo)) {
        echo "✅ {$descricao}: {$arquivo}\n";
    } else {
        echo "❌ {$descricao}: {$arquivo} - ARQUIVO NÃO ENCONTRADO!\n";
    }
}

// 2. Verificar estrutura de pastas dos dashboards
echo "\n📂 Verificando estrutura de dashboards:\n";
$dashboards = ['admin', 'cliente', 'empresa', 'representante', 'suporte'];

foreach ($dashboards as $dashboard) {
    $pasta = "public/dashboards/{$dashboard}/";
    if (is_dir($pasta)) {
        echo "✅ Dashboard {$dashboard}: {$pasta}\n";
        
        // Verificar se tem index.php
        if (file_exists($pasta . 'index.php')) {
            echo "   📄 index.php encontrado\n";
        } else {
            echo "   ❌ index.php não encontrado\n";
        }
    } else {
        echo "❌ Dashboard {$dashboard}: {$pasta} - PASTA NÃO ENCONTRADA!\n";
    }
}

// 3. Verificar configurações de sessão
echo "\n🔐 Verificando configurações de sessão:\n";
echo "Session save path: " . session_save_path() . "\n";
echo "Session name: " . session_name() . "\n";
echo "Session cookie lifetime: " . ini_get('session.cookie_lifetime') . "\n";

// 4. Simular sessão de usuário
echo "\n🧪 Simulando sessão de usuário:\n";
session_start();

// Limpar sessão anterior
$_SESSION = [];

// Simular usuário logado
$_SESSION['user_id'] = 1;
$_SESSION['user_uuid'] = 'test-uuid-123';
$_SESSION['user_email'] = 'admin@clubemix.com';
$_SESSION['user_type'] = 'admin';
$_SESSION['user_status'] = 'ativo';
$_SESSION['login_time'] = time();

echo "✅ Sessão simulada criada:\n";
echo "   - user_id: {$_SESSION['user_id']}\n";
echo "   - user_type: {$_SESSION['user_type']}\n";
echo "   - user_email: {$_SESSION['user_email']}\n";

// 5. Testar função getCurrentUser
echo "\n🔍 Testando função getCurrentUser:\n";
require_once 'public/includes/auth_check.php';

$user = getCurrentUser();
if ($user) {
    echo "✅ getCurrentUser() funcionando:\n";
    echo "   - id: {$user['id']}\n";
    echo "   - type: {$user['type']}\n";
    echo "   - email: {$user['email']}\n";
} else {
    echo "❌ getCurrentUser() falhou!\n";
}

// 6. Testar roteamento
echo "\n🔄 Testando roteamento:\n";
if ($user && isset($user['type'])) {
    $userType = $user['type'];
    echo "✅ Tipo de usuário detectado: {$userType}\n";
    
    $dashboardPath = "public/dashboards/{$userType}/";
    if (is_dir($dashboardPath)) {
        echo "✅ Dashboard encontrado: {$dashboardPath}\n";
        
        // Verificar se pode acessar
        if (is_readable($dashboardPath . 'index.php')) {
            echo "✅ index.php acessível\n";
        } else {
            echo "❌ index.php não acessível\n";
        }
    } else {
        echo "❌ Dashboard não encontrado: {$dashboardPath}\n";
    }
} else {
    echo "❌ Não foi possível detectar o tipo de usuário\n";
}

// 7. Verificar permissões de arquivos
echo "\n🔒 Verificando permissões:\n";
$arquivosTeste = [
    'public/dashboard.php',
    'public/includes/auth_check.php',
    'public/dashboards/admin/index.php'
];

foreach ($arquivosTeste as $arquivo) {
    if (file_exists($arquivo)) {
        $perms = fileperms($arquivo);
        $perms = substr(sprintf('%o', $perms), -4);
        echo "✅ {$arquivo}: permissões {$perms}\n";
    } else {
        echo "❌ {$arquivo}: arquivo não encontrado\n";
    }
}

// 8. Verificar configurações do servidor web
echo "\n🌐 Verificando configurações do servidor:\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Não definido') . "\n";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'Não definido') . "\n";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'Não definido') . "\n";

// 9. Testar redirecionamento
echo "\n🎯 Testando redirecionamento:\n";
$userType = $_SESSION['user_type'] ?? 'desconhecido';
$redirectUrl = "dashboards/{$userType}/";

echo "URL de redirecionamento: {$redirectUrl}\n";

if (is_dir("public/{$redirectUrl}")) {
    echo "✅ Pasta de destino existe\n";
    
    if (file_exists("public/{$redirectUrl}index.php")) {
        echo "✅ index.php de destino existe\n";
        
        // Verificar se é acessível
        $testUrl = "http://localhost/ClubeMix/public/{$redirectUrl}";
        echo "URL completa: {$testUrl}\n";
    } else {
        echo "❌ index.php de destino não existe\n";
    }
} else {
    echo "❌ Pasta de destino não existe\n";
}

// 10. Verificar logs de erro
echo "\n📝 Verificando logs de erro:\n";
$logFiles = [
    'logs/system_2025-08-15.log',
    'logs/clubemix_debug_2025-08-15.log'
];

foreach ($logFiles as $logFile) {
    if (file_exists($logFile)) {
        $size = filesize($logFile);
        echo "✅ {$logFile}: {$size} bytes\n";
        
        if ($size > 0) {
            $lastLines = file($logFile);
            $lastLine = end($lastLines);
            echo "   Última linha: " . trim($lastLine) . "\n";
        }
    } else {
        echo "❌ {$logFile}: arquivo não encontrado\n";
    }
}

echo "\n✨ TESTE CONCLUÍDO!\n";
echo "💡 Possíveis problemas identificados:\n";
echo "   • Verificar se o servidor web está configurado corretamente\n";
echo "   • Verificar se as sessões PHP estão funcionando\n";
echo "   • Verificar se há erros nos logs do servidor\n";
echo "   • Verificar se as permissões dos arquivos estão corretas\n";
echo "   • Verificar se o mod_rewrite está ativado (se necessário)\n";
?>
