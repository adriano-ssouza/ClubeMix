<?php
/**
 * =====================================================
 * CLUBEMIX - TESTE DE PERFORMANCE
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Teste para demonstrar melhoria de performance
 * =====================================================
 */

require_once 'FastTestRunner.php';

// Teste 1: Teste básico sem otimizações
createTest('Teste Básico - Sem Otimizações', function() {
    // Simular teste lento
    usleep(100000); // 100ms
    return true;
}, 1);

// Teste 2: Teste com cache
createTest('Teste com Cache', function() {
    return testCache('test_key', function() {
        usleep(50000); // 50ms
        return 'dados_cacheados';
    });
}, 1);

// Teste 3: Teste de validação rápida
createTest('Teste de Validação', function() {
    $data = ['email' => 'test@example.com', 'senha' => '123456'];
    
    // Validação rápida
    $errors = [];
    if (empty($data['email'])) $errors['email'] = 'Email obrigatório';
    if (strlen($data['senha']) < 6) $errors['senha'] = 'Senha muito curta';
    
    return empty($errors);
}, 1);

// Teste 4: Teste de conexão mockada
createTest('Teste de Conexão Mockada', function() {
    // Simular conexão rápida
    $mockDb = [
        'connected' => true,
        'version' => '8.0.0',
        'response_time' => 5 // 5ms
    ];
    
    return $mockDb['connected'] && $mockDb['response_time'] < 10;
}, 1);

// Teste 5: Teste de log otimizado
createTest('Teste de Log Otimizado', function() {
    $start = microtime(true);
    
    // Log rápido (sem escrita em arquivo)
    for ($i = 0; $i < 100; $i++) {
        testLog('INFO', "Log rápido {$i}");
    }
    
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    
    return $time < 50; // Deve ser menor que 50ms
}, 1);

// Teste 6: Teste de sessão otimizada
createTest('Teste de Sessão Otimizada', function() {
    $start = microtime(true);
    
    // Operações de sessão rápidas
    $_SESSION['test_key'] = 'test_value';
    $value = $_SESSION['test_key'] ?? null;
    unset($_SESSION['test_key']);
    
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    
    return $value === 'test_value' && $time < 10;
}, 1);

// Teste 7: Teste de autoload
createTest('Teste de Autoload', function() {
    $start = microtime(true);
    
    // Simular carregamento de classes
    $classes = ['TestClass1', 'TestClass2', 'TestClass3'];
    foreach ($classes as $class) {
        class_exists($class);
    }
    
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    
    return $time < 20;
}, 1);

// Teste 8: Teste de validação de dados
createTest('Teste de Validação de Dados', function() {
    $data = [
        'nome' => 'João Silva',
        'email' => 'joao@example.com',
        'idade' => 25,
        'ativo' => true
    ];
    
    $start = microtime(true);
    
    // Validações rápidas
    $valid = true;
    $valid = $valid && !empty($data['nome']);
    $valid = $valid && filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $valid = $valid && $data['idade'] >= 18;
    $valid = $valid && is_bool($data['ativo']);
    
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    
    return $valid && $time < 5;
}, 1);

// Teste 9: Teste de array operations
createTest('Teste de Operações de Array', function() {
    $start = microtime(true);
    
    // Operações rápidas com arrays
    $array = range(1, 1000);
    $filtered = array_filter($array, function($n) { return $n % 2 === 0; });
    $mapped = array_map(function($n) { return $n * 2; }, $filtered);
    $sum = array_sum($mapped);
    
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    
    return $sum > 0 && $time < 10;
}, 1);

// Teste 10: Teste de string operations
createTest('Teste de Operações de String', function() {
    $start = microtime(true);
    
    // Operações rápidas com strings
    $text = 'ClubeMix é uma plataforma incrível!';
    $uppercase = strtoupper($text);
    $lowercase = strtolower($text);
    $length = strlen($text);
    $words = str_word_count($text);
    
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    
    return $length > 0 && $words > 0 && $time < 5;
}, 1);

// Executar todos os testes
echo "🚀 EXECUTANDO TESTES DE PERFORMANCE\n";
echo "=====================================\n\n";

$results = runTests();

// Mostrar estatísticas
$stats = getTestStats();
if ($stats) {
    echo "\n📊 ESTATÍSTICAS FINAIS:\n";
    echo "========================\n";
    echo "Total de Testes: {$stats['total_tests']}\n";
    echo "Passaram: {$stats['passed']}\n";
    echo "Falharam: {$stats['failed']}\n";
    echo "Taxa de Sucesso: {$stats['success_rate']}%\n";
    echo "Tempo Médio por Teste: {$stats['average_time']}ms\n";
    echo "Tempo Total de Execução: {$stats['total_execution_time']}ms\n";
}

// Salvar relatório
$reportFile = $testRunner->saveReport('performance_test_report.json');
if ($reportFile) {
    echo "\n💾 Relatório salvo em: {$reportFile}\n";
}

echo "\n✨ Testes de Performance Concluídos!\n";
echo "💡 Dicas para acelerar ainda mais:\n";
echo "   • Use mocks para dependências externas\n";
echo "   • Implemente cache para dados estáticos\n";
echo "   • Execute testes em paralelo quando possível\n";
echo "   • Minimize operações de I/O durante testes\n";
echo "   • Use banco de dados em memória para testes\n";
echo "   • Configure PHP com opcache ativado\n";
echo "   • Monitore uso de memória e CPU\n";
?>
