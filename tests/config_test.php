<?php
/**
 * =====================================================
 * CLUBEMIX - CONFIGURAÇÃO OTIMIZADA PARA TESTES
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Configurações que aceleram a execução dos testes
 * =====================================================
 */

// Configurações para acelerar testes
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 30);
ini_set('display_errors', 0);
ini_set('log_errors', 0);

// Desabilitar funções lentas durante testes
ini_set('session.cookie_httponly', 0);
ini_set('session.cookie_secure', 0);
ini_set('session.use_strict_mode', 0);

// Configurações de banco para testes
define('TEST_DB_HOST', 'localhost');
define('TEST_DB_NAME', 'clubemix_test');
define('TEST_DB_USER', 'root');
define('TEST_DB_PASS', '');

// Configurações de logging para testes
define('TEST_LOG_LEVEL', 'ERROR'); // Apenas erros críticos
define('TEST_LOG_TO_FILE', false); // Não escrever em arquivo
define('TEST_LOG_TO_CONSOLE', true); // Log no console

// Função para log rápido durante testes
function testLog($level, $message, $context = []) {
    if (TEST_LOG_LEVEL === 'ERROR' && $level !== 'ERROR') {
        return;
    }
    
    if (TEST_LOG_TO_CONSOLE) {
        $timestamp = date('H:i:s');
        echo "[{$timestamp}] [{$level}] {$message}\n";
        
        if (!empty($context)) {
            echo "Context: " . json_encode($context, JSON_PRETTY_PRINT) . "\n";
        }
    }
}

// Funções de log mockadas para testes
function logDebug($class, $method, $message, $context = []) {
    testLog('DEBUG', $message, $context);
}

function logInfo($class, $method, $message, $context = []) {
    testLog('INFO', $message, $context);
}

function logError($class, $method, $message, $context = []) {
    testLog('ERROR', $message, $context);
}

function logSuccess($class, $method, $message, $context = []) {
    testLog('SUCCESS', $message, $context);
}

function logSecurity($class, $method, $message, $context = []) {
    testLog('SECURITY', $message, $context);
}

function logValidation($class, $method, $message, $context = []) {
    testLog('VALIDATION', $message, $context);
}

function logApi($class, $method, $message, $context = []) {
    testLog('API', $message, $context);
}

function logSystem($message, $level, $context = []) {
    testLog($level, $message, $context);
}

// Configurações de sessão para testes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpar sessão antes dos testes
$_SESSION = [];

// Função para limpar dados de teste
function clearTestData() {
    global $pdo;
    
    if (isset($pdo)) {
        $pdo->exec("DELETE FROM tentativas_login WHERE email LIKE '%test%'");
        $pdo->exec("DELETE FROM sessoes WHERE dados LIKE '%test%'");
    }
}

// Função para setup rápido de banco de teste
function setupTestDatabase() {
    try {
        $pdo = new PDO(
            "mysql:host=" . TEST_DB_HOST . ";dbname=" . TEST_DB_NAME,
            TEST_DB_USER,
            TEST_DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]
        );
        
        return $pdo;
    } catch (PDOException $e) {
        testLog('ERROR', 'Falha ao conectar com banco de teste: ' . $e->getMessage());
        return null;
    }
}

// Configurações de timezone para testes
date_default_timezone_set('America/Sao_Paulo');

// Função para medir tempo de execução
function measureExecutionTime($callback, $description = '') {
    $start = microtime(true);
    $result = $callback();
    $end = microtime(true);
    
    $time = round(($end - $start) * 1000, 2);
    testLog('INFO', "Execução {$description}: {$time}ms");
    
    return $result;
}

// Função para executar testes em paralelo (simulação)
function runTestsInParallel($tests) {
    $results = [];
    
    foreach ($tests as $test) {
        $start = microtime(true);
        $result = $test();
        $end = microtime(true);
        
        $results[] = [
            'test' => $test,
            'result' => $result,
            'time' => round(($end - $start) * 1000, 2)
        ];
    }
    
    return $results;
}

// Configurações de cache para testes
define('TEST_CACHE_ENABLED', true);
define('TEST_CACHE_TTL', 300); // 5 minutos

// Função de cache simples para testes
function testCache($key, $callback, $ttl = null) {
    if (!TEST_CACHE_ENABLED) {
        return $callback();
    }
    
    $ttl = $ttl ?? TEST_CACHE_TTL;
    $cacheFile = sys_get_temp_dir() . '/clubemix_test_' . md5($key) . '.cache';
    
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        return unserialize(file_get_contents($cacheFile));
    }
    
    $result = $callback();
    file_put_contents($cacheFile, serialize($result));
    
    return $result;
}

// Função para limpar cache de testes
function clearTestCache() {
    $pattern = sys_get_temp_dir() . '/clubemix_test_*.cache';
    $files = glob($pattern);
    
    foreach ($files as $file) {
        unlink($file);
    }
}

// Configurações de autoload para testes
spl_autoload_register(function ($class) {
    $paths = [
        'tests/',
        'api/',
        'api/base/',
        'api/auth/',
        'config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Função para executar teste com timeout
function runTestWithTimeout($callback, $timeout = 10) {
    $start = time();
    
    try {
        $result = $callback();
        
        if ((time() - $start) > $timeout) {
            testLog('WARNING', 'Teste executou por mais de ' . $timeout . ' segundos');
        }
        
        return $result;
    } catch (Exception $e) {
        testLog('ERROR', 'Teste falhou: ' . $e->getMessage());
        throw $e;
    }
}

// Configurações finais
testLog('INFO', 'Configuração de testes carregada com sucesso');
testLog('INFO', 'Memória disponível: ' . ini_get('memory_limit'));
testLog('INFO', 'Tempo máximo de execução: ' . ini_get('max_execution_time') . 's');
?>
