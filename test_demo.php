<?php
/**
 * =====================================================
 * CLUBEMIX - DEMONSTRAÇÃO DO SISTEMA DE TESTES
 * =====================================================
 * Script para demonstrar o funcionamento básico dos testes
 * =====================================================
 */

require_once 'tests/TestRunner.php';

// Classe de teste simples para demonstração
class DemoTest extends TestCase
{
    public function testBasicAssertions()
    {
        $this->assertTrue(true, 'True deve ser true');
        $this->assertFalse(false, 'False deve ser false');
        $this->assertEquals(1, 1, 'Um deve ser igual a um');
        $this->assertNotEquals(1, 2, 'Um não deve ser igual a dois');
    }
    
    public function testStringOperations()
    {
        $text = 'ClubeMix';
        $this->assertContains('Club', $text, 'Texto deve conter "Club"');
        $this->assertNotEmpty($text, 'Texto não deve estar vazio');
    }
    
    public function testArrayOperations()
    {
        $array = [1, 2, 3];
        $this->assertIsArray($array, 'Deve ser um array');
        $this->assertNotEmpty($array, 'Array não deve estar vazio');
        $this->assertEquals(3, count($array), 'Array deve ter 3 elementos');
    }
    
    public function testMathOperations()
    {
        $result = 2 + 2;
        $this->assertEquals(4, $result, 'Dois mais dois deve ser quatro');
        
        $division = 10 / 2;
        $this->assertEquals(5, $division, 'Dez dividido por dois deve ser cinco');
    }
    
    public function testExceptionHandling()
    {
        $this->assertThrows(Exception::class, function() {
            throw new Exception('Teste de exceção');
        }, 'Deve lançar exceção');
    }
}

// Executar demonstração
echo "🎯 DEMONSTRAÇÃO DO SISTEMA DE TESTES CLUBEMIX\n";
echo "=============================================\n\n";

if (php_sapi_name() !== 'cli') {
    echo "<pre>\n";
}

try {
    $demo = new DemoTest('Demonstração');
    $results = $demo->runTests();
    
    echo "\n✨ Demonstração concluída com sucesso!\n";
    echo "📊 Estatísticas:\n";
    echo "   - Total de testes: {$results['total']}\n";
    echo "   - Testes passou: {$results['passed']}\n";
    echo "   - Testes falharam: {$results['failed']}\n";
    echo "   - Erros: {$results['errors']}\n";
    echo "   - Assertions: {$results['assertions']}\n";
    
    if ($results['failed'] === 0 && $results['errors'] === 0) {
        echo "\n🎉 TODOS OS TESTES DA DEMONSTRAÇÃO PASSARAM! 🎉\n";
    }
    
} catch (Exception $e) {
    echo "💥 ERRO: " . $e->getMessage() . "\n";
}

if (php_sapi_name() !== 'cli') {
    echo "</pre>\n";
}

echo "\n📖 Para executar todos os testes do sistema:\n";
echo "   🌐 Navegador: http://localhost/ClubeMix/run_tests.php\n";
echo "   💻 Terminal: php run_tests.php\n\n";
?>
