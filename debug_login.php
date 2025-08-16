<?php
/**
 * =====================================================
 * CLUBEMIX - DEBUG DO FLUXO DE LOGIN
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Debug para verificar o fluxo de login
 * =====================================================
 */

// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "🔍 DEBUG DO FLUXO DE LOGIN\n";
echo "============================\n\n";

// 1. Verificar se a sessão está funcionando
echo "🔐 Testando sessões PHP:\n";
if (session_status() === PHP_SESSION_NONE) {
    echo "✅ Sessão não iniciada - iniciando...\n";
    session_start();
} else {
    echo "✅ Sessão já iniciada\n";
}

echo "Session ID: " . session_id() . "\n";
echo "Session Name: " . session_name() . "\n";
echo "Session Status: " . session_status() . "\n";

// 2. Simular dados de usuário
echo "\n👤 Simulando dados de usuário:\n";
$_SESSION['user_id'] = 1;
$_SESSION['user_uuid'] = 'test-uuid-123';
$_SESSION['user_email'] = 'admin@clubemix.com';
$_SESSION['user_type'] = 'admin';
$_SESSION['user_status'] = 'ativo';
$_SESSION['login_time'] = time();

echo "✅ Dados da sessão definidos:\n";
foreach ($_SESSION as $key => $value) {
    echo "   - {$key}: {$value}\n";
}

// 3. Testar auth_check.php
echo "\n🔍 Testando auth_check.php:\n";
try {
    require_once 'public/includes/auth_check.php';
    echo "✅ auth_check.php carregado com sucesso\n";
    
    // Testar funções
    if (function_exists('isLoggedIn')) {
        echo "✅ Função isLoggedIn() existe\n";
        $loggedIn = isLoggedIn();
        echo "   - Usuário logado: " . ($loggedIn ? 'SIM' : 'NÃO') . "\n";
    } else {
        echo "❌ Função isLoggedIn() não existe\n";
    }
    
    if (function_exists('getCurrentUser')) {
        echo "✅ Função getCurrentUser() existe\n";
        $user = getCurrentUser();
        if ($user) {
            echo "   - Dados do usuário obtidos:\n";
            foreach ($user as $key => $value) {
                echo "     * {$key}: {$value}\n";
            }
        } else {
            echo "   ❌ getCurrentUser() retornou null\n";
        }
    } else {
        echo "❌ Função getCurrentUser() não existe\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao carregar auth_check.php: " . $e->getMessage() . "\n";
}

// 4. Testar dashboard.php
echo "\n🔄 Testando dashboard.php:\n";
try {
    // Capturar saída do dashboard.php
    ob_start();
    
    // Incluir dashboard.php
    $dashboardOutput = include 'public/dashboard.php';
    
    $output = ob_get_clean();
    
    if ($output) {
        echo "✅ dashboard.php executou com saída:\n";
        echo "   " . substr($output, 0, 100) . "...\n";
    } else {
        echo "✅ dashboard.php executou sem saída (redirecionamento)\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao executar dashboard.php: " . $e->getMessage() . "\n";
}

// 5. Verificar redirecionamento
echo "\n🎯 Verificando redirecionamento:\n";
$userType = $_SESSION['user_type'] ?? 'desconhecido';
$dashboardPath = "public/dashboards/{$userType}/";

echo "Tipo de usuário: {$userType}\n";
echo "Caminho do dashboard: {$dashboardPath}\n";

if (is_dir($dashboardPath)) {
    echo "✅ Pasta do dashboard existe\n";
    
    if (file_exists($dashboardPath . 'index.php')) {
        echo "✅ index.php do dashboard existe\n";
        
        // Verificar conteúdo
        $content = file_get_contents($dashboardPath . 'index.php');
        if (strpos($content, 'layout.php') !== false) {
            echo "✅ Dashboard usa layout compartilhado\n";
        } else {
            echo "⚠️ Dashboard não usa layout compartilhado\n";
        }
    } else {
        echo "❌ index.php do dashboard não existe\n";
    }
} else {
    echo "❌ Pasta do dashboard não existe\n";
}

// 6. Verificar headers HTTP
echo "\n🌐 Verificando headers HTTP:\n";
$headers = headers_list();
if (!empty($headers)) {
    echo "✅ Headers enviados:\n";
    foreach ($headers as $header) {
        echo "   - {$header}\n";
    }
} else {
    echo "✅ Nenhum header enviado\n";
}

// 7. Verificar configurações de sessão
echo "\n⚙️ Configurações de sessão:\n";
echo "Session save path: " . session_save_path() . "\n";
echo "Session cookie lifetime: " . ini_get('session.cookie_lifetime') . "\n";
echo "Session cookie path: " . ini_get('session.cookie_path') . "\n";
echo "Session cookie domain: " . ini_get('session.cookie_domain') . "\n";
echo "Session cookie secure: " . ini_get('session.cookie_secure') . "\n";
echo "Session cookie httponly: " . ini_get('session.cookie_httponly') . "\n";

// 8. Testar acesso direto ao dashboard
echo "\n🧪 Testando acesso direto ao dashboard:\n";
$dashboardUrl = "dashboards/{$userType}/";
echo "URL do dashboard: {$dashboardUrl}\n";

// Simular requisição HTTP
$testUrl = "http://localhost/ClubeMix/public/{$dashboardUrl}";
echo "URL completa: {$testUrl}\n";

// 9. Verificar logs
echo "\n📝 Verificando logs:\n";
$logFiles = [
    'logs/system_2025-08-15.log',
    'logs/clubemix_debug_2025-08-15.log'
];

foreach ($logFiles as $logFile) {
    if (file_exists($logFile)) {
        $size = filesize($logFile);
        echo "✅ {$logFile}: {$size} bytes\n";
        
        if ($size > 0) {
            $lines = file($logFile);
            $lastLine = end($lines);
            echo "   Última linha: " . trim($lastLine) . "\n";
        }
    } else {
        echo "❌ {$logFile}: arquivo não encontrado\n";
    }
}

echo "\n✨ DEBUG CONCLUÍDO!\n";
echo "💡 Resumo dos problemas encontrados:\n";
echo "   • Verificar se há saída antes de session_start()\n";
echo "   • Verificar se os arquivos estão sendo incluídos corretamente\n";
echo "   • Verificar se as permissões estão corretas\n";
echo "   • Verificar se o servidor web está configurado corretamente\n";
?>
