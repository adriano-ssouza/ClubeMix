<?php
/**
 * =====================================================
 * CLUBEMIX - SISTEMA DE LOGGING PARA DEBUG
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Sistema de logging para debug em ambiente de desenvolvimento
 * =====================================================
 */

class Logger
{
    private static $instance = null;
    private $logFile;
    private $debugEnabled;
    private $logLevel;
    
    // Cores para logs no arquivo
    private $colors = [
        'INFO' => '🔵',
        'SUCCESS' => '🟢', 
        'WARNING' => '🟡',
        'ERROR' => '🔴',
        'DEBUG' => '🐛',
        'API' => '📡',
        'DATABASE' => '🗄️',
        'VALIDATION' => '✅',
        'SECURITY' => '🔒'
    ];

    private function __construct()
    {
        // Verificar se debug está ativo
        $this->debugEnabled = $this->isDebugEnabled();
        
        // Definir nível de log
        $this->logLevel = $this->debugEnabled ? 'DEBUG' : 'ERROR';
        
        // Definir arquivo de log
        $this->logFile = $this->getLogFilePath();
        
        // Criar diretório se não existir
        $this->ensureLogDirectory();
        
        // Log inicial se debug estiver ativo
        if ($this->debugEnabled) {
            $this->writeInitialLog();
        }
    }

    /**
     * Singleton - retorna única instância
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Verificar se debug está ativo
     */
    private function isDebugEnabled()
    {
        // Verificar via GET parameter
        if (isset($_GET['debug']) && $_GET['debug'] === 'true') {
            return true;
        }
        
        // Verificar via POST parameter
        if (isset($_POST['debug']) && $_POST['debug'] === 'true') {
            return true;
        }
        
        // Verificar via header
        if (isset($_SERVER['HTTP_X_DEBUG']) && $_SERVER['HTTP_X_DEBUG'] === 'true') {
            return true;
        }
        
        // Verificar via arquivo de configuração
        $debugFile = dirname(__DIR__, 2) . '/logs/debug_enabled.flag';
        if (file_exists($debugFile)) {
            return true;
        }
        
        // Verificar via variável de ambiente
        if (getenv('CLUBEMIX_DEBUG') === 'true') {
            return true;
        }
        
        return false;
    }

    /**
     * Obter caminho do arquivo de log
     */
    private function getLogFilePath()
    {
        $logDir = dirname(__DIR__, 2) . '/logs';
        $date = date('Y-m-d');
        return $logDir . '/clubemix_debug_' . $date . '.log';
    }

    /**
     * Garantir que o diretório de logs existe
     */
    private function ensureLogDirectory()
    {
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }

    /**
     * Escrever log inicial
     */
    private function writeInitialLog()
    {
        $separator = str_repeat('=', 80);
        $timestamp = date('Y-m-d H:i:s');
        
        $initialLog = "\n{$separator}\n";
        $initialLog .= "🚀 CLUBEMIX DEBUG SESSION INICIADA - {$timestamp}\n";
        $initialLog .= "{$separator}\n";
        $initialLog .= "📍 IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
        $initialLog .= "🌐 User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown') . "\n";
        $initialLog .= "📄 Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'unknown') . "\n";
        $initialLog .= "🔧 Request Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'unknown') . "\n";
        $initialLog .= "{$separator}\n\n";
        
        file_put_contents($this->logFile, $initialLog, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log principal
     */
    public function log($level, $className, $methodName, $message, $data = null, $context = [])
    {
        if (!$this->debugEnabled && !in_array($level, ['ERROR', 'WARNING'])) {
            return;
        }

        $timestamp = date('Y-m-d H:i:s.') . substr(microtime(), 2, 3);
        $icon = $this->colors[$level] ?? '📝';
        
        // Montar log entry
        $logEntry = "[{$timestamp}] {$icon} [{$level}] {$className}::{$methodName}()\n";
        $logEntry .= "    📝 Message: {$message}\n";
        
        // Adicionar dados se fornecidos
        if ($data !== null) {
            $logEntry .= "    📊 Data: " . $this->formatData($data) . "\n";
        }
        
        // Adicionar contexto se fornecido
        if (!empty($context)) {
            $logEntry .= "    🔍 Context: " . $this->formatData($context) . "\n";
        }
        
        // Adicionar informações da requisição
        $logEntry .= "    🌐 Request: " . ($_SERVER['REQUEST_METHOD'] ?? 'unknown') . " " . ($_SERVER['REQUEST_URI'] ?? 'unknown') . "\n";
        
        // Adicionar stack trace para erros
        if ($level === 'ERROR' || ($this->debugEnabled && $level === 'DEBUG')) {
            $logEntry .= "    📍 Stack Trace:\n";
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
            foreach ($trace as $i => $frame) {
                if ($i === 0) continue; // Pular a própria função de log
                $file = basename($frame['file'] ?? 'unknown');
                $line = $frame['line'] ?? 'unknown';
                $function = $frame['function'] ?? 'unknown';
                $class = isset($frame['class']) ? $frame['class'] . '::' : '';
                $logEntry .= "        #{$i} {$file}:{$line} - {$class}{$function}()\n";
            }
        }
        
        $logEntry .= "\n";
        
        // Escrever no arquivo
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Formatar dados para log
     */
    private function formatData($data)
    {
        if (is_array($data) || is_object($data)) {
            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        
        if (is_bool($data)) {
            return $data ? 'true' : 'false';
        }
        
        if (is_null($data)) {
            return 'null';
        }
        
        return (string) $data;
    }

    /**
     * Métodos de conveniência para diferentes níveis
     */
    public function info($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('INFO', $className, $methodName, $message, $data, $context);
    }

    public function success($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('SUCCESS', $className, $methodName, $message, $data, $context);
    }

    public function warning($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('WARNING', $className, $methodName, $message, $data, $context);
    }

    public function error($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('ERROR', $className, $methodName, $message, $data, $context);
    }

    public function debug($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('DEBUG', $className, $methodName, $message, $data, $context);
    }

    public function api($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('API', $className, $methodName, $message, $data, $context);
    }

    public function database($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('DATABASE', $className, $methodName, $message, $data, $context);
    }

    public function validation($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('VALIDATION', $className, $methodName, $message, $data, $context);
    }

    public function security($className, $methodName, $message, $data = null, $context = [])
    {
        $this->log('SECURITY', $className, $methodName, $message, $data, $context);
    }

    /**
     * Verificar se debug está ativo
     */
    public function isDebugActive()
    {
        return $this->debugEnabled;
    }

    /**
     * Obter caminho do arquivo de log atual
     */
    public function getLogFile()
    {
        return $this->logFile;
    }

    /**
     * Ativar debug via arquivo flag
     */
    public static function enableDebug()
    {
        $debugFile = dirname(__DIR__, 2) . '/logs/debug_enabled.flag';
        $logDir = dirname($debugFile);
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        file_put_contents($debugFile, date('Y-m-d H:i:s') . " - Debug enabled\n");
        return true;
    }

    /**
     * Desativar debug removendo arquivo flag
     */
    public static function disableDebug()
    {
        $debugFile = dirname(__DIR__, 2) . '/logs/debug_enabled.flag';
        if (file_exists($debugFile)) {
            unlink($debugFile);
        }
        return true;
    }

    /**
     * Limpar logs antigos (manter apenas últimos 7 dias)
     */
    public static function cleanOldLogs()
    {
        $logDir = dirname(__DIR__, 2) . '/logs';
        if (!is_dir($logDir)) {
            return;
        }
        
        $files = glob($logDir . '/clubemix_debug_*.log');
        $cutoffDate = strtotime('-7 days');
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoffDate) {
                unlink($file);
            }
        }
    }
}

/**
 * Função helper global para logging
 */
function debugLog($level, $className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->log($level, $className, $methodName, $message, $data, $context);
}

/**
 * Funções helper específicas
 */
function logInfo($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->info($className, $methodName, $message, $data, $context);
}

function logSuccess($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->success($className, $methodName, $message, $data, $context);
}

function logError($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->error($className, $methodName, $message, $data, $context);
}

function logDebug($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->debug($className, $methodName, $message, $data, $context);
}

function logApi($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->api($className, $methodName, $message, $data, $context);
}

function logValidation($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->validation($className, $methodName, $message, $data, $context);
}

function logSecurity($className, $methodName, $message, $data = null, $context = [])
{
    Logger::getInstance()->security($className, $methodName, $message, $data, $context);
}
?>
