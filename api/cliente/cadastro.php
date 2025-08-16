<?php
/**
 * =====================================================
 * CLUBEMIX - API CADASTRO DE CLIENTE
 * =====================================================
 * Versão: 1.0
 * Data: 2025
 * Descrição: API para cadastro de novos clientes
 * =====================================================
 */

require_once dirname(__DIR__) . '/base/ApiBase.php';

class ClienteCadastroApi extends ApiBase
{
    /**
     * Processar requisição
     */
    public function processRequest()
    {
        logApi('ClienteCadastroApi', 'processRequest', 'Processando requisição', [
            'method' => $this->method
        ]);
        
        switch ($this->method) {
            case 'POST':
                $this->cadastrarCliente();
                break;
            default:
                logError('ClienteCadastroApi', 'processRequest', 'Método não permitido', [
                    'method' => $this->method,
                    'allowed' => $this->getAllowedMethods()
                ]);
                $this->sendError('Método não permitido', 405);
        }
    }

    /**
     * Cadastrar novo cliente
     */
    private function cadastrarCliente()
    {
        logInfo('ClienteCadastroApi', 'cadastrarCliente', 'Iniciando cadastro de cliente');
        
        try {
            // Verificar proteção contra força bruta
            logSecurity('ClienteCadastroApi', 'cadastrarCliente', 'Verificando proteção contra força bruta', [
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);
            $this->checkBruteForce($_SERVER['REMOTE_ADDR']);
            
            // Sanitizar dados de entrada
            logValidation('ClienteCadastroApi', 'cadastrarCliente', 'Sanitizando dados de entrada', [
                'raw_data_keys' => array_keys($this->request)
            ]);
            $data = $this->sanitizeInput($this->request);
            
            // Validar dados obrigatórios
            logValidation('ClienteCadastroApi', 'cadastrarCliente', 'Iniciando validação de dados');
            $errors = $this->validateClientData($data);
            
            if (!empty($errors)) {
                $this->sendError('Dados inválidos', 400, $errors);
            }
            
            // Verificar se email já existe
            if ($this->emailExists($data['email'])) {
                $this->sendError('Email já cadastrado no sistema', 400, [
                    'email' => 'Este email já está em uso'
                ]);
            }
            
            // Verificar se CPF já existe
            if ($this->cpfExists($data['cpf'])) {
                $this->sendError('CPF já cadastrado no sistema', 400, [
                    'cpf' => 'Este CPF já está em uso'
                ]);
            }
            
            // Validar código de indicação se fornecido
            $codigoIndicador = null;
            if (!empty($data['codigo_indicacao'])) {
                $codigoIndicador = $this->validateIndicationCode($data['codigo_indicacao']);
                if ($codigoIndicador === null) {
                    $this->sendError('Código de indicação inválido', 400, [
                        'codigo_indicacao' => 'Código de indicação não encontrado'
                    ]);
                }
            }
            
            // Iniciar transação
            $this->db->beginTransaction();
            
            try {
                // Criar usuário
                $usuarioId = $this->criarUsuario($data);
                
                // Criar cliente
                $clienteId = $this->criarCliente($data, $usuarioId, $codigoIndicador);
                
                // Criar rede de afiliação se houver indicador
                if ($codigoIndicador) {
                    $this->criarRedeAfiliacao($clienteId, $codigoIndicador);
                }
                
                // Confirmar transação
                $this->db->commit();
                
                // Log de auditoria
                $this->logAudit($usuarioId, 'INSERT', 'clientes', $clienteId, null, [
                    'nome' => $data['nome_completo'],
                    'email' => $data['email'],
                    'cpf' => $data['cpf']
                ]);
                
                // Buscar dados do cliente criado
                $cliente = $this->buscarClienteCriado($clienteId);
                
                $this->sendSuccess($cliente, 'Cliente cadastrado com sucesso! Bem-vindo ao ClubeMix!', 201);
                
            } catch (Exception $e) {
                $this->db->rollback();
                throw $e;
            }
            
        } catch (Exception $e) {
            logSystem('Erro ao cadastrar cliente: ' . $e->getMessage(), 'ERROR', [
                'data' => $data ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->sendError('Erro interno do servidor. Tente novamente em alguns minutos.', 500);
        }
    }

    /**
     * Validar dados do cliente
     */
    private function validateClientData($data)
    {
        $errors = [];
        
        // Campos obrigatórios
        $required = [
            'nome_completo', 'cpf', 'email', 'whatsapp', 'data_nascimento',
            'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'senha'
        ];
        
        $requiredErrors = $this->validateRequired($required, $data);
        $errors = array_merge($errors, $requiredErrors);
        
        // Validações específicas
        if (isset($data['email']) && !empty($data['email'])) {
            if (!$this->validateEmail($data['email'])) {
                $errors['email'] = 'Email inválido';
            }
        }
        
        if (isset($data['cpf']) && !empty($data['cpf'])) {
            if (!$this->validateCPF($data['cpf'])) {
                $errors['cpf'] = 'CPF inválido';
            }
        }
        
        if (isset($data['data_nascimento']) && !empty($data['data_nascimento'])) {
            if (!$this->validateBirthDate($data['data_nascimento'])) {
                $errors['data_nascimento'] = 'Data de nascimento inválida ou idade menor que 18 anos';
            }
        }
        
        if (isset($data['cep']) && !empty($data['cep'])) {
            $cep = preg_replace('/[^0-9]/', '', $data['cep']);
            if (strlen($cep) !== 8) {
                $errors['cep'] = 'CEP deve conter 8 dígitos';
            }
        }
        
        if (isset($data['senha']) && !empty($data['senha'])) {
            $passwordErrors = $this->validatePasswordStrength($data['senha']);
            if (!empty($passwordErrors)) {
                $errors['senha'] = implode(', ', $passwordErrors);
            }
        }
        
        if (isset($data['whatsapp']) && !empty($data['whatsapp'])) {
            $phone = preg_replace('/[^0-9]/', '', $data['whatsapp']);
            if (strlen($phone) < 10 || strlen($phone) > 11) {
                $errors['whatsapp'] = 'WhatsApp deve conter entre 10 e 11 dígitos';
            }
        }
        
        if (isset($data['estado']) && !empty($data['estado'])) {
            if (strlen($data['estado']) !== 2) {
                $errors['estado'] = 'Estado deve conter 2 caracteres';
            }
        }
        
        return $errors;
    }

    /**
     * Criar usuário
     */
    private function criarUsuario($data)
    {
        $sql = "INSERT INTO usuarios (
                    uuid, tipo_usuario, status, email, senha, criado_em
                ) VALUES (?, 'cliente', 'pendente', ?, ?, NOW())";
        
        $uuid = $this->generateUUID();
        $senhaHash = $this->hashPassword($data['senha']);
        
        $this->db->execute($sql, [$uuid, $data['email'], $senhaHash]);
        
        return $this->db->lastInsertId();
    }

    /**
     * Criar cliente
     */
    private function criarCliente($data, $usuarioId, $codigoIndicador)
    {
        $sql = "INSERT INTO clientes (
                    usuario_id, nome_completo, cpf, data_nascimento, whatsapp,
                    cep, rua, numero, complemento, bairro, cidade, estado,
                    codigo_indicacao, codigo_indicador, nivel_afiliacao, criado_em
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $codigoIndicacao = $this->generateIndicationCode();
        $cpfLimpo = preg_replace('/[^0-9]/', '', $data['cpf']);
        $whatsappLimpo = $this->formatPhone($data['whatsapp']);
        $cepLimpo = preg_replace('/[^0-9]/', '', $data['cep']);
        $complemento = isset($data['complemento']) ? $data['complemento'] : null;
        $nivelAfiliacao = $codigoIndicador ? 1 : 0;
        
        $params = [
            $usuarioId,
            $data['nome_completo'],
            $cpfLimpo,
            $data['data_nascimento'],
            $whatsappLimpo,
            $cepLimpo,
            $data['rua'],
            $data['numero'],
            $complemento,
            $data['bairro'],
            $data['cidade'],
            strtoupper($data['estado']),
            $codigoIndicacao,
            $codigoIndicador,
            $nivelAfiliacao
        ];
        
        $this->db->execute($sql, $params);
        
        return $this->db->lastInsertId();
    }

    /**
     * Criar rede de afiliação
     */
    private function criarRedeAfiliacao($clienteId, $codigoIndicador)
    {
        // Buscar cliente indicador
        $sqlIndicador = "SELECT id FROM clientes WHERE codigo_indicacao = ?";
        $indicador = $this->db->fetch($sqlIndicador, [$codigoIndicador]);
        
        if (!$indicador) {
            return;
        }
        
        $indicadorId = $indicador['id'];
        
        // Buscar níveis de afiliação ativos
        $sqlNiveis = "SELECT nivel, percentual_comissao FROM niveis_afiliacao 
                      WHERE ativo = 1 ORDER BY nivel";
        $niveis = $this->db->fetchAll($sqlNiveis);
        
        // Criar afiliações para todos os níveis da rede
        $clienteAtual = $indicadorId;
        
        foreach ($niveis as $nivel) {
            if ($clienteAtual === null) {
                break;
            }
            
            // Inserir afiliação
            $sqlAfiliacao = "INSERT INTO afiliacoes (
                                cliente_id, indicador_id, nivel_afiliacao, 
                                percentual_comissao, status, data_ativacao
                            ) VALUES (?, ?, ?, ?, 'ativa', NOW())";
            
            $this->db->execute($sqlAfiliacao, [
                $clienteId,
                $clienteAtual,
                $nivel['nivel'],
                $nivel['percentual_comissao']
            ]);
            
            // Buscar próximo nível na rede
            $sqlProximo = "SELECT codigo_indicador FROM clientes WHERE id = ?";
            $proximo = $this->db->fetch($sqlProximo, [$clienteAtual]);
            
            if ($proximo && $proximo['codigo_indicador']) {
                $sqlProximoId = "SELECT id FROM clientes WHERE codigo_indicacao = ?";
                $proximoCliente = $this->db->fetch($sqlProximoId, [$proximo['codigo_indicador']]);
                $clienteAtual = $proximoCliente ? $proximoCliente['id'] : null;
            } else {
                $clienteAtual = null;
            }
        }
    }

    /**
     * Buscar dados do cliente criado
     */
    private function buscarClienteCriado($clienteId)
    {
        $sql = "SELECT 
                    c.id,
                    c.nome_completo,
                    c.cpf,
                    c.whatsapp,
                    c.codigo_indicacao,
                    c.nivel_afiliacao,
                    u.email,
                    u.status,
                    u.uuid
                FROM clientes c
                INNER JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.id = ?";
        
        $cliente = $this->db->fetch($sql, [$clienteId]);
        
        if ($cliente) {
            // Formatar dados para resposta
            $cliente['cpf'] = formatCPF($cliente['cpf']);
            $cliente['whatsapp'] = formatPhone($cliente['whatsapp']);
        }
        
        return $cliente;
    }

    /**
     * Métodos HTTP permitidos
     */
    protected function getAllowedMethods()
    {
        return ['POST'];
    }
}

// Executar API
try {
    $api = new ClienteCadastroApi();
    $api->processRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno do servidor',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE);
}
?>
