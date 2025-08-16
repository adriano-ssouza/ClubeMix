<?php
/**
 * =====================================================
 * CLUBEMIX - TESTES DE VALIDAÇÕES
 * =====================================================
 */

require_once __DIR__ . '/TestRunner.php';
require_once dirname(__DIR__) . '/config/config.php';

class ValidationTest extends TestCase
{
    /**
     * Testar validação de CPF usando função global
     */
    public function testIsValidCPF()
    {
        $validCPFs = [
            '11144477735',
            '111.444.777-35',
            '12345678909', // CPF válido
        ];
        
        $invalidCPFs = [
            '11111111111', // Todos iguais
            '12345678901', // Inválido
            '123.456.789-01', // Inválido com formatação
            '123456789', // Muito curto
            '', // Vazio
            'abc.def.ghi-jk' // Não numérico
        ];
        
        foreach ($validCPFs as $cpf) {
            $this->assertTrue(isValidCPF($cpf), "CPF {$cpf} deve ser válido");
        }
        
        foreach ($invalidCPFs as $cpf) {
            $this->assertFalse(isValidCPF($cpf), "CPF {$cpf} deve ser inválido");
        }
    }
    
    /**
     * Testar validação de CNPJ usando função global
     */
    public function testIsValidCNPJ()
    {
        $validCNPJs = [
            '11222333000181',
            '11.222.333/0001-81',
        ];
        
        $invalidCNPJs = [
            '11111111111111', // Todos iguais
            '12345678000100', // Inválido
            '123456789', // Muito curto
            '', // Vazio
            'ab.cde.fgh/ijkl-mn' // Não numérico
        ];
        
        foreach ($validCNPJs as $cnpj) {
            $this->assertTrue(isValidCNPJ($cnpj), "CNPJ {$cnpj} deve ser válido");
        }
        
        foreach ($invalidCNPJs as $cnpj) {
            $this->assertFalse(isValidCNPJ($cnpj), "CNPJ {$cnpj} deve ser inválido");
        }
    }
    
    /**
     * Testar validação de email usando função global
     */
    public function testIsValidEmail()
    {
        $validEmails = [
            'teste@exemplo.com',
            'user.name@domain.co.uk',
            'user+tag@example.org',
            'test123@test-domain.com'
        ];
        
        $invalidEmails = [
            'email_sem_arroba.com',
            '@domain.com',
            'user@',
            'user@domain',
            'user name@domain.com', // Espaço
            ''
        ];
        
        foreach ($validEmails as $email) {
            $this->assertTrue(isValidEmail($email), "Email {$email} deve ser válido");
        }
        
        foreach ($invalidEmails as $email) {
            $this->assertFalse(isValidEmail($email), "Email {$email} deve ser inválido");
        }
    }
    
    /**
     * Testar formatação de CPF
     */
    public function testFormatCPF()
    {
        $tests = [
            '11144477735' => '111.444.777-35',
            '12345678901' => '123.456.789-01',
            '111.444.777-35' => '111.444.777-35', // Já formatado
            '111abc444def777ghi35' => '111.444.777-35', // Com caracteres
        ];
        
        foreach ($tests as $input => $expected) {
            $result = formatCPF($input);
            $this->assertEquals($expected, $result, "Formatação de CPF {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de CNPJ
     */
    public function testFormatCNPJ()
    {
        $tests = [
            '11222333000181' => '11.222.333/0001-81',
            '12345678000100' => '12.345.678/0001-00',
            '11.222.333/0001-81' => '11.222.333/0001-81', // Já formatado
        ];
        
        foreach ($tests as $input => $expected) {
            $result = formatCNPJ($input);
            $this->assertEquals($expected, $result, "Formatação de CNPJ {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de telefone
     */
    public function testFormatPhone()
    {
        $tests = [
            '11999999999' => '(11) 99999-9999',
            '1199999999' => '(11) 9999-9999',
            '11 99999-9999' => '(11) 99999-9999',
            '(11) 99999-9999' => '(11) 99999-9999', // Já formatado
            '123' => '123', // Muito curto, retorna como está
        ];
        
        foreach ($tests as $input => $expected) {
            $result = formatPhone($input);
            $this->assertEquals($expected, $result, "Formatação de telefone {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de CEP
     */
    public function testFormatCEP()
    {
        $tests = [
            '01310100' => '01310-100',
            '12345678' => '12345-678',
            '01310-100' => '01310-100', // Já formatado
            '01abc310def100' => '01310-100', // Com caracteres
        ];
        
        foreach ($tests as $input => $expected) {
            $result = formatCEP($input);
            $this->assertEquals($expected, $result, "Formatação de CEP {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de valor monetário
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
     * Testar formatação de valor monetário com símbolo customizado
     */
    public function testFormatMoneyCustomSymbol()
    {
        $result = formatMoney(100.50, '$');
        $this->assertEquals('$ 100,50', $result, 'Deve aceitar símbolo customizado');
        
        $result = formatMoney(1000, '€');
        $this->assertEquals('€ 1.000,00', $result, 'Deve aceitar símbolo Euro');
    }
    
    /**
     * Testar função sanitize
     */
    public function testSanitize()
    {
        $tests = [
            '  texto com espaços  ' => 'texto com espaços',
            '<script>alert("xss")</script>' => '&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;',
            'texto "normal"' => 'texto &quot;normal&quot;',
            "texto 'com aspas'" => 'texto &#039;com aspas&#039;',
        ];
        
        foreach ($tests as $input => $expected) {
            $result = sanitize($input);
            $this->assertEquals($expected, $result, "Sanitização de '{$input}' deve resultar em '{$expected}'");
        }
    }
    
    /**
     * Testar sanitize com array
     */
    public function testSanitizeArray()
    {
        $input = [
            'nome' => '  João Silva  ',
            'email' => '<script>test@email.com</script>',
            'nested' => [
                'field' => '  valor  '
            ]
        ];
        
        $result = sanitize($input);
        
        $this->assertEquals('João Silva', $result['nome'], 'Deve sanitizar nome');
        $this->assertContains('test@email.com', $result['email'], 'Deve manter email válido');
        $this->assertNotContains('<script>', $result['email'], 'Deve escapar script');
        $this->assertEquals('valor', $result['nested']['field'], 'Deve sanitizar arrays aninhados');
    }
    
    /**
     * Testar geração e verificação de token CSRF
     */
    public function testCSRFToken()
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
        
        // Verificar que são opostos (assumindo que não estamos em produção durante testes)
        if (ENVIRONMENT === 'development') {
            $this->assertTrue(isDevelopment(), 'Deve estar em desenvolvimento');
            $this->assertFalse(isProduction(), 'Não deve estar em produção');
        }
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
    
    /**
     * Testar função getConfig
     */
    public function testGetConfig()
    {
        $systemName = getConfig('SYSTEM_NAME', 'Default');
        $this->assertNotNull($systemName, 'Config deve retornar valor');
        
        $nonExistent = getConfig('CONFIG_INEXISTENTE', 'valor_padrao');
        $this->assertEquals('valor_padrao', $nonExistent, 'Deve retornar valor padrão para config inexistente');
    }
}
?>
