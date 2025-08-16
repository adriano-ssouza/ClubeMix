<?php
/**
 * =====================================================
 * CLUBEMIX - TESTES DA CLASSE APIBASE
 * =====================================================
 */

require_once __DIR__ . '/TestRunner.php';
require_once dirname(__DIR__) . '/config/config.php';

class ApiBaseTest extends TestCase
{
    /**
     * Testar se o arquivo da classe base existe
     */
    public function testApiBaseFileExists()
    {
        $filePath = dirname(__DIR__) . '/api/base/ApiBase.php';
        $this->assertTrue(file_exists($filePath), 'Arquivo da classe ApiBase deve existir');
    }
    
    /**
     * Testar validação de email - emails válidos
     */
    public function testValidateEmailValid()
    {
        $validEmails = [
            'teste@exemplo.com',
            'user.name@domain.co.uk',
            'user+tag@example.org',
            'test123@test-domain.com'
        ];
        
        foreach ($validEmails as $email) {
            $this->assertTrue(
                isValidEmail($email),
                "Email {$email} deve ser válido"
            );
        }
    }
    
    /**
     * Testar validação de email - emails inválidos
     */
    public function testValidateEmailInvalid()
    {
        $invalidEmails = [
            'email_sem_arroba.com',
            '@domain.com',
            'user@',
            'user@domain',
            'user name@domain.com', // Espaço
            ''
        ];
        
        foreach ($invalidEmails as $email) {
            $this->assertFalse(
                isValidEmail($email),
                "Email {$email} deve ser inválido"
            );
        }
    }
    
    /**
     * Testar validação de CPF - CPFs válidos
     */
    public function testValidateCPFValid()
    {
        $validCPFs = [
            '11144477735', // CPF válido
            '111.444.777-35', // Com formatação
        ];
        
        foreach ($validCPFs as $cpf) {
            $this->assertTrue(
                isValidCPF($cpf),
                "CPF {$cpf} deve ser válido"
            );
        }
    }
    
    /**
     * Testar validação de CPF - CPFs inválidos
     */
    public function testValidateCPFInvalid()
    {
        $invalidCPFs = [
            '11111111111', // Todos iguais
            '12345678901', // Inválido
            '123.456.789-01', // Inválido com formatação
            '123456789', // Muito curto
            '', // Vazio
            'abc.def.ghi-jk' // Não numérico
        ];
        
        foreach ($invalidCPFs as $cpf) {
            $this->assertFalse(
                isValidCPF($cpf),
                "CPF {$cpf} deve ser inválido"
            );
        }
    }
    
    /**
     * Testar validação de CNPJ - CNPJs válidos
     */
    public function testValidateCNPJValid()
    {
        $validCNPJs = [
            '11222333000181', // CNPJ válido
            '11.222.333/0001-81', // Com formatação
        ];
        
        foreach ($validCNPJs as $cnpj) {
            $this->assertTrue(
                isValidCNPJ($cnpj),
                "CNPJ {$cnpj} deve ser válido"
            );
        }
    }
    
    /**
     * Testar validação de CNPJ - CNPJs inválidos
     */
    public function testValidateCNPJInvalid()
    {
        $invalidCNPJs = [
            '11111111111111', // Todos iguais
            '12345678000100', // Inválido
            '123456789', // Muito curto
            '', // Vazio
            'ab.cde.fgh/ijkl-mn' // Não numérico
        ];
        
        foreach ($invalidCNPJs as $cnpj) {
            $this->assertFalse(
                isValidCNPJ($cnpj),
                "CNPJ {$cnpj} deve ser inválido"
            );
        }
    }
    
    /**
     * Testar sanitização de entrada
     */
    public function testSanitizeInput()
    {
        $input = [
            'nome' => '  João Silva  ',
            'descricao' => '<script>alert("xss")</script>Descrição',
            'numero' => 123
        ];
        
        $sanitized = sanitize($input);
        
        $this->assertEquals('João Silva', $sanitized['nome'], 'Deve remover espaços extras');
        $this->assertContains('Descrição', $sanitized['descricao'], 'Deve manter texto válido');
        $this->assertNotContains('<script>', $sanitized['descricao'], 'Deve escapar HTML perigoso');
        $this->assertEquals(123, $sanitized['numero'], 'Deve manter números');
    }
    
    /**
     * Testar formatação de telefone
     */
    public function testFormatPhone()
    {
        $tests = [
            '(11) 99999-9999' => '(11) 99999-9999',
            '11 99999-9999' => '(11) 99999-9999',
            '11999999999' => '(11) 99999-9999',
            'abc123def456' => '123456'
        ];
        
        foreach ($tests as $input => $expected) {
            $result = formatPhone($input);
            $this->assertEquals($expected, $result, "Formatação de {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de valores monetários
     */
    public function testFormatMoney()
    {
        $tests = [
            [1000.50, 'R$ 1.000,50'],
            [0, 'R$ 0,00'],
            [1234567.89, 'R$ 1.234.567,89'],
            [10, 'R$ 10,00'],
        ];
        
        foreach ($tests as $test) {
            $result = formatMoney($test[0]);
            $this->assertEquals($test[1], $result, "Formatação de valor {$test[0]} deve resultar em {$test[1]}");
        }
    }
    
    /**
     * Testar geração de tokens CSRF
     */
    public function testCSRFTokenGeneration()
    {
        // Iniciar sessão se não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $token1 = generateCSRFToken();
        $token2 = generateCSRFToken();
        
        $this->assertNotNull($token1, 'Token CSRF não deve ser null');
        $this->assertEquals($token1, $token2, 'Deve retornar o mesmo token na mesma sessão');
        
        $this->assertTrue(verifyCSRFToken($token1), 'Token válido deve passar na verificação');
        $this->assertFalse(verifyCSRFToken('token_inválido'), 'Token inválido deve falhar na verificação');
    }
    
    /**
     * Testar funções de ambiente
     */
    public function testEnvironmentFunctions()
    {
        $this->assertTrue(is_bool(isDevelopment()), 'isDevelopment deve retornar boolean');
        $this->assertTrue(is_bool(isProduction()), 'isProduction deve retornar boolean');
        $this->assertTrue(is_bool(isMaintenanceMode()), 'isMaintenanceMode deve retornar boolean');
    }
    
    /**
     * Testar geração de URLs
     */
    public function testUrlGeneration()
    {
        $baseUrl = url();
        $this->assertNotNull($baseUrl, 'URL base não deve ser null');
        $this->assertContains('http', $baseUrl, 'URL deve conter protocolo');
        
        $pageUrl = url('pagina.php');
        $this->assertContains('pagina.php', $pageUrl, 'URL deve conter página especificada');
        
        $assetUrl = asset('css/style.css');
        $this->assertContains('css/style.css', $assetUrl, 'Asset URL deve conter caminho do asset');
    }
}
?>