<?php
/**
 * =====================================================
 * CLUBEMIX - EXECUTAR TODOS OS TESTES
 * =====================================================
 * Script principal para executar toda a suíte de testes
 * =====================================================
 */

// Incluir o sistema de testes
require_once 'tests/TestRunner.php';

// Incluir todas as classes de teste
require_once 'tests/DatabaseTest.php';
require_once 'tests/LoggerTest.php';
require_once 'tests/ApiBaseTest.php';
require_once 'tests/ClienteCadastroApiTest.php';
require_once 'tests/ValidationTest.php';
require_once 'tests/AuthLoginApiTest.php';

// Configurar ambiente de teste
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "🚀 CLUBEMIX - SISTEMA DE TESTES\n";
echo "================================\n\n";

// Verificar se é execução via linha de comando
if (php_sapi_name() === 'cli') {
    echo "📟 Executando via linha de comando\n";
} else {
    echo "🌐 Executando via navegador\n";
    echo "<pre>\n";
}

try {
    // Criar runner de testes
    $testRunner = new TestRunner();
    
    // Adicionar todas as classes de teste
    $testRunner
        ->addTestClass('DatabaseTest')
        ->addTestClass('LoggerTest')
        ->addTestClass('ApiBaseTest')
        ->addTestClass('ClienteCadastroApiTest')
        ->addTestClass('ValidationTest')
        ->addTestClass('AuthLoginApiTest');
    
    // Executar todos os testes
    $testRunner->runAllTests();
    
} catch (Exception $e) {
    echo "💥 ERRO FATAL AO EXECUTAR TESTES:\n";
    echo "Erro: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack Trace:\n" . $e->getTraceAsString() . "\n";
}

if (php_sapi_name() !== 'cli') {
    echo "</pre>\n";
}

echo "\n🏁 Execução de testes finalizada!\n";
?>
