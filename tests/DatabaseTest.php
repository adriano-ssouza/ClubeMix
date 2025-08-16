<?php
/**
 * =====================================================
 * CLUBEMIX - TESTES DA CLASSE DATABASE
 * =====================================================
 */

require_once __DIR__ . '/TestRunner.php';
require_once dirname(__DIR__) . '/config/database.php';

class DatabaseTest extends TestCase
{
    private $db;
    
    protected function setUp()
    {
        // Obter instância do banco para testes
        $this->db = Database::getInstance();
    }
    
    protected function tearDown()
    {
        // Limpar dados de teste se necessário
    }
    
    /**
     * Testar se a instância do banco é criada corretamente
     */
    public function testGetInstance()
    {
        $this->assertNotNull($this->db, 'Instância do banco não deve ser null');
        $this->assertTrue($this->db instanceof Database, 'Deve retornar instância da classe Database');
    }
    
    /**
     * Testar singleton - deve retornar a mesma instância
     */
    public function testSingleton()
    {
        $db1 = Database::getInstance();
        $db2 = Database::getInstance();
        
        $this->assertEquals($db1, $db2, 'Deve retornar a mesma instância (singleton)');
    }
    
    /**
     * Testar conexão com banco
     */
    public function testConnection()
    {
        $connection = $this->db->getConnection();
        $this->assertNotNull($connection, 'Conexão não deve ser null');
        $this->assertTrue($connection instanceof PDO, 'Conexão deve ser instância de PDO');
    }
    
    /**
     * Testar teste de conexão
     */
    public function testConnectionTest()
    {
        $result = $this->db->testConnection();
        $this->assertTrue($result, 'Teste de conexão deve retornar true');
    }
    
    /**
     * Testar query simples
     */
    public function testSimpleQuery()
    {
        $result = $this->db->query("SELECT 1 as test");
        $this->assertNotNull($result, 'Query deve retornar resultado');
    }
    
    /**
     * Testar fetch de dados
     */
    public function testFetch()
    {
        $result = $this->db->fetch("SELECT 1 as test_value");
        $this->assertIsArray($result, 'Fetch deve retornar array');
        $this->assertEquals(1, $result['test_value'], 'Valor deve ser 1');
    }
    
    /**
     * Testar fetchAll
     */
    public function testFetchAll()
    {
        $results = $this->db->fetchAll("SELECT 1 as test_value UNION SELECT 2 as test_value");
        $this->assertIsArray($results, 'FetchAll deve retornar array');
        $this->assertEquals(2, count($results), 'Deve retornar 2 resultados');
    }
    
    /**
     * Testar execute com prepared statements
     */
    public function testExecuteWithParameters()
    {
        // Testar com query que não modifica dados
        $result = $this->db->query("SELECT ? as test_param", [42]);
        $this->assertNotNull($result, 'Query com parâmetro deve funcionar');
    }
    
    /**
     * Testar informações do banco
     */
    public function testGetDatabaseInfo()
    {
        $info = $this->db->getDatabaseInfo();
        
        if ($info !== null) {
            $this->assertIsArray($info, 'Info do banco deve ser array');
            $this->assertNotEmpty($info['version'], 'Versão não deve estar vazia');
            $this->assertNotEmpty($info['database'], 'Nome do banco não deve estar vazio');
        }
    }
    
    /**
     * Testar transações
     */
    public function testTransactions()
    {
        // Iniciar transação
        $result = $this->db->beginTransaction();
        $this->assertTrue($result, 'Deve conseguir iniciar transação');
        
        // Verificar se está em transação
        $inTransaction = $this->db->inTransaction();
        $this->assertTrue($inTransaction, 'Deve estar em transação');
        
        // Rollback para não afetar dados
        $rollback = $this->db->rollback();
        $this->assertTrue($rollback, 'Deve conseguir fazer rollback');
        
        // Verificar se não está mais em transação
        $notInTransaction = !$this->db->inTransaction();
        $this->assertTrue($notInTransaction, 'Não deve mais estar em transação');
    }
    
    /**
     * Testar quote de strings
     */
    public function testQuoteString()
    {
        $quoted = $this->db->quote("test'string");
        $this->assertContains("test'string", $quoted, 'String deve estar contida no resultado quotado');
    }
    
    /**
     * Testar tratamento de erro com query inválida
     */
    public function testInvalidQuery()
    {
        $this->assertThrows(Exception::class, function() {
            $this->db->query("INVALID SQL SYNTAX HERE");
        }, 'Query inválida deve lançar exceção');
    }
    
    /**
     * Testar se tabelas principais existem
     */
    public function testMainTablesExist()
    {
        $tables = ['usuarios', 'clientes', 'empresas', 'niveis_afiliacao'];
        
        foreach ($tables as $table) {
            $result = $this->db->fetch("SHOW TABLES LIKE ?", [$table]);
            $this->assertNotNull($result, "Tabela {$table} deve existir");
        }
    }
    
    /**
     * Testar estrutura da tabela usuarios
     */
    public function testUsuariosTableStructure()
    {
        $columns = $this->db->fetchAll("DESCRIBE usuarios");
        $this->assertNotEmpty($columns, 'Tabela usuarios deve ter colunas');
        
        $columnNames = array_column($columns, 'Field');
        $requiredColumns = ['id', 'uuid', 'tipo_usuario', 'email', 'senha'];
        
        foreach ($requiredColumns as $column) {
            $this->assertTrue(in_array($column, $columnNames), "Coluna {$column} deve existir na tabela usuarios");
        }
    }
    
    /**
     * Testar estrutura da tabela clientes
     */
    public function testClientesTableStructure()
    {
        $columns = $this->db->fetchAll("DESCRIBE clientes");
        $this->assertNotEmpty($columns, 'Tabela clientes deve ter colunas');
        
        $columnNames = array_column($columns, 'Field');
        $requiredColumns = ['id', 'usuario_id', 'nome_completo', 'cpf', 'email'];
        
        foreach ($requiredColumns as $column) {
            $this->assertTrue(in_array($column, $columnNames), "Coluna {$column} deve existir na tabela clientes");
        }
    }
}
?>
