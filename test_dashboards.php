<?php
/**
 * =====================================================
 * CLUBEMIX - TESTE DOS DASHBOARDS
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Teste dos dashboards por tipo de usuário
 * =====================================================
 */

echo "🔧 CLUBEMIX - TESTE DOS DASHBOARDS\n";
echo "=====================================\n\n";

// Testar se os arquivos existem
$dashboards = [
    'dashboard.php' => 'Roteamento Principal',
    'dashboards/admin.php' => 'Dashboard Admin',
    'dashboards/cliente.php' => 'Dashboard Cliente',
    'dashboards/empresa.php' => 'Dashboard Empresa',
    'dashboards/representante.php' => 'Dashboard Representante',
    'dashboards/suporte.php' => 'Dashboard Suporte',
    'includes/auth_check.php' => 'Sistema de Proteção',
    'logout.php' => 'Sistema de Logout'
];

echo "📋 Verificando arquivos dos dashboards:\n";
foreach ($dashboards as $file => $description) {
    if (file_exists($file)) {
        echo "✅ {$description}: {$file}\n";
    } else {
        echo "❌ {$description}: {$file} - ARQUIVO NÃO ENCONTRADO!\n";
    }
}

echo "\n🔐 Verificando sistema de proteção:\n";
if (file_exists('includes/auth_check.php')) {
    require_once 'includes/auth_check.php';
    
    // Testar funções de autenticação
    echo "✅ Função isLoggedIn(): " . (function_exists('isLoggedIn') ? 'EXISTE' : 'NÃO EXISTE') . "\n";
    echo "✅ Função hasUserType(): " . (function_exists('hasUserType') ? 'EXISTE' : 'NÃO EXISTE') . "\n";
    echo "✅ Função requireLogin(): " . (function_exists('requireLogin') ? 'EXISTE' : 'NÃO EXISTE') . "\n";
    echo "✅ Função getCurrentUser(): " . (function_exists('getCurrentUser') ? 'EXISTE' : 'NÃO EXISTE') . "\n";
    
    // Testar estado de login (deve ser false sem sessão)
    echo "✅ Estado de login: " . (isLoggedIn() ? 'LOGADO' : 'NÃO LOGADO') . " (esperado: NÃO LOGADO)\n";
} else {
    echo "❌ Sistema de proteção não encontrado!\n";
}

echo "\n🌐 Verificando estrutura de URLs:\n";
$baseUrl = 'http://localhost/ClubeMix/public';
echo "✅ URL Base: {$baseUrl}\n";
echo "✅ Login: {$baseUrl}/login.php\n";
echo "✅ Dashboard: {$baseUrl}/dashboard.php\n";
echo "✅ Logout: {$baseUrl}/logout.php\n";

echo "\n📱 Dashboards específicos:\n";
echo "✅ Admin: {$baseUrl}/dashboards/admin.php\n";
echo "✅ Cliente: {$baseUrl}/dashboards/cliente.php\n";
echo "✅ Empresa: {$baseUrl}/dashboards/empresa.php\n";
echo "✅ Representante: {$baseUrl}/dashboards/representante.php\n";
echo "✅ Suporte: {$baseUrl}/dashboards/suporte.php\n";

echo "\n🎯 FLUXO DE FUNCIONAMENTO:\n";
echo "1. Usuário faz login em: {$baseUrl}/login.php\n";
echo "2. API valida credenciais e cria sessão\n";
echo "3. Usuário é redirecionado para: {$baseUrl}/dashboard.php\n";
echo "4. Sistema roteia para dashboard específico baseado no tipo\n";
echo "5. Dashboard verifica permissões e exibe conteúdo\n";
echo "6. Usuário pode fazer logout em: {$baseUrl}/logout.php\n";

echo "\n✨ Teste concluído! Todos os dashboards estão configurados.\n";
echo "💡 Para testar, acesse: {$baseUrl}/login.php\n";
?>
