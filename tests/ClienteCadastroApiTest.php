<?php
/**
 * =====================================================
 * CLUBEMIX - TESTES DA API DE CADASTRO DE CLIENTE
 * =====================================================
 */

require_once __DIR__ . '/TestRunner.php';
require_once dirname(__DIR__) . '/config/config.php';

class ClienteCadastroApiTest extends TestCase
{
    private $validClientData;
    
    protected function setUp()
    {
        // Dados válidos para teste
        $this->validClientData = [
            'nome_completo' => 'João da Silva Teste',
            'cpf' => '11144477735',
            'email' => 'joao.teste@email.com',
            'whatsapp' => '11999999999',
            'data_nascimento' => '1990-01-01',
            'cep' => '01310100',
            'rua' => 'Avenida Paulista',
            'numero' => '1000',
            'complemento' => 'Apto 101',
            'bairro' => 'Bela Vista',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'codigo_indicacao' => '',
            'senha' => 'MinhaSenh@123'
        ];
    }
    
    protected function tearDown()
    {
        // Limpar variáveis globais
        unset($_POST);
        unset($_GET);
    }
    
    /**
     * Testar se o arquivo da classe existe
     */
    public function testClassFileExists()
    {
        $filePath = dirname(__DIR__) . '/api/cliente/cadastro.php';
        $this->assertTrue(file_exists($filePath), 'Arquivo da API de cliente deve existir');
    }
    
    /**
     * Testar estrutura de dados válidos
     */
    public function testValidDataStructure()
    {
        $this->assertIsArray($this->validClientData, 'Dados de teste devem ser um array');
        $this->assertNotEmpty($this->validClientData['nome_completo'], 'Nome deve estar presente');
        $this->assertNotEmpty($this->validClientData['cpf'], 'CPF deve estar presente');
        $this->assertNotEmpty($this->validClientData['email'], 'Email deve estar presente');
    }
    
    /**
     * Testar validação de CPF usando função global
     */
    public function testCPFValidation()
    {
        $testCases = [
            ['cpf' => '11144477735', 'should_be_valid' => true],
            ['cpf' => '111.444.777-35', 'should_be_valid' => true],
            ['cpf' => '12345678901', 'should_be_valid' => false],
            ['cpf' => '11111111111', 'should_be_valid' => false],
            ['cpf' => '', 'should_be_valid' => false],
        ];
        
        foreach ($testCases as $case) {
            $isValid = isValidCPF($case['cpf']);
            
            if ($case['should_be_valid']) {
                $this->assertTrue($isValid, "CPF {$case['cpf']} deve ser válido");
            } else {
                $this->assertFalse($isValid, "CPF {$case['cpf']} deve ser inválido");
            }
        }
    }
    
    /**
     * Testar validação de email usando função global
     */
    public function testEmailValidation()
    {
        $testCases = [
            ['email' => 'teste@exemplo.com', 'should_be_valid' => true],
            ['email' => 'user.name@domain.co.uk', 'should_be_valid' => true],
            ['email' => 'email_sem_arroba.com', 'should_be_valid' => false],
            ['email' => '@domain.com', 'should_be_valid' => false],
            ['email' => '', 'should_be_valid' => false],
        ];
        
        foreach ($testCases as $case) {
            $isValid = isValidEmail($case['email']);
            
            if ($case['should_be_valid']) {
                $this->assertTrue($isValid, "Email {$case['email']} deve ser válido");
            } else {
                $this->assertFalse($isValid, "Email {$case['email']} deve ser inválido");
            }
        }
    }
    
    /**
     * Testar formatação de CPF
     */
    public function testCPFFormatting()
    {
        $testCases = [
            '11144477735' => '111.444.777-35',
            '12345678901' => '123.456.789-01',
            '111.444.777-35' => '111.444.777-35', // Já formatado
        ];
        
        foreach ($testCases as $input => $expected) {
            $result = formatCPF($input);
            $this->assertEquals($expected, $result, "Formatação de CPF {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de telefone
     */
    public function testPhoneFormatting()
    {
        $testCases = [
            '11999999999' => '(11) 99999-9999',
            '1199999999' => '(11) 9999-9999',
            '123' => '123', // Muito curto, retorna como está
        ];
        
        foreach ($testCases as $input => $expected) {
            $result = formatPhone($input);
            $this->assertEquals($expected, $result, "Formatação de telefone {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar formatação de CEP
     */
    public function testCEPFormatting()
    {
        $testCases = [
            '01310100' => '01310-100',
            '12345678' => '12345-678',
            '01310-100' => '01310-100', // Já formatado
        ];
        
        foreach ($testCases as $input => $expected) {
            $result = formatCEP($input);
            $this->assertEquals($expected, $result, "Formatação de CEP {$input} deve resultar em {$expected}");
        }
    }
    
    /**
     * Testar campos obrigatórios
     */
    public function testRequiredFields()
    {
        $requiredFields = [
            'nome_completo', 'cpf', 'email', 'whatsapp', 'data_nascimento',
            'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'senha'
        ];
        
        foreach ($requiredFields as $field) {
            $this->assertTrue(
                isset($this->validClientData[$field]),
                "Campo {$field} deve estar presente nos dados de teste"
            );
            $this->assertNotEmpty(
                $this->validClientData[$field],
                "Campo {$field} não deve estar vazio nos dados de teste"
            );
        }
    }
    
    /**
     * Testar campos opcionais
     */
    public function testOptionalFields()
    {
        $optionalFields = ['complemento', 'codigo_indicacao'];
        
        foreach ($optionalFields as $field) {
            // Campo pode estar presente mas vazio
            $this->assertTrue(
                array_key_exists($field, $this->validClientData),
                "Campo opcional {$field} deve estar presente (pode estar vazio)"
            );
        }
    }
    
    /**
     * Testar sanitização de dados
     */
    public function testDataSanitization()
    {
        $dirtyData = [
            'nome_completo' => '  João Silva  ',
            'email' => '<script>test@email.com</script>',
        ];
        
        $cleanData = sanitize($dirtyData);
        
        $this->assertEquals('João Silva', $cleanData['nome_completo'], 'Deve remover espaços extras');
        $this->assertContains('test@email.com', $cleanData['email'], 'Deve manter email válido');
        $this->assertNotContains('<script>', $cleanData['email'], 'Deve escapar HTML perigoso');
    }
}
?>