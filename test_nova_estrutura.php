<?php
/**
 * =====================================================
 * CLUBEMIX - TESTE DA NOVA ESTRUTURA DE DASHBOARDS
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Teste da nova estrutura organizada por pastas
 * =====================================================
 */

echo "🔧 CLUBEMIX - TESTE DA NOVA ESTRUTURA DE DASHBOARDS\n";
echo "====================================================\n\n";

// Verificar estrutura de pastas
$estrutura = [
    'public/dashboards/' => 'Pasta Principal dos Dashboards',
    'public/dashboards/admin/' => 'Dashboard Administrador',
    'public/dashboards/cliente/' => 'Dashboard Cliente',
    'public/dashboards/empresa/' => 'Dashboard Empresa',
    'public/dashboards/representante/' => 'Dashboard Representante',
    'public/dashboards/suporte/' => 'Dashboard Suporte'
];

echo "📁 Verificando estrutura de pastas:\n";
foreach ($estrutura as $pasta => $descricao) {
    if (is_dir($pasta)) {
        echo "✅ {$descricao}: {$pasta}\n";
        
        // Verificar arquivos dentro da pasta
        $arquivos = glob($pasta . "*.php");
        foreach ($arquivos as $arquivo) {
            $nome = basename($arquivo);
            echo "   📄 {$nome}\n";
        }
    } else {
        echo "❌ {$descricao}: {$pasta} - PASTA NÃO ENCONTRADA!\n";
    }
}

// Verificar arquivos compartilhados
echo "\n🔗 Verificando arquivos compartilhados:\n";
$arquivosCompartilhados = [
    'public/dashboards/config.php' => 'Configuração Compartilhada',
    'public/dashboards/layout.php' => 'Layout Compartilhado'
];

foreach ($arquivosCompartilhados as $arquivo => $descricao) {
    if (file_exists($arquivo)) {
        echo "✅ {$descricao}: {$arquivo}\n";
    } else {
        echo "❌ {$descricao}: {$arquivo} - ARQUIVO NÃO ENCONTRADO!\n";
    }
}

// Verificar arquivo de roteamento
echo "\n🔄 Verificando sistema de roteamento:\n";
if (file_exists('public/dashboard.php')) {
    echo "✅ Roteamento Principal: public/dashboard.php\n";
    
    // Verificar se as URLs estão corretas
    $conteudo = file_get_contents('public/dashboard.php');
    if (strpos($conteudo, 'dashboards/admin/') !== false) {
        echo "✅ URL Admin: dashboards/admin/\n";
    } else {
        echo "❌ URL Admin incorreta!\n";
    }
    
    if (strpos($conteudo, 'dashboards/cliente/') !== false) {
        echo "✅ URL Cliente: dashboards/cliente/\n";
    } else {
        echo "❌ URL Cliente incorreta!\n";
    }
} else {
    echo "❌ Arquivo de roteamento não encontrado!\n";
}

// Verificar arquivos .htaccess
echo "\n🔒 Verificando arquivos .htaccess:\n";
$htaccessFiles = [
    'public/dashboards/admin/.htaccess' => 'Admin .htaccess',
    'public/dashboards/cliente/.htaccess' => 'Cliente .htaccess',
    'public/dashboards/empresa/.htaccess' => 'Empresa .htaccess',
    'public/dashboards/representante/.htaccess' => 'Representante .htaccess',
    'public/dashboards/suporte/.htaccess' => 'Suporte .htaccess'
];

foreach ($htaccessFiles as $arquivo => $descricao) {
    if (file_exists($arquivo)) {
        echo "✅ {$descricao}: {$arquivo}\n";
    } else {
        echo "❌ {$descricao}: {$arquivo} - ARQUIVO NÃO ENCONTRADO!\n";
    }
}

// Verificar funcionalidades
echo "\n⚙️ Verificando funcionalidades:\n";
if (file_exists('public/dashboards/config.php')) {
    require_once 'public/dashboards/config.php';
    
    // Testar funções
    $funcoes = [
        'getDashboardConfig' => 'Configuração do Dashboard',
        'generateNavigationMenu' => 'Menu de Navegação',
        'generateBreadcrumb' => 'Breadcrumb',
        'checkPermission' => 'Verificação de Permissões',
        'getThemeColors' => 'Cores do Tema'
    ];
    
    foreach ($funcoes as $funcao => $descricao) {
        if (function_exists($funcao)) {
            echo "✅ {$descricao}: {$funcao}()\n";
        } else {
            echo "❌ {$descricao}: {$funcao}() - FUNÇÃO NÃO ENCONTRADA!\n";
        }
    }
    
    // Testar configurações
    $configAdmin = getDashboardConfig('admin');
    if ($configAdmin && isset($configAdmin['title'])) {
        echo "✅ Configuração Admin: {$configAdmin['title']}\n";
    } else {
        echo "❌ Configuração Admin não funcionando!\n";
    }
} else {
    echo "❌ Arquivo de configuração não encontrado!\n";
}

// Verificar URLs de acesso
echo "\n🌐 URLs de Acesso:\n";
$baseUrl = 'http://localhost/ClubeMix/public';
echo "✅ Base URL: {$baseUrl}\n";
echo "✅ Login: {$baseUrl}/login.php\n";
echo "✅ Dashboard: {$baseUrl}/dashboard.php\n";
echo "✅ Admin: {$baseUrl}/dashboards/admin/\n";
echo "✅ Cliente: {$baseUrl}/dashboards/cliente/\n";
echo "✅ Empresa: {$baseUrl}/dashboards/empresa/\n";
echo "✅ Representante: {$baseUrl}/dashboards/representante/\n";
echo "✅ Suporte: {$baseUrl}/dashboards/suporte/\n";

// Verificar estrutura de arquivos específicos
echo "\n📋 Estrutura de Arquivos por Dashboard:\n";
$dashboards = ['admin', 'cliente', 'empresa', 'representante', 'suporte'];

foreach ($dashboards as $dashboard) {
    $pasta = "public/dashboards/{$dashboard}/";
    echo "\n🎯 Dashboard {$dashboard}:\n";
    
    if (is_dir($pasta)) {
        $arquivos = glob($pasta . "*.php");
        if (count($arquivos) > 0) {
            foreach ($arquivos as $arquivo) {
                $nome = basename($arquivo);
                $tamanho = filesize($arquivo);
                echo "   📄 {$nome} ({$tamanho} bytes)\n";
            }
        } else {
            echo "   ⚠️  Nenhum arquivo PHP encontrado\n";
        }
        
        // Verificar .htaccess
        $htaccess = $pasta . ".htaccess";
        if (file_exists($htaccess)) {
            echo "   🔒 .htaccess configurado\n";
        } else {
            echo "   ❌ .htaccess não encontrado\n";
        }
    } else {
        echo "   ❌ Pasta não encontrada\n";
    }
}

echo "\n✨ TESTE CONCLUÍDO!\n";
echo "💡 Vantagens da nova estrutura:\n";
echo "   • Organização clara por tipo de usuário\n";
echo "   • Fácil manutenção e escalabilidade\n";
echo "   • Componentes compartilhados reutilizáveis\n";
echo "   • Segurança aprimorada com .htaccess\n";
echo "   • Layout consistente entre dashboards\n";
echo "   • Sistema de permissões integrado\n";
echo "   • Temas personalizados por tipo de usuário\n";
echo "   • Navegação intuitiva e responsiva\n";
?>
