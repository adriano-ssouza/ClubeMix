<?php
/**
 * =====================================================
 * CLUBEMIX - API DE AUTENTICAÇÃO
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: API para autenticação de usuários (login)
 * =====================================================
 */

require_once dirname(__DIR__) . '/base/ApiBase.php';

class AuthLoginApi extends ApiBase
{
    /**
     * Processar requisição
     */
    public function processRequest()
    {
        logApi('AuthLoginApi', 'processRequest', 'Processando requisição de login', [
            'method' => $this->method
        ]);
        
        switch ($this->method) {
            case 'POST':
                $this->fazerLogin();
                break;
            default:
                logError('AuthLoginApi', 'processRequest', 'Método não permitido', [
                    'method' => $this->method,
                    'allowed' => $this->getAllowedMethods()
                ]);
                $this->sendError('Método não permitido', 405);
        }
    }

    /**
     * Fazer login do usuário
     */
    private function fazerLogin()
    {
        logInfo('AuthLoginApi', 'fazerLogin', 'Iniciando processo de login');
        
        try {
            // Verificar proteção contra força bruta
            logSecurity('AuthLoginApi', 'fazerLogin', 'Verificando proteção contra força bruta', [
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);
            $this->checkBruteForce($_SERVER['REMOTE_ADDR']);
            
            // Sanitizar dados de entrada
            logValidation('AuthLoginApi', 'fazerLogin', 'Sanitizando dados de entrada', [
                'raw_data_keys' => array_keys($this->request)
            ]);
            $data = $this->sanitizeInput($this->request);
            
            // Validar dados obrigatórios
            logValidation('AuthLoginApi', 'fazerLogin', 'Iniciando validação de dados');
            $errors = $this->validateLoginData($data);
            
            if (!empty($errors)) {
                $this->sendError('Dados inválidos', 400, $errors);
            }
            
            // Buscar usuário pelo email
            $usuario = $this->buscarUsuarioPorEmail($data['email']);
            
            if (!$usuario) {
                logSecurity('AuthLoginApi', 'fazerLogin', 'Tentativa de login com email inexistente', [
                    'email' => $data['email'],
                    'ip' => $_SERVER['REMOTE_ADDR']
                ]);
                $this->sendError('Email ou senha incorretos', 401, [
                    'email' => 'Email ou senha incorretos'
                ]);
            }
            
            // Verificar senha
            if (!password_verify($data['senha'], $usuario['senha'])) {
                logSecurity('AuthLoginApi', 'fazerLogin', 'Tentativa de login com senha incorreta', [
                    'email' => $data['email'],
                    'ip' => $_SERVER['REMOTE_ADDR']
                ]);
                $this->sendError('Email ou senha incorretos', 401, [
                    'email' => 'Email ou senha incorretos'
                ]);
            }
            
            // Verificar se usuário está ativo (permitir login para usuários pendentes também)
            if ($usuario['status'] === 'inativo' || $usuario['status'] === 'suspenso') {
                logSecurity('AuthLoginApi', 'fazerLogin', 'Tentativa de login com usuário inativo/suspenso', [
                    'email' => $data['email'],
                    'status' => $usuario['status'],
                    'ip' => $_SERVER['REMOTE_ADDR']
                ]);
                $this->sendError('Conta não está ativa. Entre em contato com o suporte.', 403, [
                    'email' => 'Conta não está ativa'
                ]);
            }
            
            // Buscar dados completos do usuário
            $dadosCompletos = $this->buscarDadosCompletos($usuario['id']);
            
            // Gerar token de sessão
            $token = $this->gerarTokenSessao($usuario['id'], $data['lembrar'] ?? false);
            
            // Registrar login bem-sucedido
            $this->registrarLogin($usuario['id'], $_SERVER['REMOTE_ADDR'], true);
            
            // Criar sessão PHP para o usuário
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Limpar sessão anterior
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_uuid'] = $usuario['uuid'];
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['user_type'] = $usuario['tipo_usuario'];
            $_SESSION['user_status'] = $usuario['status'];
            $_SESSION['login_time'] = time();
            
            // Forçar escrita da sessão
            session_write_close();
            session_start();
            
            // Preparar resposta
            $response = [
                'token' => $token,
                'usuario' => [
                    'id' => $usuario['id'],
                    'uuid' => $usuario['uuid'],
                    'email' => $usuario['email'],
                    'tipo_usuario' => $usuario['tipo_usuario'],
                    'status' => $usuario['status'],
                    'ultimo_login' => $usuario['ultimo_login_sucesso'] ?? date('Y-m-d H:i:s')
                ],
                'dados_completos' => $dadosCompletos,
                'redirect_url' => '/dashboard.php'
            ];
            
            logSuccess('AuthLoginApi', 'fazerLogin', 'Login realizado com sucesso', [
                'usuario_id' => $usuario['id'],
                'tipo_usuario' => $usuario['tipo_usuario']
            ]);
            
            $this->sendSuccess($response, 'Login realizado com sucesso!');
            
        } catch (Exception $e) {
            logSystem('Erro ao fazer login: ' . $e->getMessage(), 'ERROR', [
                'data' => $data ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->sendError('Erro interno do servidor. Tente novamente em alguns minutos.', 500);
        }
    }

    /**
     * Validar dados do login
     */
    private function validateLoginData($data)
    {
        $errors = [];
        
        // Campos obrigatórios
        $required = ['email', 'senha'];
        
        $requiredErrors = $this->validateRequired($required, $data);
        $errors = array_merge($errors, $requiredErrors);
        
        // Validações específicas
        if (isset($data['email']) && !empty($data['email'])) {
            if (!$this->validateEmail($data['email'])) {
                $errors['email'] = 'Email inválido';
            }
        }
        
        if (isset($data['senha']) && !empty($data['senha'])) {
            if (strlen($data['senha']) < 6) {
                $errors['senha'] = 'Senha deve ter pelo menos 6 caracteres';
            }
        }
        
        return $errors;
    }

    /**
     * Buscar usuário por email
     */
    private function buscarUsuarioPorEmail($email)
    {
        logDebug('AuthLoginApi', 'buscarUsuarioPorEmail', 'Buscando usuário por email', ['email' => $email]);
        
        $sql = "SELECT id, uuid, email, senha, tipo_usuario, status, ultimo_login_sucesso 
                FROM usuarios 
                WHERE email = ? AND deletado_em IS NULL";
        
        try {
            $result = $this->db->query($sql, [$email]);
            
            logDebug('AuthLoginApi', 'buscarUsuarioPorEmail', 'Resultado da busca', [
                'email' => $email,
                'result_count' => $result ? count($result) : 0,
                'result' => $result ? array_keys($result[0]) : null
            ]);
            
            if ($result && count($result) > 0) {
                return $result[0];
            }
            
            return null;
        } catch (Exception $e) {
            logError('AuthLoginApi', 'buscarUsuarioPorEmail', 'Erro ao buscar usuário', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Buscar dados completos do usuário
     */
    private function buscarDadosCompletos($usuarioId)
    {
        // Buscar dados de cliente se existir
        $sqlCliente = "SELECT c.*, u.email, u.tipo_usuario, u.status 
                       FROM clientes c 
                       INNER JOIN usuarios u ON c.usuario_id = u.id 
                       WHERE u.id = ? AND u.deletado_em IS NULL";
        
        $cliente = $this->db->query($sqlCliente, [$usuarioId]);
        
        if ($cliente && count($cliente) > 0) {
            return [
                'tipo' => 'cliente',
                'dados' => $cliente[0]
            ];
        }
        
        // Buscar dados de empresa se existir
        $sqlEmpresa = "SELECT e.*, u.email, u.tipo_usuario, u.status 
                       FROM empresas e 
                       INNER JOIN usuarios u ON e.usuario_id = u.id 
                       WHERE u.id = ? AND u.deletado_em IS NULL";
        
        $empresa = $this->db->query($sqlEmpresa, [$usuarioId]);
        
        if ($empresa && count($empresa) > 0) {
            return [
                'tipo' => 'empresa',
                'dados' => $empresa[0]
            ];
        }
        
        return [
            'tipo' => 'usuario',
            'dados' => null
        ];
    }

    /**
     * Gerar token de sessão
     */
    private function gerarTokenSessao($usuarioId, $lembrar = false)
    {
        logDebug('AuthLoginApi', 'gerarTokenSessao', 'Gerando token de sessão', [
            'usuario_id' => $usuarioId,
            'lembrar' => $lembrar
        ]);
        
        $token = bin2hex(random_bytes(32));
        $expiraEm = $lembrar ? date('Y-m-d H:i:s', strtotime('+30 days')) : date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $sql = "INSERT INTO sessoes (
                    id, usuario_id, endereco_ip, user_agent, dados, ultima_atividade
                ) VALUES (?, ?, ?, ?, ?, ?)";
        
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        
        try {
            $this->db->execute($sql, [
                $token,
                $usuarioId,
                $_SERVER['REMOTE_ADDR'],
                $userAgent,
                json_encode(['expira_em' => $expiraEm, 'lembrar' => $lembrar]),
                time()
            ]);
            
            logDebug('AuthLoginApi', 'gerarTokenSessao', 'Token gerado com sucesso', [
                'usuario_id' => $usuarioId,
                'token_length' => strlen($token)
            ]);
            
            return $token;
        } catch (Exception $e) {
            logError('AuthLoginApi', 'gerarTokenSessao', 'Erro ao gerar token', [
                'usuario_id' => $usuarioId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Registrar tentativa de login
     */
    private function registrarLogin($usuarioId, $ip, $sucesso = true)
    {
        logDebug('AuthLoginApi', 'registrarLogin', 'Registrando tentativa de login', [
            'usuario_id' => $usuarioId,
            'ip' => $ip,
            'sucesso' => $sucesso
        ]);
        
        $sql = "INSERT INTO tentativas_login (
                    endereco_ip, email, user_agent, sucesso, tentativa_em
                ) VALUES (?, ?, ?, ?, NOW())";
        
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        
        try {
            // Buscar email do usuário para registrar na tentativa
            $emailUsuario = $this->db->fetch("SELECT email FROM usuarios WHERE id = ?", [$usuarioId]);
            $email = $emailUsuario ? $emailUsuario['email'] : 'desconhecido';
            
            $this->db->execute($sql, [
                $ip,
                $email,
                $userAgent,
                $sucesso ? 1 : 0
            ]);
            
            // Atualizar último login se bem-sucedido
            if ($sucesso) {
                $sqlUpdate = "UPDATE usuarios SET ultimo_login_sucesso = NOW() WHERE id = ?";
                $this->db->execute($sqlUpdate, [$usuarioId]);
            }
            
            logDebug('AuthLoginApi', 'registrarLogin', 'Tentativa de login registrada com sucesso', [
                'usuario_id' => $usuarioId,
                'sucesso' => $sucesso
            ]);
        } catch (Exception $e) {
            logError('AuthLoginApi', 'registrarLogin', 'Erro ao registrar tentativa de login', [
                'usuario_id' => $usuarioId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Métodos HTTP permitidos
     */
    protected function getAllowedMethods()
    {
        return ['POST'];
    }
}

// Executar a API
if (!defined('CLUBEMIX_SYSTEM')) {
    define('CLUBEMIX_SYSTEM', true);
}

$api = new AuthLoginApi();
$api->execute();
?>
