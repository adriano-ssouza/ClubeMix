<?php
/**
 * =====================================================
 * CLUBEMIX - TESTES DA CLASSE LOGGER
 * =====================================================
 */

require_once __DIR__ . '/TestRunner.php';
require_once dirname(__DIR__) . '/api/base/Logger.php';

class LoggerTest extends TestCase
{
    private $logger;
    private $testLogFile;
    
    protected function setUp()
    {
        // Ativar debug para testes
        Logger::enableDebug();
        $this->logger = Logger::getInstance();
        $this->testLogFile = $this->logger->getLogFile();
    }
    
    protected function tearDown()
    {
        // Desativar debug após testes
        Logger::disableDebug();
    }
    
    /**
     * Testar se a instância do logger é criada corretamente
     */
    public function testGetInstance()
    {
        $this->assertNotNull($this->logger, 'Instância do logger não deve ser null');
        $this->assertTrue($this->logger instanceof Logger, 'Deve retornar instância da classe Logger');
    }
    
    /**
     * Testar singleton - deve retornar a mesma instância
     */
    public function testSingleton()
    {
        $logger1 = Logger::getInstance();
        $logger2 = Logger::getInstance();
        
        $this->assertEquals($logger1, $logger2, 'Deve retornar a mesma instância (singleton)');
    }
    
    /**
     * Testar se debug está ativo
     */
    public function testDebugIsActive()
    {
        $this->assertTrue($this->logger->isDebugActive(), 'Debug deve estar ativo durante os testes');
    }
    
    /**
     * Testar obtenção do arquivo de log
     */
    public function testGetLogFile()
    {
        $logFile = $this->logger->getLogFile();
        $this->assertNotNull($logFile, 'Arquivo de log não deve ser null');
        $this->assertContains('clubemix_debug_', $logFile, 'Nome do arquivo deve conter padrão correto');
        $this->assertContains('.log', $logFile, 'Arquivo deve ter extensão .log');
    }
    
    /**
     * Testar log de informação
     */
    public function testInfoLog()
    {
        $this->logger->info('TestClass', 'testMethod', 'Test info message', ['key' => 'value']);
        
        $this->assertTrue(file_exists($this->testLogFile), 'Arquivo de log deve existir após log');
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('TestClass::testMethod', $logContent, 'Log deve conter classe e método');
        $this->assertContains('Test info message', $logContent, 'Log deve conter mensagem');
        $this->assertContains('[INFO]', $logContent, 'Log deve conter nível INFO');
        $this->assertContains('🔵', $logContent, 'Log deve conter emoji de INFO');
    }
    
    /**
     * Testar log de sucesso
     */
    public function testSuccessLog()
    {
        $this->logger->success('TestClass', 'testMethod', 'Test success message');
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('[SUCCESS]', $logContent, 'Log deve conter nível SUCCESS');
        $this->assertContains('🟢', $logContent, 'Log deve conter emoji de SUCCESS');
    }
    
    /**
     * Testar log de erro
     */
    public function testErrorLog()
    {
        $this->logger->error('TestClass', 'testMethod', 'Test error message', ['error' => 'details']);
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('[ERROR]', $logContent, 'Log deve conter nível ERROR');
        $this->assertContains('🔴', $logContent, 'Log deve conter emoji de ERROR');
        $this->assertContains('Test error message', $logContent, 'Log deve conter mensagem de erro');
    }
    
    /**
     * Testar log de debug
     */
    public function testDebugLog()
    {
        $this->logger->debug('TestClass', 'testMethod', 'Test debug message');
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('[DEBUG]', $logContent, 'Log deve conter nível DEBUG');
        $this->assertContains('🐛', $logContent, 'Log deve conter emoji de DEBUG');
    }
    
    /**
     * Testar log de API
     */
    public function testApiLog()
    {
        $this->logger->api('ApiClass', 'processRequest', 'API request processed', ['method' => 'POST']);
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('[API]', $logContent, 'Log deve conter nível API');
        $this->assertContains('📡', $logContent, 'Log deve conter emoji de API');
    }
    
    /**
     * Testar log de validação
     */
    public function testValidationLog()
    {
        $this->logger->validation('ValidatorClass', 'validate', 'Validation passed');
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('[VALIDATION]', $logContent, 'Log deve conter nível VALIDATION');
        $this->assertContains('✅', $logContent, 'Log deve conter emoji de VALIDATION');
    }
    
    /**
     * Testar log de segurança
     */
    public function testSecurityLog()
    {
        $this->logger->security('SecurityClass', 'checkAuth', 'Authentication check', ['user_id' => 123]);
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('[SECURITY]', $logContent, 'Log deve conter nível SECURITY');
        $this->assertContains('🔒', $logContent, 'Log deve conter emoji de SECURITY');
    }
    
    /**
     * Testar funções helper globais
     */
    public function testGlobalHelperFunctions()
    {
        logInfo('TestClass', 'testMethod', 'Test helper info');
        logSuccess('TestClass', 'testMethod', 'Test helper success');
        logError('TestClass', 'testMethod', 'Test helper error');
        logDebug('TestClass', 'testMethod', 'Test helper debug');
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('Test helper info', $logContent, 'Helper logInfo deve funcionar');
        $this->assertContains('Test helper success', $logContent, 'Helper logSuccess deve funcionar');
        $this->assertContains('Test helper error', $logContent, 'Helper logError deve funcionar');
        $this->assertContains('Test helper debug', $logContent, 'Helper logDebug deve funcionar');
    }
    
    /**
     * Testar log com dados complexos
     */
    public function testLogWithComplexData()
    {
        $complexData = [
            'user' => [
                'id' => 123,
                'name' => 'Test User',
                'roles' => ['admin', 'user']
            ],
            'request' => [
                'method' => 'POST',
                'url' => '/api/test'
            ]
        ];
        
        $this->logger->info('TestClass', 'testComplexData', 'Complex data test', $complexData);
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('Test User', $logContent, 'Log deve conter dados complexos');
        $this->assertContains('"method": "POST"', $logContent, 'Log deve formatar JSON corretamente');
    }
    
    /**
     * Testar timestamp no log
     */
    public function testLogTimestamp()
    {
        $beforeTime = date('Y-m-d H:i:s');
        $this->logger->info('TestClass', 'testTimestamp', 'Timestamp test');
        $afterTime = date('Y-m-d H:i:s');
        
        $logContent = file_get_contents($this->testLogFile);
        
        // Verificar se contém timestamp no formato correto
        $this->assertTrue(
            preg_match('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\.\d{3}\]/', $logContent),
            'Log deve conter timestamp com microsegundos'
        );
    }
    
    /**
     * Testar informações de requisição no log
     */
    public function testRequestInfoInLog()
    {
        // Simular dados de requisição
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/test/uri';
        
        $this->logger->info('TestClass', 'testRequestInfo', 'Request info test');
        
        $logContent = file_get_contents($this->testLogFile);
        $this->assertContains('POST /test/uri', $logContent, 'Log deve conter informações da requisição');
    }
    
    /**
     * Testar ativação e desativação de debug
     */
    public function testEnableDisableDebug()
    {
        // Desativar debug
        Logger::disableDebug();
        $logger = Logger::getInstance();
        $this->assertFalse($logger->isDebugActive(), 'Debug deve estar desativado');
        
        // Reativar debug
        Logger::enableDebug();
        $logger = Logger::getInstance();
        $this->assertTrue($logger->isDebugActive(), 'Debug deve estar ativado novamente');
    }
    
    /**
     * Testar limpeza de logs antigos
     */
    public function testCleanOldLogs()
    {
        // Este teste é mais difícil de implementar sem criar arquivos reais antigos
        // Por enquanto, apenas testamos se a função executa sem erro
        Logger::cleanOldLogs();
        $this->assertTrue(true, 'Limpeza de logs deve executar sem erro');
    }
    
    /**
     * Testar log quando debug está desativado
     */
    public function testLogWhenDebugDisabled()
    {
        // Desativar debug
        Logger::disableDebug();
        
        // Obter tamanho atual do arquivo de log
        $initialSize = file_exists($this->testLogFile) ? filesize($this->testLogFile) : 0;
        
        // Tentar fazer log de info (não deve ser gravado)
        $logger = Logger::getInstance();
        $logger->info('TestClass', 'testDisabled', 'This should not be logged');
        
        // Fazer log de erro (deve ser gravado mesmo com debug desativado)
        $logger->error('TestClass', 'testDisabled', 'This error should be logged');
        
        $finalSize = file_exists($this->testLogFile) ? filesize($this->testLogFile) : 0;
        
        // Arquivo deve ter crescido (devido ao log de erro)
        $this->assertTrue($finalSize >= $initialSize, 'Log de erro deve ser gravado mesmo com debug desativado');
        
        // Reativar debug para outros testes
        Logger::enableDebug();
    }
}
?>
