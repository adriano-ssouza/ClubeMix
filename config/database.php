<?php
/**
 * =====================================================
 * CLUBEMIX - CONFIGURAÇÃO DE BANCO DE DADOS
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Configurações de conexão com banco de dados
 * =====================================================
 */

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'clubemix');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// Configurações de conexão PDO
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET . " COLLATE " . DB_COLLATE
]);

/**
 * Classe para conexão com banco de dados
 */
class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, DB_OPTIONS);
            
            // Definir timezone
            $this->connection->exec("SET time_zone = '+00:00'");
            
        } catch (PDOException $e) {
            error_log("Erro de conexão com banco de dados: " . $e->getMessage());
            throw new Exception("Erro ao conectar com o banco de dados");
        }
    }

    /**
     * Singleton - retorna única instância da conexão
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retorna a conexão PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Executa uma query e retorna o resultado
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro na query: " . $e->getMessage() . " | SQL: " . $sql);
            throw new Exception("Erro ao executar consulta");
        }
    }

    /**
     * Executa uma query e retorna todos os resultados
     */
    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params);
    }

    /**
     * Executa uma query e retorna um único resultado
     */
    public function fetch($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result ? $result[0] : null;
    }

    /**
     * Executa uma query e retorna o número de linhas afetadas
     */
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Erro na execução: " . $e->getMessage() . " | SQL: " . $sql);
            throw new Exception("Erro ao executar consulta");
        }
    }

    /**
     * Retorna o último ID inserido
     */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Inicia uma transação
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Confirma uma transação
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Desfaz uma transação
     */
    public function rollback()
    {
        return $this->connection->rollback();
    }

    /**
     * Verifica se está em uma transação
     */
    public function inTransaction()
    {
        return $this->connection->inTransaction();
    }

    /**
     * Escapa string para uso seguro em queries
     */
    public function quote($string)
    {
        return $this->connection->quote($string);
    }

    /**
     * Testa a conexão com o banco
     */
    public function testConnection()
    {
        try {
            $this->query("SELECT 1");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retorna informações sobre o banco
     */
    public function getDatabaseInfo()
    {
        try {
            $info = [];
            $info['version'] = $this->fetch("SELECT VERSION() as version")['version'];
            $info['database'] = DB_NAME;
            $info['host'] = DB_HOST;
            $info['charset'] = DB_CHARSET;
            return $info;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Previne clonagem da instância
     */
    private function __clone() {}

    /**
     * Previne deserialização da instância
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}

/**
 * Função helper para obter instância do banco
 */
function getDB()
{
    return Database::getInstance();
}

/**
 * Função helper para executar queries simples
 */
function dbQuery($sql, $params = [])
{
    return Database::getInstance()->query($sql, $params);
}

/**
 * Função helper para buscar todos os resultados
 */
function dbFetchAll($sql, $params = [])
{
    return Database::getInstance()->fetchAll($sql, $params);
}

/**
 * Função helper para buscar um resultado
 */
function dbFetch($sql, $params = [])
{
    return Database::getInstance()->fetch($sql, $params);
}

/**
 * Função helper para executar e retornar linhas afetadas
 */
function dbExecute($sql, $params = [])
{
    return Database::getInstance()->execute($sql, $params);
}

/**
 * Configurações de segurança do banco
 */
class DatabaseSecurity
{
    /**
     * Registra tentativa de login
     */
    public static function logLoginAttempt($ip, $email, $success = false, $userAgent = '')
    {
        $db = Database::getInstance();
        
        $sql = "INSERT INTO tentativas_login (endereco_ip, email, user_agent, sucesso, tentativa_em) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $db->execute($sql, [$ip, $email, $userAgent, $success]);
    }

    /**
     * Verifica se IP está bloqueado
     */
    public static function isIpBlocked($ip)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT COUNT(*) as count FROM bloqueios_ip 
                WHERE endereco_ip = ? 
                AND (bloqueado_ate IS NULL OR bloqueado_ate > NOW())";
        
        $result = $db->fetch($sql, [$ip]);
        return $result['count'] > 0;
    }

    /**
     * Bloqueia IP por tentativas excessivas
     */
    public static function blockIpForAttempts($ip, $minutes = 30)
    {
        $db = Database::getInstance();
        
        $sql = "INSERT INTO bloqueios_ip (endereco_ip, motivo, bloqueado_ate, contagem_tentativas, primeira_tentativa_em, ultima_tentativa_em) 
                VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE), 1, NOW(), NOW())
                ON DUPLICATE KEY UPDATE 
                contagem_tentativas = contagem_tentativas + 1,
                ultima_tentativa_em = NOW(),
                bloqueado_ate = DATE_ADD(NOW(), INTERVAL ? MINUTE)";
        
        $db->execute($sql, [$ip, 'Tentativas excessivas de login', $minutes, $minutes]);
    }

    /**
     * Conta tentativas de login falhadas recentes
     */
    public static function getRecentFailedAttempts($ip, $minutes = 30)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT COUNT(*) as count FROM tentativas_login 
                WHERE endereco_ip = ? 
                AND sucesso = FALSE 
                AND tentativa_em > DATE_SUB(NOW(), INTERVAL ? MINUTE)";
        
        $result = $db->fetch($sql, [$ip, $minutes]);
        return $result['count'];
    }
}

// Configurações de log de auditoria
class AuditLog
{
    /**
     * Registra ação no log de auditoria
     */
    public static function log($userId, $action, $table, $recordId = null, $oldData = null, $newData = null)
    {
        $db = Database::getInstance();
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        $sql = "INSERT INTO logs_auditoria 
                (usuario_id, acao, tabela, registro_id, dados_anteriores, dados_novos, endereco_ip, user_agent, criado_em) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $oldDataJson = $oldData ? json_encode($oldData) : null;
        $newDataJson = $newData ? json_encode($newData) : null;
        
        $db->execute($sql, [$userId, $action, $table, $recordId, $oldDataJson, $newDataJson, $ip, $userAgent]);
    }
}

// Verificar se as extensões necessárias estão instaladas
if (!extension_loaded('pdo')) {
    throw new Exception('Extensão PDO não está instalada');
}

if (!extension_loaded('pdo_mysql')) {
    throw new Exception('Extensão PDO MySQL não está instalada');
}

// Definir configurações de erro para desenvolvimento
if (defined('DEBUG') && DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>
