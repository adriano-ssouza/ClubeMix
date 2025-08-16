<?php
echo "TESTE DE ESTRUTURA SIMPLES\n";
echo "==========================\n\n";

// 1. Verificar se os arquivos existem
echo "📁 Verificando arquivos:\n";
$files = [
    'public/includes/auth_check.php' => 'auth_check.php',
    'public/dashboards/layout.php' => 'layout.php',
    'public/dashboards/config.php' => 'config.php',
    'public/dashboards/admin/index.php' => 'admin/index.php'
];

foreach ($files as $path => $name) {
    if (file_exists($path)) {
        echo "✅ {$name}: existe\n";
    } else {
        echo "❌ {$name}: não existe\n";
    }
}

// 2. Verificar se as pastas existem
echo "\n📂 Verificando pastas:\n";
$folders = [
    'public/dashboards/admin/',
    'public/dashboards/cliente/',
    'public/dashboards/empresa/',
    'public/dashboards/representante/',
    'public/dashboards/suporte/'
];

foreach ($folders as $folder) {
    if (is_dir($folder)) {
        echo "✅ " . basename($folder) . ": pasta existe\n";
        
        if (file_exists($folder . 'index.php')) {
            echo "   📄 index.php existe\n";
        } else {
            echo "   ❌ index.php não existe\n";
        }
    } else {
        echo "❌ " . basename($folder) . ": pasta não existe\n";
    }
}

// 3. Testar include do config.php
echo "\n🔧 Testando config.php:\n";
try {
    require_once 'public/dashboards/config.php';
    echo "✅ config.php carregado\n";
    
    if (function_exists('getDashboardConfig')) {
        echo "✅ getDashboardConfig() existe\n";
        
        $config = getDashboardConfig('admin');
        if ($config) {
            echo "✅ Configuração admin obtida:\n";
            echo "   - Título: {$config['title']}\n";
            echo "   - Tema: {$config['theme']}\n";
            echo "   - Itens de menu: " . count($config['menu_items']) . "\n";
        } else {
            echo "❌ Falha ao obter configuração admin\n";
        }
    } else {
        echo "❌ getDashboardConfig() não existe\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao carregar config.php: " . $e->getMessage() . "\n";
}

// 4. Testar include do layout.php
echo "\n🎨 Testando layout.php:\n";
try {
    // Simular variáveis necessárias
    $userType = 'admin';
    $userId = 1;
    $userEmail = 'admin@clubemix.com';
    
    // Capturar saída
    ob_start();
    
    // Incluir layout.php
    include 'public/dashboards/layout.php';
    
    $output = ob_get_clean();
    
    if ($output) {
        echo "✅ layout.php executou com saída\n";
        echo "   Tamanho: " . strlen($output) . " caracteres\n";
        
        // Verificar se contém elementos HTML básicos
        if (strpos($output, '<html') !== false) {
            echo "   ✅ Contém tag HTML\n";
        }
        if (strpos($output, '<title>') !== false) {
            echo "   ✅ Contém título\n";
        }
        if (strpos($output, 'Dashboard') !== false) {
            echo "   ✅ Contém texto do dashboard\n";
        }
    } else {
        echo "❌ layout.php executou sem saída\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro ao executar layout.php: " . $e->getMessage() . "\n";
}

echo "\n✨ TESTE DE ESTRUTURA CONCLUÍDO!\n";
?>
