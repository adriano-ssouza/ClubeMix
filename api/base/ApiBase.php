<?php
/**
 * =====================================================
 * CLUBEMIX - CLASSE BASE PARA APIs
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: Classe base para todas as APIs do sistema
 * =====================================================
 */

// Definir constante do sistema
if (!defined('CLUBEMIX_SYSTEM')) {
    define('CLUBEMIX_SYSTEM', true);
}

// Incluir configurações
require_once dirname(__DIR__, 2) . '/config/config.php';

// Incluir sistema de logging
require_once __DIR__ . '/Logger.php';

/**
 * Classe base para APIs
 */
abstract class ApiBase
{
    protected $db;
    protected $request;
    protected $method;
    protected $headers;

    public function __construct()
    {
        logDebug(get_class($this), '__construct', 'Iniciando construção da API');
        
        // Obter dados da requisição primeiro
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->headers = function_exists('getallheaders') ? getallheaders() : [];
        logDebug(get_class($this), '__construct', 'Dados da requisição obtidos', [
            'method' => $this->method,
            'headers' => array_keys($this->headers ?: [])
        ]);
        
        // Processar dados da requisição
        $this->processRequestData();
        logDebug(get_class($this), '__construct', 'Dados da requisição processados', [
            'request_size' => count($this->request)
        ]);
        
        // Verificar se método é permitido
        if (!in_array($this->method, $this->getAllowedMethods())) {
            logError(get_class($this), '__construct', 'Método não permitido', [
                'method' => $this->method,
                'allowed' => $this->getAllowedMethods()
            ]);
            $this->sendError('Método não permitido', 405);
        }
        
        // Obter instância do banco
        $this->db = Database::getInstance();
        logDebug(get_class($this), '__construct', 'Conexão com banco obtida');
        
        logSuccess(get_class($this), '__construct', 'API inicializada com sucesso');
    }

    /**
     * Configurar headers CORS
     */
    private function setCorsHeaders()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        // Responder a requisições OPTIONS
        if (($this->method ?? $_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    /**
     * Processar dados da requisição
     */
    private function processRequestData()
    {
        switch ($this->method) {
            case 'GET':
                $this->request = $_GET;
                break;
            case 'POST':
            case 'PUT':
                $input = file_get_contents('php://input');
                
                // Tentar decodificar JSON
                $json = json_decode($input, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $this->request = $json;
                } else {
                    // Usar POST data se não for JSON válido
                    $this->request = $_POST;
                }
                break;
            case 'DELETE':
                $this->request = $_GET;
                break;
            default:
                $this->request = [];
        }
    }

    /**
     * Métodos HTTP permitidos (deve ser sobrescrito nas classes filhas)
     */
    protected function getAllowedMethods()
    {
        return ['POST'];
    }

    /**
     * Processar requisição (deve ser implementado nas classes filhas)
     */
    abstract public function processRequest();
    
    /**
     * Configurar headers CORS e processar requisição
     */
    public function execute()
    {
        // Configurar headers CORS antes de qualquer saída
        $this->setCorsHeaders();
        
        // Processar requisição
        $this->processRequest();
    }

    /**
     * Enviar resposta de sucesso
     */
    protected function sendSuccess($data = null, $message = 'Operação realizada com sucesso', $code = 200)
    {
        logSuccess(get_class($this), 'sendSuccess', $message, [
            'code' => $code,
            'has_data' => $data !== null,
            'data_type' => gettype($data)
        ]);
        
        http_response_code($code);
        
        $response = [
            'success' => true,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'data' => $data
        ];
        
        logApi(get_class($this), 'sendSuccess', 'Enviando resposta de sucesso', $response);
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * Enviar resposta de erro
     */
    protected function sendError($message = 'Erro interno do servidor', $code = 500, $errors = null)
    {
        logError(get_class($this), 'sendError', $message, [
            'code' => $code,
            'errors' => $errors,
            'method' => $this->method,
            'request_data' => $this->request
        ]);
        
        http_response_code($code);
        
        $response = [
            'success' => false,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'errors' => $errors
        ];
        
        // Log do erro (sistema antigo)
        logSystem("API Error: $message", 'ERROR', [
            'code' => $code,
            'errors' => $errors,
            'method' => $this->method,
            'request' => $this->request
        ]);
        
        logApi(get_class($this), 'sendError', 'Enviando resposta de erro', $response);
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * Validar campos obrigatórios
     */
    protected function validateRequired($fields, $data)
    {
        logValidation(get_class($this), 'validateRequired', 'Validando campos obrigatórios', [
            'fields' => $fields,
            'data_keys' => array_keys($data)
        ]);
        
        $errors = [];
        
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[$field] = "Campo {$field} é obrigatório";
                logValidation(get_class($this), 'validateRequired', "Campo obrigatório ausente: {$field}");
            }
        }
        
        if (!empty($errors)) {
            logError(get_class($this), 'validateRequired', 'Validação falhou', $errors);
        } else {
            logSuccess(get_class($this), 'validateRequired', 'Todos os campos obrigatórios estão presentes');
        }
        
        return $errors;
    }

    /**
     * Validar email
     */
    protected function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validar CPF
     */
    protected function validateCPF($cpf)
    {
        return isValidCPF($cpf);
    }

    /**
     * Validar CNPJ
     */
    protected function validateCNPJ($cnpj)
    {
        return isValidCNPJ($cnpj);
    }

    /**
     * Sanitizar dados de entrada
     */
    protected function sanitizeInput($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Verificar se email já existe
     */
    protected function emailExists($email)
    {
        logValidation(get_class($this), 'emailExists', 'Verificando se email já existe', ['email' => $email]);
        
        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE email = ? AND deletado_em IS NULL";
        $result = $this->db->fetch($sql, [$email]);
        $exists = $result['count'] > 0;
        
        logValidation(get_class($this), 'emailExists', $exists ? 'Email já existe' : 'Email disponível', [
            'email' => $email,
            'exists' => $exists
        ]);
        
        return $exists;
    }

    /**
     * Verificar se CPF já existe
     */
    protected function cpfExists($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $sql = "SELECT COUNT(*) as count FROM clientes WHERE cpf = ?";
        $result = $this->db->fetch($sql, [$cpf]);
        return $result['count'] > 0;
    }

    /**
     * Verificar se CNPJ já existe
     */
    protected function cnpjExists($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        $sql = "SELECT COUNT(*) as count FROM empresas WHERE cnpj = ?";
        $result = $this->db->fetch($sql, [$cnpj]);
        return $result['count'] > 0;
    }

    /**
     * Gerar UUID
     */
    protected function generateUUID()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Gerar código de indicação único
     */
    protected function generateIndicationCode()
    {
        do {
            $code = 'CM' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $sql = "SELECT COUNT(*) as count FROM clientes WHERE codigo_indicacao = ?";
            $result = $this->db->fetch($sql, [$code]);
        } while ($result['count'] > 0);
        
        return $code;
    }

    /**
     * Validar código de indicação
     */
    protected function validateIndicationCode($code)
    {
        if (empty($code)) {
            return null;
        }
        
        $sql = "SELECT id FROM clientes WHERE codigo_indicacao = ?";
        $result = $this->db->fetch($sql, [$code]);
        
        return $result ? $code : null;
    }

    /**
     * Hash da senha
     */
    protected function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Registrar log de auditoria
     */
    protected function logAudit($userId, $action, $table, $recordId = null, $oldData = null, $newData = null)
    {
        AuditLog::log($userId, $action, $table, $recordId, $oldData, $newData);
    }

    /**
     * Verificar proteção contra força bruta
     */
    protected function checkBruteForce($ip)
    {
        // Verificar se IP está bloqueado
        if (DatabaseSecurity::isIpBlocked($ip)) {
            $this->sendError('IP bloqueado temporariamente devido a tentativas excessivas', 429);
        }
        
        // Verificar tentativas recentes
        $attempts = DatabaseSecurity::getRecentFailedAttempts($ip);
        if ($attempts >= MAX_LOGIN_ATTEMPTS) {
            DatabaseSecurity::blockIpForAttempts($ip, LOGIN_BLOCK_TIME);
            $this->sendError('Muitas tentativas. IP bloqueado temporariamente', 429);
        }
    }

    /**
     * Buscar endereço por CEP via ViaCEP
     */
    protected function getAddressByCEP($cep)
    {
        $cep = preg_replace('/[^0-9]/', '', $cep);
        
        if (strlen($cep) !== 8) {
            return null;
        }
        
        $url = VIACEP_URL . $cep . '/json/';
        
        $context = stream_context_create([
            'http' => [
                'timeout' => VIACEP_TIMEOUT
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        $data = json_decode($response, true);
        
        if (isset($data['erro'])) {
            return null;
        }
        
        return $data;
    }

    /**
     * Validar data de nascimento
     */
    protected function validateBirthDate($date)
    {
        $birthDate = DateTime::createFromFormat('Y-m-d', $date);
        
        if (!$birthDate) {
            return false;
        }
        
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        
        // Verificar se tem pelo menos 18 anos
        return $age >= 18 && $age <= 120;
    }

    /**
     * Formatar telefone
     */
    protected function formatPhone($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * Validar força da senha
     */
    protected function validatePasswordStrength($password)
    {
        $errors = [];
        
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            $errors[] = "Senha deve ter pelo menos " . PASSWORD_MIN_LENGTH . " caracteres";
        }
        
        if (PASSWORD_REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
            $errors[] = "Senha deve conter pelo menos uma letra maiúscula";
        }
        
        if (PASSWORD_REQUIRE_LOWERCASE && !preg_match('/[a-z]/', $password)) {
            $errors[] = "Senha deve conter pelo menos uma letra minúscula";
        }
        
        if (PASSWORD_REQUIRE_NUMBERS && !preg_match('/[0-9]/', $password)) {
            $errors[] = "Senha deve conter pelo menos um número";
        }
        
        if (PASSWORD_REQUIRE_SYMBOLS && !preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Senha deve conter pelo menos um caractere especial";
        }
        
        return $errors;
    }
}
?>
