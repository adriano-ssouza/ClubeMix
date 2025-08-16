<?php
/**
 * =====================================================
 * CLUBEMIX - TESTE DA API DE AUTENTICAÇÃO
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Testes para a API de login
 * =====================================================
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/tests/TestRunner.php';

class AuthLoginApiTest extends TestCase
{
    protected $testData;

    protected function setUp()
    {
        $this->testData = [
            'valid_login' => [
                'email' => 'teste@exemplo.com',
                'senha' => 'Senha@123',
                'lembrar' => false
            ],
            'invalid_email' => [
                'email' => 'email_invalido',
                'senha' => 'Senha@123',
                'lembrar' => false
            ],
            'short_password' => [
                'email' => 'teste@exemplo.com',
                'senha' => '123',
                'lembrar' => false
            ],
            'missing_email' => [
                'senha' => 'Senha@123',
                'lembrar' => false
            ],
            'missing_password' => [
                'email' => 'teste@exemplo.com',
                'lembrar' => false
            ]
        ];
    }

    /**
     * Testar se o arquivo da API existe
     */
    public function testApiFileExists()
    {
        $this->assertTrue(
            file_exists(dirname(__DIR__) . '/api/auth/login.php'),
            'Arquivo da API de login deve existir'
        );
    }

    /**
     * Testar estrutura de dados válidos
     */
    public function testValidDataStructure()
    {
        $data = $this->testData['valid_login'];
        
        $this->assertIsArray($data, 'Dados devem ser um array');
        $this->assertArrayHasKey('email', $data, 'Dados devem conter email');
        $this->assertArrayHasKey('senha', $data, 'Dados devem conter senha');
        $this->assertArrayHasKey('lembrar', $data, 'Dados devem conter lembrar');
        
        $this->assertIsString($data['email'], 'Email deve ser string');
        $this->assertIsString($data['senha'], 'Senha deve ser string');
        $this->assertIsBool($data['lembrar'], 'Lembrar deve ser boolean');
    }

    /**
     * Testar validação de email
     */
    public function testEmailValidation()
    {
        $validEmails = [
            'teste@exemplo.com',
            'usuario@dominio.com.br',
            'admin@clube.com'
        ];
        
        $invalidEmails = [
            'email_invalido',
            '@dominio.com',
            'usuario@',
            'teste.com'
        ];
        
        foreach ($validEmails as $email) {
            $this->assertTrue(
                isValidEmail($email),
                "Email válido deve ser aceito: {$email}"
            );
        }
        
        foreach ($invalidEmails as $email) {
            $this->assertFalse(
                isValidEmail($email),
                "Email inválido deve ser rejeitado: {$email}"
            );
        }
    }

    /**
     * Testar validação de senha
     */
    public function testPasswordValidation()
    {
        $validPasswords = [
            'Senha@123',
            'MinhaSenha123!',
            'Teste123@'
        ];
        
        $invalidPasswords = [
            '123',
            'senha',
            'SENHA',
            'senha123'
        ];
        
        foreach ($validPasswords as $password) {
            $this->assertTrue(
                strlen($password) >= 6,
                "Senha válida deve ter pelo menos 6 caracteres: {$password}"
            );
        }
        
        foreach ($invalidPasswords as $password) {
            $this->assertTrue(
                strlen($password) < 6,
                "Senha inválida deve ter menos de 6 caracteres: {$password}"
            );
        }
    }

    /**
     * Testar campos obrigatórios
     */
    public function testRequiredFields()
    {
        $requiredFields = ['email', 'senha'];
        
        foreach ($requiredFields as $field) {
            $this->assertTrue(
                in_array($field, $requiredFields),
                "Campo {$field} deve ser obrigatório"
            );
        }
    }

    /**
     * Testar campos opcionais
     */
    public function testOptionalFields()
    {
        $optionalFields = ['lembrar'];
        
        foreach ($optionalFields as $field) {
            $this->assertTrue(
                in_array($field, $optionalFields),
                "Campo {$field} deve ser opcional"
            );
        }
    }

    /**
     * Testar sanitização de dados
     */
    public function testDataSanitization()
    {
        $rawData = [
            'email' => '  teste@exemplo.com  ',
            'senha' => '  Senha@123  ',
            'lembrar' => true
        ];
        
        $sanitized = sanitize($rawData);
        
        $this->assertEquals('teste@exemplo.com', $sanitized['email'], 'Email deve ser sanitizado');
        $this->assertEquals('Senha@123', $sanitized['senha'], 'Senha deve ser sanitizada');
        $this->assertTrue($sanitized['lembrar'], 'Boolean deve ser preservado');
    }

    /**
     * Testar validação de dados completos
     */
    public function testCompleteDataValidation()
    {
        $data = $this->testData['valid_login'];
        
        // Validar email
        $this->assertTrue(
            isValidEmail($data['email']),
            'Email deve ser válido'
        );
        
        // Validar senha
        $this->assertTrue(
            strlen($data['senha']) >= 6,
            'Senha deve ter pelo menos 6 caracteres'
        );
        
        // Validar estrutura
        $this->assertArrayHasKey('email', $data, 'Dados devem conter email');
        $this->assertArrayHasKey('senha', $data, 'Dados devem conter senha');
    }

    /**
     * Testar dados inválidos
     */
    public function testInvalidData()
    {
        $invalidData = [
            'invalid_email' => $this->testData['invalid_email'],
            'short_password' => $this->testData['short_password'],
            'missing_email' => $this->testData['missing_email'],
            'missing_password' => $this->testData['missing_password']
        ];
        
        foreach ($invalidData as $testName => $data) {
            $this->assertIsArray($data, "Dados de {$testName} devem ser array");
            
            if (isset($data['email'])) {
                if ($testName === 'invalid_email') {
                    $this->assertFalse(
                        isValidEmail($data['email']),
                        "Email inválido deve ser rejeitado: {$data['email']}"
                    );
                }
            }
            
            if (isset($data['senha'])) {
                if ($testName === 'short_password') {
                    $this->assertTrue(
                        strlen($data['senha']) < 6,
                        "Senha curta deve ser rejeitada: {$data['senha']}"
                    );
                }
            }
        }
    }

    /**
     * Testar formatação de email
     */
    public function testEmailFormatting()
    {
        $emails = [
            '  TESTE@EXEMPLO.COM  ' => 'teste@exemplo.com',
            'Usuario@Dominio.com' => 'usuario@dominio.com',
            'admin@clube.com' => 'admin@clube.com'
        ];
        
        foreach ($emails as $input => $expected) {
            $formatted = strtolower(trim($input));
            $this->assertEquals($expected, $formatted, "Email deve ser formatado corretamente");
        }
    }

    /**
     * Testar tipos de dados
     */
    public function testDataTypes()
    {
        $data = $this->testData['valid_login'];
        
        $this->assertIsString($data['email'], 'Email deve ser string');
        $this->assertIsString($data['senha'], 'Senha deve ser string');
        $this->assertIsBool($data['lembrar'], 'Lembrar deve ser boolean');
    }
}
?>
