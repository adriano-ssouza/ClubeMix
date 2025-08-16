<?php
/**
 * =====================================================
 * CLUBEMIX - FAST TEST RUNNER
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Test runner otimizado para execução rápida
 * =====================================================
 */

require_once 'config_test.php';

class FastTestRunner
{
    private $tests = [];
    private $results = [];
    private $startTime;
    private $totalTime = 0;
    
    public function __construct() {
        $this->startTime = microtime(true);
        testLog('INFO', 'FastTestRunner inicializado');
    }
    
    /**
     * Adicionar teste à fila
     */
    public function addTest($name, $callback, $timeout = 5) {
        $this->tests[] = [
            'name' => $name,
            'callback' => $callback,
            'timeout' => $timeout,
            'status' => 'pending'
        ];
        
        testLog('INFO', "Teste '{$name}' adicionado à fila");
    }
    
    /**
     * Executar todos os testes
     */
    public function runAll() {
        testLog('INFO', 'Iniciando execução de ' . count($this->tests) . ' testes');
        
        $this->results = [];
        $successCount = 0;
        $failureCount = 0;
        $totalTestTime = 0;
        
        foreach ($this->tests as $index => $test) {
            $testStart = microtime(true);
            
            try {
                testLog('INFO', "Executando teste: {$test['name']}");
                
                // Executar teste com timeout
                $result = runTestWithTimeout($test['callback'], $test['timeout']);
                
                $testEnd = microtime(true);
                $testTime = round(($testEnd - $testStart) * 1000, 2);
                $totalTestTime += $testTime;
                
                $this->results[] = [
                    'name' => $test['name'],
                    'status' => 'PASS',
                    'time' => $testTime,
                    'result' => $result,
                    'error' => null
                ];
                
                $successCount++;
                testLog('SUCCESS', "Teste '{$test['name']}' passou em {$testTime}ms");
                
            } catch (Exception $e) {
                $testEnd = microtime(true);
                $testTime = round(($testEnd - $testStart) * 1000, 2);
                $totalTestTime += $testTime;
                
                $this->results[] = [
                    'name' => $test['name'],
                    'status' => 'FAIL',
                    'time' => $testTime,
                    'result' => null,
                    'error' => $e->getMessage()
                ];
                
                $failureCount++;
                testLog('ERROR', "Teste '{$test['name']}' falhou em {$testTime}ms: " . $e->getMessage());
            }
        }
        
        $this->totalTime = microtime(true) - $this->startTime;
        
        $this->printSummary($successCount, $failureCount, $totalTestTime);
        
        return $this->results;
    }
    
    /**
     * Executar testes em paralelo (simulação)
     */
    public function runParallel($maxConcurrency = 4) {
        testLog('INFO', "Executando testes com concorrência máxima de {$maxConcurrency}");
        
        $chunks = array_chunk($this->tests, $maxConcurrency);
        $this->results = [];
        
        foreach ($chunks as $chunk) {
            $chunkResults = runTestsInParallel($chunk);
            $this->results = array_merge($this->results, $chunkResults);
        }
        
        return $this->results;
    }
    
    /**
     * Executar apenas testes específicos
     */
    public function runSpecific($testNames) {
        $filteredTests = array_filter($this->tests, function($test) use ($testNames) {
            return in_array($test['name'], $testNames);
        });
        
        testLog('INFO', 'Executando testes específicos: ' . implode(', ', $testNames));
        
        $this->tests = array_values($filteredTests);
        return $this->runAll();
    }
    
    /**
     * Executar testes por categoria
     */
    public function runByCategory($category) {
        $filteredTests = array_filter($this->tests, function($test) use ($category) {
            return strpos($test['name'], $category) !== false;
        });
        
        testLog('INFO', "Executando testes da categoria: {$category}");
        
        $this->tests = array_values($filteredTests);
        return $this->runAll();
    }
    
    /**
     * Executar testes com filtro de tempo
     */
    public function runFastTests($maxTime = 1000) {
        $fastTests = array_filter($this->tests, function($test) use ($maxTime) {
            return $test['timeout'] <= $maxTime;
        });
        
        testLog('INFO', "Executando testes rápidos (max {$maxTime}ms)");
        
        $this->tests = array_values($fastTests);
        return $this->runAll();
    }
    
    /**
     * Imprimir resumo dos resultados
     */
    private function printSummary($successCount, $failureCount, $totalTestTime) {
        $totalTests = $successCount + $failureCount;
        $successRate = $totalTests > 0 ? round(($successCount / $totalTests) * 100, 2) : 0;
        
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "📊 RESUMO DOS TESTES\n";
        echo str_repeat("=", 60) . "\n";
        echo "✅ Testes Passaram: {$successCount}\n";
        echo "❌ Testes Falharam: {$failureCount}\n";
        echo "📈 Taxa de Sucesso: {$successRate}%\n";
        echo "⏱️  Tempo Total dos Testes: " . round($totalTestTime, 2) . "ms\n";
        echo "🚀 Tempo Total de Execução: " . round($this->totalTime * 1000, 2) . "ms\n";
        echo str_repeat("=", 60) . "\n\n";
        
        // Detalhes dos testes
        foreach ($this->results as $result) {
            $status = $result['status'] === 'PASS' ? '✅' : '❌';
            $time = $result['time'];
            $name = $result['name'];
            
            echo "{$status} {$name} ({$time}ms)";
            
            if ($result['error']) {
                echo " - Erro: " . $result['error'];
            }
            
            echo "\n";
        }
        
        echo "\n";
    }
    
    /**
     * Gerar relatório em JSON
     */
    public function generateJsonReport() {
        $report = [
            'summary' => [
                'total_tests' => count($this->results),
                'passed' => count(array_filter($this->results, fn($r) => $r['status'] === 'PASS')),
                'failed' => count(array_filter($this->results, fn($r) => $r['status'] === 'FAIL')),
                'total_time' => round($this->totalTime * 1000, 2),
                'timestamp' => date('Y-m-d H:i:s')
            ],
            'tests' => $this->results
        ];
        
        return json_encode($report, JSON_PRETTY_PRINT);
    }
    
    /**
     * Salvar relatório em arquivo
     */
    public function saveReport($filename = null) {
        if (!$filename) {
            $filename = 'test_report_' . date('Y-m-d_H-i-s') . '.json';
        }
        
        $report = $this->generateJsonReport();
        $filepath = 'tests/reports/' . $filename;
        
        // Criar diretório se não existir
        if (!is_dir('tests/reports')) {
            mkdir('tests/reports', 0755, true);
        }
        
        if (file_put_contents($filepath, $report)) {
            testLog('INFO', "Relatório salvo em: {$filepath}");
            return $filepath;
        } else {
            testLog('ERROR', "Falha ao salvar relatório em: {$filepath}");
            return false;
        }
    }
    
    /**
     * Limpar resultados
     */
    public function clearResults() {
        $this->results = [];
        $this->totalTime = 0;
        testLog('INFO', 'Resultados limpos');
    }
    
    /**
     * Obter estatísticas
     */
    public function getStats() {
        $passed = count(array_filter($this->results, fn($r) => $r['status'] === 'PASS'));
        $failed = count(array_filter($this->results, fn($r) => $r['status'] === 'FAIL'));
        $total = count($this->results);
        
        $avgTime = $total > 0 ? array_sum(array_column($this->results, 'time')) / $total : 0;
        
        return [
            'total_tests' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'success_rate' => $total > 0 ? round(($passed / $total) * 100, 2) : 0,
            'average_time' => round($avgTime, 2),
            'total_execution_time' => round($this->totalTime * 1000, 2)
        ];
    }
}

// Função helper para criar testes rapidamente
function createTest($name, $callback, $timeout = 5) {
    global $testRunner;
    
    if (!isset($testRunner)) {
        $testRunner = new FastTestRunner();
    }
    
    $testRunner->addTest($name, $callback, $timeout);
}

// Função helper para executar testes
function runTests() {
    global $testRunner;
    
    if (!isset($testRunner)) {
        testLog('ERROR', 'Nenhum teste foi adicionado');
        return [];
    }
    
    return $testRunner->runAll();
}

// Função helper para obter estatísticas
function getTestStats() {
    global $testRunner;
    
    if (!isset($testRunner)) {
        return null;
    }
    
    return $testRunner->getStats();
}

// Inicializar test runner global
$testRunner = new FastTestRunner();
testLog('INFO', 'FastTestRunner global inicializado');
?>
