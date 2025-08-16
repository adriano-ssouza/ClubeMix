<?php
/**
 * =====================================================
 * CLUBEMIX - SISTEMA DE TESTES
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Sistema de testes unitários para ClubeMix
 * =====================================================
 */

// Definir constante do sistema para testes
if (!defined('CLUBEMIX_SYSTEM')) {
    define('CLUBEMIX_SYSTEM', true);
}
if (!defined('CLUBEMIX_TESTING')) {
    define('CLUBEMIX_TESTING', true);
}

// Incluir configurações
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/api/base/Logger.php';

/**
 * Classe base para testes
 */
abstract class TestCase
{
    protected $testName;
    protected $assertions = 0;
    protected $failures = 0;
    protected $errors = 0;
    protected $results = [];
    
    public function __construct($testName = null)
    {
        $this->testName = $testName ?: get_class($this);
    }
    
    /**
     * Executar todos os testes da classe
     */
    public function runTests()
    {
        echo "\n🧪 Executando testes: {$this->testName}\n";
        echo str_repeat('-', 50) . "\n";
        
        $methods = get_class_methods($this);
        $testMethods = array_filter($methods, function($method) {
            return strpos($method, 'test') === 0;
        });
        
        foreach ($testMethods as $method) {
            $this->runTest($method);
        }
        
        $this->printSummary();
        return $this->getResults();
    }
    
    /**
     * Executar um teste específico
     */
    private function runTest($method)
    {
        echo "  ▶️ {$method}... ";
        
        try {
            $this->setUp();
            $this->$method();
            $this->tearDown();
            echo "✅ PASS\n";
            $this->results[$method] = 'PASS';
        } catch (AssertionException $e) {
            echo "❌ FAIL: {$e->getMessage()}\n";
            $this->failures++;
            $this->results[$method] = 'FAIL: ' . $e->getMessage();
        } catch (Exception $e) {
            echo "💥 ERROR: {$e->getMessage()}\n";
            $this->errors++;
            $this->results[$method] = 'ERROR: ' . $e->getMessage();
        }
    }
    
    /**
     * Setup executado antes de cada teste
     */
    protected function setUp() {}
    
    /**
     * Teardown executado após cada teste
     */
    protected function tearDown() {}
    
    /**
     * Imprimir resumo dos testes
     */
    private function printSummary()
    {
        $total = count($this->results);
        $passed = $total - $this->failures - $this->errors;
        
        echo "\n📊 Resumo:\n";
        echo "  Total: {$total}\n";
        echo "  ✅ Passou: {$passed}\n";
        echo "  ❌ Falhou: {$this->failures}\n";
        echo "  💥 Erros: {$this->errors}\n";
        echo "  📈 Assertions: {$this->assertions}\n\n";
    }
    
    /**
     * Obter resultados dos testes
     */
    public function getResults()
    {
        return [
            'total' => count($this->results),
            'passed' => count($this->results) - $this->failures - $this->errors,
            'failed' => $this->failures,
            'errors' => $this->errors,
            'assertions' => $this->assertions,
            'results' => $this->results
        ];
    }
    
    // ===== MÉTODOS DE ASSERTION =====
    
    /**
     * Verificar se é verdadeiro
     */
    protected function assertTrue($condition, $message = '')
    {
        $this->assertions++;
        if (!$condition) {
            throw new AssertionException($message ?: 'Expected true, got false');
        }
    }
    
    /**
     * Verificar se é falso
     */
    protected function assertFalse($condition, $message = '')
    {
        $this->assertions++;
        if ($condition) {
            throw new AssertionException($message ?: 'Expected false, got true');
        }
    }
    
    /**
     * Verificar igualdade
     */
    protected function assertEquals($expected, $actual, $message = '')
    {
        $this->assertions++;
        if ($expected !== $actual) {
            $expectedStr = is_scalar($expected) ? $expected : json_encode($expected);
            $actualStr = is_scalar($actual) ? $actual : json_encode($actual);
            throw new AssertionException($message ?: "Expected '{$expectedStr}', got '{$actualStr}'");
        }
    }
    
    /**
     * Verificar se não é igual
     */
    protected function assertNotEquals($expected, $actual, $message = '')
    {
        $this->assertions++;
        if ($expected === $actual) {
            throw new AssertionException($message ?: "Expected not equals, but got same value");
        }
    }
    
    /**
     * Verificar se é null
     */
    protected function assertNull($value, $message = '')
    {
        $this->assertions++;
        if ($value !== null) {
            throw new AssertionException($message ?: 'Expected null, got ' . gettype($value));
        }
    }
    
    /**
     * Verificar se não é null
     */
    protected function assertNotNull($value, $message = '')
    {
        $this->assertions++;
        if ($value === null) {
            throw new AssertionException($message ?: 'Expected not null, got null');
        }
    }
    
    /**
     * Verificar se contém substring
     */
    protected function assertContains($needle, $haystack, $message = '')
    {
        $this->assertions++;
        if (strpos($haystack, $needle) === false) {
            throw new AssertionException($message ?: "String '{$haystack}' does not contain '{$needle}'");
        }
    }
    
    /**
     * Verificar se não contém substring
     */
    protected function assertNotContains($needle, $haystack, $message = '')
    {
        $this->assertions++;
        if (strpos($haystack, $needle) !== false) {
            throw new AssertionException($message ?: "String '{$haystack}' should not contain '{$needle}'");
        }
    }

    protected function assertArrayHasKey($key, $array, $message = '')
    {
        $this->assertions++;
        if (!array_key_exists($key, $array)) {
            throw new AssertionException($message ?: "Array should contain key '{$key}'");
        }
    }
    
    /**
     * Verificar se é array
     */
    protected function assertIsArray($value, $message = '')
    {
        $this->assertions++;
        if (!is_array($value)) {
            throw new AssertionException($message ?: 'Expected array, got ' . gettype($value));
        }
    }
    
    /**
     * Verificar se array está vazio
     */
    protected function assertEmpty($value, $message = '')
    {
        $this->assertions++;
        if (!empty($value)) {
            throw new AssertionException($message ?: 'Expected empty, got non-empty value');
        }
    }
    
    /**
     * Verificar se array não está vazio
     */
    protected function assertNotEmpty($value, $message = '')
    {
        $this->assertions++;
        if (empty($value)) {
            throw new AssertionException($message ?: 'Expected not empty, got empty value');
        }
    }
    
    /**
     * Verificar se exceção é lançada
     */
    protected function assertThrows($exceptionClass, $callable, $message = '')
    {
        $this->assertions++;
        try {
            $callable();
            throw new AssertionException($message ?: "Expected {$exceptionClass} to be thrown");
        } catch (Exception $e) {
            if (!($e instanceof $exceptionClass)) {
                throw new AssertionException($message ?: "Expected {$exceptionClass}, got " . get_class($e));
            }
        }
    }
}

/**
 * Exceção para falhas de assertion
 */
class AssertionException extends Exception {}

/**
 * Classe principal para executar todos os testes
 */
class TestRunner
{
    private $testClasses = [];
    private $totalResults = [];
    
    /**
     * Adicionar classe de teste
     */
    public function addTestClass($className)
    {
        $this->testClasses[] = $className;
        return $this;
    }
    
    /**
     * Executar todos os testes
     */
    public function runAllTests()
    {
        echo "🚀 INICIANDO TESTES CLUBEMIX\n";
        echo str_repeat('=', 60) . "\n";
        
        foreach ($this->testClasses as $className) {
            if (class_exists($className)) {
                $test = new $className();
                $results = $test->runTests();
                $this->totalResults[$className] = $results;
            } else {
                echo "⚠️ Classe de teste não encontrada: {$className}\n";
            }
        }
        
        $this->printFinalSummary();
    }
    
    /**
     * Imprimir resumo final
     */
    private function printFinalSummary()
    {
        echo str_repeat('=', 60) . "\n";
        echo "📋 RESUMO FINAL DOS TESTES\n";
        echo str_repeat('=', 60) . "\n";
        
        $totalTests = 0;
        $totalPassed = 0;
        $totalFailed = 0;
        $totalErrors = 0;
        $totalAssertions = 0;
        
        foreach ($this->totalResults as $className => $results) {
            echo "📦 {$className}:\n";
            echo "   ✅ Passou: {$results['passed']}\n";
            echo "   ❌ Falhou: {$results['failed']}\n";
            echo "   💥 Erros: {$results['errors']}\n";
            echo "   📈 Assertions: {$results['assertions']}\n\n";
            
            $totalTests += $results['total'];
            $totalPassed += $results['passed'];
            $totalFailed += $results['failed'];
            $totalErrors += $results['errors'];
            $totalAssertions += $results['assertions'];
        }
        
        echo str_repeat('-', 60) . "\n";
        echo "🎯 TOTAL GERAL:\n";
        echo "   📊 Testes: {$totalTests}\n";
        echo "   ✅ Passou: {$totalPassed}\n";
        echo "   ❌ Falhou: {$totalFailed}\n";
        echo "   💥 Erros: {$totalErrors}\n";
        echo "   📈 Assertions: {$totalAssertions}\n";
        
        $successRate = $totalTests > 0 ? round(($totalPassed / $totalTests) * 100, 2) : 0;
        echo "   📈 Taxa de Sucesso: {$successRate}%\n";
        
        if ($totalFailed === 0 && $totalErrors === 0) {
            echo "\n🎉 TODOS OS TESTES PASSARAM! 🎉\n";
        } else {
            echo "\n⚠️ ALGUNS TESTES FALHARAM ⚠️\n";
        }
        
        echo str_repeat('=', 60) . "\n";
    }
}
?>
